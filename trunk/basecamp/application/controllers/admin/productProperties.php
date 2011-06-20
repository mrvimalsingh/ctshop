<?php

class ProductProperties extends MY_Controller {
	
	function ProductProperties() {
		parent::MY_Controller();
	}
	
	function index() {
		$this->load->helper('language'); // TODO asta-i de bagat in autoload... cand se fac si celelalte pagini cu lang
		// scoatem toate prioprietatile si categoriile de prioprietati din baza de date
		$query = $this->db->query("SELECT 
										`pc`.*,
										`pcl`.`name` 
									FROM 
										`product_property_category` as `pc` 
										LEFT JOIN `product_property_category_lang` as `pcl` 
											ON (`pcl`.`property_category_id` = `pc`.`id`) 
									WHERE 
										`pcl`.`lang_id` = '".$this->lang_id."' 
									ORDER BY 
										`pc`.`order` ");
		$data["property_categories"] = $query->result_array();
		if ($query->num_rows() > 0) {
			foreach ($data["property_categories"] as $k => $v) {
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
												AND `p`.`property_category_id` = '".$v["id"]."' 
											ORDER BY 
												`p`.`order`");
				$data["property_categories"][$k]["properties"] = $query->result_array();
			}
		}
		
		$this->showMainTemplate("admin/productProperties", $data, true);
	}
	
	function add_property_category() {
		$property_category_name = $this->input->post('property_category_name');
		$property_category_id = $this->input->post('property_category_id');
		
		if ($property_category_id == 0) {
			// bagam o categorie noua...
			$query = $this->db->query("SELECT MAX(`order`) as `mo` FROM `product_property_category`");
			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$new_order = $row["mo"]+1;
			} else {
				$new_order = 0;
			}
			$query = $this->db->query("INSERT INTO `product_property_category` SET `order` = '$new_order' ");
			$property_category_id = $this->db->insert_id();
		}
		
		$languages_array = $this->languages;
		foreach ($languages_array as $lang) {
			$set = "`name` = '".mysql_real_escape_string($property_category_name[$lang["id"]])."' ";
			$query = $this->db->query("INSERT INTO `product_property_category_lang` SET 
											$set,
											`property_category_id` = '".$property_category_id."', 
											`lang_id` = '".$lang["id"]."'
										ON DUPLICATE KEY UPDATE $set ");
		}
		
		redirect('/admin/productProperties/', 'location');
	}
	
	function add_property() {
		$property_id = mysql_real_escape_string($this->input->post('property_id'));
		$property_category_id2 = $this->input->post('property_category_id2');
		$property_type = mysql_real_escape_string($this->input->post('property_type'));
		$property_um = mysql_real_escape_string($this->input->post('property_um'));
		$property_name = $this->input->post('property_name');
		$property_desc = $this->input->post('property_desc');
		
		$data = array(
			"property_category_id" => $property_category_id2,
			"type" => $property_type,
			"um" => $property_um
		);
		
		if ($property_id == 0) {
			// bagam o prioprietate noua...
			$query = $this->db->query("SELECT MAX(`order`) as `mo` FROM `product_property`");
			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$new_order = $row["mo"]+1;
			} else {
				$new_order = 0;
			}
			$data["order"] = $new_order;
			$query = $this->db->insert("product_property", $data);
			$property_id = $this->db->insert_id();
		} else {
			$query = $this->db->update("product_property", $data, "`id` = '$property_id'");
		}
		
		$languages_array = $this->languages;
		foreach ($languages_array as $lang) {
			$set = "`name` = '".mysql_real_escape_string($property_name[$lang["id"]])."',
					`description` = '".mysql_real_escape_string($property_desc[$lang["id"]])."' ";
			$query = $this->db->query("INSERT INTO `product_property_lang` SET 
											$set,
											`property_id` = '".$property_id."', 
											`lang_id` = '".$lang["id"]."'
										ON DUPLICATE KEY UPDATE $set ");
		}
		
		redirect('/admin/productProperties/', 'location');
	}
	
	function property_category_JSON($id) {
		$query = $this->db->query("SELECT * FROM `product_property_category_lang` WHERE `property_category_id` = '$id' ");
		$property_cat["lang"] = $query->result_array();
		echo json_encode($property_cat);
	}
	
	function property_JSON($id) {
		$query = $this->db->query("SELECT * FROM `product_property` WHERE `id` = '$id' ");
		$property = $query->row_array();
		$query = $this->db->query("SELECT * FROM `product_property_lang` WHERE `property_id` = '$id' ");
		$property["lang"] = $query->result_array();
		echo json_encode($property);
	}
	
	function get_all_properties_JSON() {
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
		$properties = $query->result_array();
		echo json_encode($properties);
	}
	
	function delete($type, $id) {
		$this->db->query("DELETE FROM `product_".$type."` WHERE `id` = '$id' ");
		$this->db->query("DELETE FROM `product_".$type."_lang` WHERE `".$type."_id` = '$id' ");
		redirect('/admin/productProperties/', 'location');
	}
	
	function move($type, $direction, $id) {
		$this->load->library('databaseOrder', array("table_name" => "product_$type"));
		$this->databaseorder->moveItem($id, $direction);
		redirect('/admin/productProperties/', 'location');
	}
	
}

?>