<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/


class Categories extends MY_Controller {
	
	function Categories()
	{
		parent::MY_Controller();
	}
	
	function index()
	{
		$data["selected_parent_category"] = 0;
		$data["category_ul_tree"] = $this->productcategory->getCategoryULTree(true);
		$this->showMainTemplate("admin/categories", $data, true);
	}
	
	function add() {
		$this->_save_internal();
		redirect('/admin/categories', 'location');
	}
	
	function update_category_parent($category, $parent) {
		$this->load->database();
		$this->db->query("UPDATE `categories` SET `parent_id` = '$parent' WHERE `id` = '$category' ");
	}
	
	function save_category() {
		$category_id = $this->_save_internal();
//		$category_id = $this->input->post('add_category_id');
		$this->_save_category_picture($category_id);
		redirect('/admin/categories/edit_category/'.$category_id, 'location');
	}
	
	function delete_category($cat_id) {
		// TODO aici va trebui sa facem cateva verificari... sa vedem daca se poate
		$this->db->query("DELETE FROM `categories` WHERE `id` = '$cat_id' ");
		$this->db->query("DELETE FROM `categories_lang` WHERE `category_id` = '$cat_id' ");
		redirect('/admin/categories', 'location');
	}
	
	function _save_category_picture($category_id) {
		if ($_FILES["file"]["error"] > 0)
		{
			//echo "Error: " . $_FILES["file"]["error"] . "<br />";
		}
		else
		{
			$this->load->library('image_lib'); 
			
			$config['image_library'] = 'gd2';
			$config['source_image']	= $_FILES["file"]["tmp_name"];
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = 100;
			$config['height']	= 100;
			$config['new_image'] = FCPATH."uploads/tmp_cat.jpg";
			
			$this->image_lib->initialize($config);
			
			if ( ! $this->image_lib->resize())
			{
			    echo $this->image_lib->display_errors();
			} else {
			}
				
			$content_thumbnail = addslashes(file_get_contents(FCPATH."uploads/tmp_cat.jpg"));
			
			$this->db->query("UPDATE `categories` SET 
										`img` = '$content_thumbnail'
								WHERE `id` = '$category_id' ");
		
		}
	}
	
	function _save_internal() {
		
		$category_id = $this->input->post('add_category_id');
		$name = $this->input->post('add_category_name');
		$parent_id = $this->input->post('add_category_parent');
		$keywords = $this->input->post('add_category_keywords');
		$short_desc = $this->input->post('add_category_short_desc');
		$description = $this->input->post('add_category_description');
		
		$parents_list = array();
		if ($this->_checkCircularDependency($category_id, $parent_id, $parents_list)) {
			$parent_id = 0;
			// TODO aici ar fi bine sa-i dam un mesaj de eroare...
		}
		
		$set = "`parent_id` = ".(($parent_id == 0)?"NULL":"'$parent_id'");
		
		if ($category_id > 0) {
			$query = $this->db->query("UPDATE `categories` SET 
										$set
										WHERE `id` = '$category_id' ");
		} else {
			$query = $this->db->query("INSERT INTO `categories` SET 
										$set ");
			$category_id = $this->db->insert_id();
		}
		
		foreach ($this->languages as $lang) {
			$set = "`name` = '".mysql_real_escape_string($name[$lang["id"]])."', 
				`keywords` = '".mysql_real_escape_string($keywords[$lang["id"]])."', 
				`short_desc` = '".mysql_real_escape_string($short_desc[$lang["id"]])."', 
				`description` = '".$description[$lang["id"]]."' ";
			$query = $this->db->query("INSERT INTO `categories_lang` SET 
											$set,
											`category_id` = '".$category_id."', 
											`lang_id` = '".$lang["id"]."'
										ON DUPLICATE KEY UPDATE $set ");
		}
		return $category_id;
	}
	
	function _checkCircularDependency($category_id, $parent_id, &$parents_list) {
		if ($category_id == $parent_id) {
			return true;
		}
		if (!$parent_id) {
			return false;
		}
		if (array_search($parent_id, $parents_list) !== false) {
			return true;
		}
		$parents_list[] = $parent_id;
		$query = $this->db->query("SELECT `parent_id` FROM `categories` WHERE `id` = '$parent_id' ");
		$category = $query->row_array();
		return $this->_checkCircularDependency($category_id, $category["parent_id"], $parents_list);
	}
	
	function edit_category($id = 0) {
//		echo "FCPATH: ".FCPATH."<br />";
		$this->load->helper('product_helper');
		
//		$data["categories"] = get_categories_rec();
		$data["categories"] = $this->productcategory->getCategoriesList();
		
		if ($id > 0) {
			$query = $this->db->query("SELECT * FROM `categories` WHERE `id` = '$id' ");
			$data["selected_category"] = $query->row_array();
			// scoatem prioprietatile
			$query = $this->db->query("SELECT 
											`p`.*,
											`pl`.`name`,
											`pl`.`description` 
										FROM 
											`product_property` as `p` 
											LEFT JOIN `product_property_lang` as `pl` 
												ON (`pl`.`property_id` = `p`.`id`) 
										WHERE 
											`pl`.`lang_id` = '".$this->lang_id."'
										ORDER BY 
											`p`.`order`");
			$data["all_properties"] = $query->result_array();
			// scoatem si legaturile...
			$query = $this->db->query("SELECT * FROM `product_property_re_category` WHERE `category_id` = '$id' ");
			$selected_properties = $query->result_array();
			// facem un array cu legaturile...
			$selected_property_ids = array();
			foreach ($selected_properties as $k => $v) {
				$selected_property_ids[] = $v["property_id"];
			}
//			echo "<pre>";
//			print_r($selected_property_ids);
//			echo "</pre>";
			$data["properties"] = array();
			foreach ($data["all_properties"] as $k => $v) {
				if (in_array($v["id"], $selected_property_ids)) {
					$data["properties"][] = $v;
				}
			}
		} else {
			$data["selected_category"]["id"] = "0";
			$data["selected_category"]["parent_id"] = "0";
		}
		
		foreach ($this->languages as $k => $lang) {
			$data["selected_category"][$lang["code"]] = getCategoryLang($id, $lang["id"]);
		}
		
		$this->showMainTemplate("admin/edit_category", $data, true);
	}
	
	function details($id) {
		$query = $this->db->query("SELECT * FROM `categories` WHERE `id` = '$id' ");
		echo json_encode($query->row_array());
	}
	
	function save_order() {
		
		$order = $this->input->post('order');
		
		foreach ($order as $cat_id => $ord) {
			$this->db->query("UPDATE `categories` SET `order` = '$ord' WHERE `id` = '$cat_id' ");
		}
		
		redirect('/admin/categories', 'location');
	}
	
	function add_re_property() {
		$category_id = mysql_real_escape_string($this->input->post('category_id'));
		$property_id = mysql_real_escape_string($this->input->post('property_id'));
		$this->db->query("REPLACE INTO 
								`product_property_re_category` 
							SET
								`property_id` = '".$property_id."', 
								`category_id` = '".$category_id."' ");
		redirect('/admin/categories/edit_category/'.$category_id, 'location');
	}
	
	function del_re_property($property_id, $category_id) {
		$this->db->query("DELETE FROM
								`product_property_re_category` 
							WHERE
								`property_id` = '".$property_id."'
								AND `category_id` = '".$category_id."' ");
		redirect('/admin/categories/edit_category/'.$category_id, 'location');
	}
	
}

?>