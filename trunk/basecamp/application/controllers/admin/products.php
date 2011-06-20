<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/

class Products extends MY_Controller {
	
	function Products()
	{
		parent::MY_Controller();
	}
	
	function index()
	{
		$this->load->helper('product_helper');
		$data["categories"] = $this->productcategory->getCategoriesList();
		$this->showMainTemplate("admin/products/products", $data, true);
	}
	
	function product_table($page = 1, $category_id = 0, $reducere = "n", $in_stoc = "n") {
		
		$this->load->library('pagination');
		$this->load->helper('product_helper');
		
		$where_arr = array();
		if ($category_id > 0) {
			$where_arr[] = "`prc`.`category_id` = '$category_id' ";
		}
		if ($reducere == 'y') {
			// TODO aici vine o filtrare un pic mai complicata
		}
		if ($in_stoc == 'y') {
			$where_arr[] = "`p`.`in_stock` = 'y' ";
		}
		
		$where_string = implode(" AND ", $where_arr);
		if ($where_string == "") {
			$where_string = "1";
		}
//		echo "WHERE: $where_string";
		$query = $this->db->query("SELECT 
										COUNT(`p`.`id`) as `rc` 
									FROM 
										`products` as `p` 
										LEFT JOIN `products_re_categories` as `prc`
											ON (`prc`.`product_id` = `p`.`id`)
									WHERE $where_string ");
		$row = $query->row_array();
		
		$config['base_url'] = site_url("admin/products/product_table")."/";
		$config['total_rows'] = $row["rc"];
		$config['per_page'] = 20;
		$config["page_query_string"] = FALSE;
		$config['uri_segment'] = 4;
		$config["js_function"] = "loadProducts";
		
		$this->pagination->initialize($config);
		
		$data["pagination_links"] = $this->pagination->create_links(true);
		
//		echo $this->pagination->cur_page;
		
		$ofset = ($this->pagination->cur_page-1) * $config['per_page'];
		if ($ofset < 0) {
			$ofset = 0;
		}
		$query = $this->db->query("SELECT `p`.* FROM 
										`products` as `p` 
										LEFT JOIN `products_re_categories` as `prc`
											ON (`prc`.`product_id` = `p`.`id`)
									WHERE $where_string LIMIT $ofset, ".$config["per_page"] );
		$data["products"] = $query->result_array();
		
		foreach ($data["products"] as $k => $v) {
			$prod_lang = getProductLang($v["id"], $this->lang_id);
			$data["products"][$k]["name"] = $prod_lang["name"];
		}
		
		$this->load->view('admin/products/product_table', $data);
		
	}
	
	function search_product_code($q = "") {
		$query = $this->db->query("SELECT
										`p`.`id`, 
										`p`.`code`, 
										`l`.`name` 
									FROM 
										`products` as `p` 
										LEFT JOIN `products_lang` as `l`
											ON (`p`.`id` = `l`.`product_id`)
									WHERE 
										`l`.`language_id` = '".$this->lang_id."'
										AND `p`.`code` LIKE '%$q%'
									LIMIT 15");
		$prod = $query->result_array();
		foreach ($prod as $p) {
			echo "(".$p["code"].") ".$p["name"]."|".$p["id"]."\n";
		}
	}
	
	function check_code($code) {
		
		$query = $this->db->query("SELECT COUNT(*) as `rows` FROM `products` WHERE `code` = '$code' ");
		echo json_encode($query->row_array());
		
	}
	
	function add_product() {
		
		$product_code = mysql_real_escape_string($this->input->post('add_product_code'));
//		$product_name = mysql_real_escape_string($this->input->post('add_product_name'));
//		
//		$set = "`code` = '$product_code', 
//				`name` = '$product_name' ";
		
		$query = $this->db->query("INSERT INTO `products` SET `code` = '$product_code' ");
		$product_id = $this->db->insert_id();
		
		redirect('/admin/products/edit_product/'.$product_id, 'location');
		
	}
	
	function edit_product($id) {
		
		$data["categories"] = $this->productcategory->getCategoriesList();
		
		$query = $this->db->query("SELECT * FROM `products` WHERE `id` = '$id' ");
		$data["product"] = $query->row_array();
		
		foreach ($this->languages as $k => $lang) {
			$data["product"][$lang["code"]] = getProductLang($id, $lang["id"]);
		}
		$data["product"]["discount"] = getProductDiscount($id);
		$data["product"]["discount"]["calculated_price"] = number_format($data["product"]["price"] * (1-$data["product"]["discount"]["value"]/100), 2, '.', '');
		
		// scoatem si producatorii
		$query = $this->db->query("SELECT * FROM `producers` WHERE 1");
		$data["producers"] = $query->result_array();
		
		$this->showMainTemplate("admin/products/edit_product", $data, true);
	}
	
	function get_re_categories($product_id) {
		$query = $this->db->query("SELECT `c`.*, `rc`.`id` as `re_id` FROM `products_re_categories` as `rc` LEFT JOIN `categories` as `c` ON (`rc`.`category_id` = `c`.`id`) WHERE `rc`.`product_id` = '$product_id' ");
		$categories = $query->result_array();
		foreach ($categories as $k => $v) {
			$cat_lang = getCategoryLang($v["id"]);
			$categories[$k]["name"] = $cat_lang["name"];
		}
		echo json_encode($categories);
	}
	
	function add_re_category($product_id, $cat_id){
		$this->db->query("INSERT INTO `products_re_categories` SET `product_id` = '$product_id', `category_id` = '$cat_id' ");
	}
	
	function del_re_category($id) {
		$this->db->query("DELETE FROM `products_re_categories` WHERE `id` = '$id' ");
	}
	
	function save_product() {
		
		$product_id = mysql_real_escape_string($this->input->post('product_id'));
		$product_code = mysql_real_escape_string($this->input->post('product_code'));
		$product_featured = mysql_real_escape_string($this->input->post('product_featured'));
		$product_in_stock = mysql_real_escape_string($this->input->post('product_in_stock'));
		$product_available_online = mysql_real_escape_string($this->input->post('product_available_online'));
		$product_appear_on_site = mysql_real_escape_string($this->input->post('product_appear_on_site'));
		$product_name = $this->input->post('product_name');
		$product_price = mysql_real_escape_string($this->input->post('product_price'));
		$product_keywords = $this->input->post('product_keywords');
		$product_short_desc = $this->input->post('product_short_desc');
		$product_desc = $this->input->post('product_desc');
		$product_discount_date_start = mysql_real_escape_string($this->input->post('product_discount_date_start'));
		$product_discount_date_end = mysql_real_escape_string($this->input->post('product_discount_date_end'));
		$product_discount_value = mysql_real_escape_string($this->input->post('product_discount_value'));
		$product_producer = mysql_real_escape_string($this->input->post('product_producer'));
		if ($product_producer == "0") {
			$product_producer = "NULL";
		}
		
		$set = "`code` = '$product_code', 
				`price` = '$product_price',
				`featured` = '".$product_featured."',
				`in_stock` = '".$product_in_stock."',
				`available_online` = '".$product_available_online."',
				`appear_on_site` = '".$product_appear_on_site."',
				`producer_id` = $product_producer ";
		
		$query = $this->db->query("UPDATE `products` SET 
									$set
									WHERE `id` = '$product_id' ");
		
		// salvam chestiile legate de limba...
		$languages_array = $this->languages;
		foreach ($languages_array as $lang) {
			$set = "`name` = '".mysql_real_escape_string($product_name[$lang["id"]])."', 
				`description` = '".mysql_real_escape_string($product_desc[$lang["id"]])."', 
				`short_desc` = '".mysql_real_escape_string($product_short_desc[$lang["id"]])."', 
				`keywords` = '".mysql_real_escape_string($product_keywords[$lang["id"]])."' ";
			$query = $this->db->query("INSERT INTO `products_lang` SET 
											$set,
											`product_id` = '".$product_id."', 
											`language_id` = '".$lang["id"]."'
										ON DUPLICATE KEY UPDATE $set ");
		}
		
		// salvam discount-ul
		// pregatim datele ce trebuie bagate
		$discount_data = array(
               'start_date' => $product_discount_date_start ,
               'end_date' => $product_discount_date_end ,
               'value' => $product_discount_value,
				'product_id' => $product_id
            );
		// intai verificam daca mai are sa-l suprascriem (deocamdata asha... mai incolo o sa fie mai multe poate si planificate din timp)
		$query = $this->db->query("SELECT `id` FROM `products_discount` WHERE `product_id` = '$product_id' ");
		if ($query->num_rows() > 0) {
			// facem update
			if ($product_discount_value == 0) {
				// trebuie sa-l stergem
				$this->db->query("DELETE FROM `products_discount` WHERE `product_id` = '$product_id' ");
			} else {
				$row = $query->row_array();
				$this->db->update('products_discount', $discount_data, "`id` = '".$row["id"]."'"); 
			}
		} else {
			// facem insert
			$this->db->insert('products_discount', $discount_data); 
		}
									
		redirect('/admin/products/edit_product/'.$product_id, 'location');
	}
	
	function pictures($product_id) {
		$query = $this->db->query("SELECT 
										`p`.`id`, 
										`p`.`main`, 
										`p`.`order`,
										`pl`.`name` 
									FROM 
										`product_pictures` as `p`
										LEFT JOIN `product_pictures_lang` as `pl` 
											ON (`pl`.`picture_id` = `p`.`id`)  
									WHERE 
										`p`.`product_id` = '$product_id' 
										AND `pl`.`lang_id` = '".$this->lang_id."'
									ORDER BY `order` ");
		$data["pictures"] = $query->result_array();
		
		foreach ($data["pictures"] as $k => $v) {
			$data["pictures"][$k]["lang"] = $this->_get_image_lang($v["id"]);
		}
		$data["product_id"] = $product_id;
		$data["languages_array"] = $this->languages;
		$this->load->view('admin/products/product_pictures', $data);
	}
	
	function _get_image_lang($picture_id) {
		$result = array();
		$query = $this->db->query("SELECT * FROM `product_pictures_lang` WHERE `picture_id` = '$picture_id' ");
		$rows = $query->result_array();
		foreach ($rows as $row) {
			$result[$row["lang_id"]]["name"] = $row["name"];
		}
		return $result;
	}
	
	function updatePic($product_id, $picture_id, $action) {
		
		if ($action == "del") {
			$this->db->query("DELETE FROM `product_pictures` WHERE `id` = '$picture_id' ");
			$this->db->query("DELETE FROM `product_pictures_lang` WHERE `picture_id` = '$picture_id' ");
			
			// stergem si fisierele
			$this->config->load('myconf');
			$base_dir = $this->config->item("site_base_dir");
			
			unlink($base_dir."uploads/product_images/thumbnail/$picture_id.jpg");
			unlink($base_dir."uploads/product_images/medium/$picture_id.jpg");
			unlink($base_dir."uploads/product_images/big/$picture_id.jpg");
			
		} else if ($action == "left") {
			// scoatem cel mai mare order mai mic decat al imagini in cauza
			$query = $this->db->query("
					SELECT MAX(`order`) as mo
					FROM `product_pictures` 
					WHERE `product_id` = '$product_id' AND `order` < 
							(SELECT `order` FROM `product_pictures` WHERE `id` = '$picture_id') ");
			$pic_to_replace = $query->row_array();
			// scoatem si order-ul vechi 
			$query = $this->db->query("SELECT `order` FROM `product_pictures` WHERE `id` = '$picture_id' ");
			$row = $query->row_array();
			
			$old_order = $row["order"];
			$new_order = $pic_to_replace["mo"];
			
			if ($new_order < $old_order) {
				// imaginea care trebuie inlocuita il punem cu orderul mai mare cu 1
				$this->db->query("UPDATE `product_pictures` SET `order` = '".($new_order+1)."' WHERE `order` = '$new_order' AND `product_id` = '$product_id' ");
				// salvam imaginea noastra cu orderul nou
				$this->db->query("UPDATE `product_pictures` SET `order` = '$new_order' WHERE `id` = '$picture_id' ");
			}
		} else if ($action == "right") {
			// scoatem cel mai mic order mai mare decat al imagini in cauza
			$query = $this->db->query("
					SELECT MIN(`order`) as mo
					FROM `product_pictures` 
					WHERE `product_id` = '$product_id' AND `order` > 
							(SELECT `order` FROM `product_pictures` WHERE `id` = '$picture_id') ");
			$pic_to_replace = $query->row_array();
			// scoatem si order-ul vechi 
			$query = $this->db->query("SELECT `order` FROM `product_pictures` WHERE `id` = '$picture_id' ");
			$row = $query->row_array();
			
			$old_order = $row["order"];
			$new_order = $pic_to_replace["mo"];
			
			if ($new_order > $old_order) {
				// imaginea care trebuie inlocuita il punem cu orderul mai mic cu 1
				$this->db->query("UPDATE `product_pictures` SET `order` = '".($new_order-1)."' WHERE `order` = '$new_order' AND `product_id` = '$product_id' ");
				// salvam imaginea noastra cu orderul nou
				$this->db->query("UPDATE `product_pictures` SET `order` = '$new_order' WHERE `id` = '$picture_id' ");
			}
			
		} else if ($action == "update_lang") {
			$name = $this->input->post('name');
//			print_r($name);
			$query = $this->db->query("SELECT * FROM `languages` WHERE 1 ");
			$languages = $query->result_array();
			foreach ($languages as $k => $lang) {
				$pic_name = mysql_real_escape_string($name[$lang["id"]]);
				$this->db->query("INSERT INTO `product_pictures_lang` SET 
										`picture_id` = '$picture_id',
										`lang_id` = '".$lang["id"]."',
										`name` = '$pic_name'
									ON DUPLICATE KEY UPDATE 
										`name` = '$pic_name' ");
			}
		}
		
	}
	
	function image_upload_form($product_id) {
		$query = $this->db->query("SELECT * FROM `languages` WHERE 1 ");
		$this->load->view('admin/image_upload', array("type" => "products", "type_id" => $product_id, "languages_array" => $query->result_array()));
	}
	
	function upload_image($product_id) {
		if ($_FILES["file"]["error"] > 0)
		{
			//echo "Error: " . $_FILES["file"]["error"] . "<br />";
		}
		else
		{
			$query = $this->db->query("SELECT MAX(`order`) as mo FROM `product_pictures` WHERE `product_id` = '$product_id'");
			$row = $query->row_array();
			
			$this->db->query("INSERT INTO `product_pictures` SET 
										`product_id` = '$product_id',
										`order` = '".($row["mo"]+1)."' ");
			
			$image_id = $this->db->insert_id();
			
			$name = $this->input->post('name');
			$query = $this->db->query("SELECT * FROM `languages` WHERE 1 ");
			$languages = $query->result_array();
			foreach ($languages as $k => $lang) {
				$pic_name = mysql_real_escape_string($name[$lang["id"]]);
				$this->db->query("INSERT INTO `product_pictures_lang` SET 
										`picture_id` = '$image_id',
										`lang_id` = '".$lang["id"]."',
										`name` = '$pic_name'
									ON DUPLICATE KEY UPDATE 
										`name` = '$pic_name' ");
			}
			
			$this->load->library('image_lib'); 
			
			$this->_create_thumb(80, 80, "thumbnail", $image_id);
			$this->_create_thumb(250, 250, "medium", $image_id);
			$this->_create_thumb(800, 800, "big", $image_id);
			
			redirect('admin/products/image_upload_form/'.$product_id, 'location');

		}
	}
	
	function properties_table($product_id) {
		$data["properties"] = array();
		$this->load->helper('misc_helper');
		// trebuie sa scoatem toate categoriile la care se leaga si sa bagam toate prioprietatile
		// si sa le organizam pe categorii, dupa care scoatem valorile...
		$query = $this->db->query("SELECT * FROM `products_re_categories` WHERE `product_id` = '$product_id' ");
		$product_categories = $query->result_array();
		if ($query->num_rows() > 0) {
			$categories = array();
			foreach ($product_categories as $k => $v) { 
				$categories[] = $v["category_id"];
			}
			$categories = implode("', '", $categories);
			$sql = "SELECT 
						`p`.*,
						`prc`.`property_id`, 
						`pl`.`name`,
						`pl`.`description` 
					FROM 
						`product_property_re_category` as `prc`
						LEFT JOIN `product_property` as `p` 
							ON (`prc`.`property_id` = `p`.`id`)
						LEFT JOIN `product_property_lang` as `pl` 
							ON (`pl`.`property_id` = `p`.`id`) 
					WHERE 
						`prc`.`category_id` IN ('".$categories."')
						AND `pl`.`lang_id` = '".$this->lang_id."'
					ORDER BY 
						`p`.`order`";
//			echo "sql= ".$sql."<br />";
			$query = $this->db->query($sql);
			
			$data["properties"] = $query->result_array();
		}
		
		// scoatem valorile la prioprietati
		foreach ($data["properties"] as $k => $v) {
			$query = $this->db->query("SELECT 
									`pvp`.*,
									`pv`.`id` as `property_value_id`,
									`pv`.`numeric_value`,
									`pv`.`yes_no_value`,
									`pvl`.`value` 
								FROM 
									`product_property_values_re_product` as `pvp`
									LEFT JOIN `product_property_values` as `pv`
										ON (`pvp`.`property_values_id` = `pv`.`id`) 
									LEFT OUTER JOIN `product_property_values_lang` as `pvl`
										ON (`pvl`.`property_value_id` = `pv`.`id`) 
								WHERE 
									`pvp`.`product_id` = '$product_id'
									AND `pv`.`property_id` = '".$v["id"]."' 
									AND (`pvl`.`lang_id` = '".$this->lang_id."' OR `pvl`.`value` IS NULL) ");
			if ($query->num_rows() > 0) {
				if ($query->num_rows() > 1) {
					$data["properties"][$k]["values"] = $query->result_array();
				} else {
					$data["properties"][$k]["value"] = $query->row_array();
				}
			}
		}
		
		$this->load->view('admin/products/properties_table', $data);
	}
	
	function add_property_value($product_id) {
		
		$property_id = mysql_real_escape_string($this->input->post('property_id'));
		$product_re_property_id = mysql_real_escape_string($this->input->post('product_re_property_id'));
		$numeric_value = mysql_real_escape_string($this->input->post('numeric_value'));
		$yes_no_value = mysql_real_escape_string($this->input->post('yes_no_value'));
		$change_price = mysql_real_escape_string($this->input->post('change_price'));
		$change_price_value = mysql_real_escape_string($this->input->post('change_price_value'));
		$prop_value = $this->input->post('prop_value');
		
		// aici ii un pic mai ciudat cu property value id...
		// scoatem daca exista din baza de date id-ul valorii (daca exista, daca nu il creem)
		// si daca id-ul valorii nu este egala cu id-ul valorii care-i transmis trebuie verificat daca-i de sters valoarea veche...
		// ca poate se mai leaga altceva de el...

		$existing_property_value_id = $this->_check_property_value($property_id, $numeric_value, $yes_no_value, $prop_value);
		
		if ($existing_property_value_id == 0) {
			// trebuie sa bagam valoarea
			$yes_no_value = ($yes_no_value)?"y":"n";
			$data = array(
					"property_id" => $property_id,
					"numeric_value" => $numeric_value,
					"yes_no_value" => $yes_no_value
				);
			$this->db->insert("product_property_values", $data);
			// si lang-ul
			$existing_property_value_id = $this->db->insert_id(); 
			$languages_array = $this->languages;
			foreach ($languages_array as $lang) {
				if (trim($prop_value[$lang["id"]]) != "") {
					$set = "`value` = '".mysql_real_escape_string($prop_value[$lang["id"]])."' ";
					$query = $this->db->query("INSERT INTO `product_property_values_lang` SET 
													$set,
													`property_value_id` = '".$existing_property_value_id."', 
													`lang_id` = '".$lang["id"]."'
												ON DUPLICATE KEY UPDATE $set ");
				}
			}
		}
		
		// salvam legatura
		$data = array(
			"property_values_id" => $existing_property_value_id,
			"product_id" => $product_id,
			"change_price" => $change_price,
			"change_price_value" => $change_price_value,
		);
		if ($product_re_property_id > 0) {
			// editam legatura
			$this->db->update("product_property_values_re_product", $data, "`id` = '$product_re_property_id'");
		} else {
			// bagam o legatura noua
			$this->db->insert("product_property_values_re_product", $data);
		}
		
	}
	
	function _check_property_value($property_id, $numeric_value, $yes_no_value, $prop_value) {
		
		// scoatem ce tip de prioprietate ii si facem verificarei in functie de aia...
		$query = $this->db->query("SELECT `type` FROM `product_property` WHERE `id` = '$property_id' ");
		if ($query->num_rows() == 0) {
			return 0;
		}
		$row = $query->row_array();
		$property_type = $row["type"];
		
		$where_arr = array();
		
		if ($property_type == "numeric") {
			$where_arr[] = "`numeric_value` = '$numeric_value'";
		}
		
		if ($property_type == "yes_no") {
			$where_arr[] = "`yes_no_value` = '$yes_no_value'";
		}
		
		if (is_array($prop_value)) {
			// verificam si dupa value
			foreach ($prop_value as $lang_id => $val) {
				if (trim($val) != "") {
					$where_arr[] = "(SELECT `value` FROM `product_property_values_lang` WHERE `property_value_id` = `pvid` AND `lang_id` = '$lang_id') = '".mysql_real_escape_string($val)."' ";
				} else {
					$where_arr[] = "(SELECT COUNT(*) FROM `product_property_values_lang` WHERE `property_value_id` = `pvid` AND `lang_id` = '$lang_id') = 0 ";
				}
			}
		} else {
			// ne asiguram ca nu-i setat nimic in lang... ca daca ii, atunci ii altceva...
			$where_arr[] = "(SELECT COUNT(*) FROM `product_property_values_lang` WHERE `property_value_id` = `pvid`) = 0";
		}
		
		if (count($where_arr) == 0) {
			$where_arr[] = "1";
		}
		$where = implode(" AND ", $where_arr);
		$query = $this->db->query("SELECT `id` as `pvid` FROM `product_property_values` WHERE $where ");
		
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			return $row["id"];
		}
		
		return 0;
	}
	
	function delete_product_property($product_re_property) {
		$this->db->query("DELETE FROM `product_property_values_re_product` WHERE `id` = '$product_re_property' ");
		// TODO aici teoretic ar trebui sa verificam daca mai este legat de ceva valoarea...
		// eventual facem pe undeva in administrare sa se poata sterge 
	}
	
	function product_re_property_JSON($product_re_property) {
		$query = $this->db->query("SELECT * FROM `product_property_values_re_product` WHERE `id` = '$product_re_property' ");
		$row = $query->row_array();
		$query = $this->db->query("SELECT * FROM `product_property_values` WHERE `id` = '".$row["property_values_id"]."' ");
		$row["value"] = $query->row_array();
		$query = $this->db->query("SELECT * FROM `product_property_values_lang` WHERE `property_value_id` = '".$row["property_values_id"]."' ");
		$row["lang"] = $query->result_array();
		echo json_encode($row);
	}
	
	function _create_thumb($width, $height, $type, $image_id) {
		
		$this->config->load('myconf');
		$base_dir = $this->config->item("site_base_dir");
		
		$config['image_library'] = 'gd2';
		$config['source_image']	= $_FILES["file"]["tmp_name"];
		$config['maintain_ratio'] = TRUE;
		$config['width']	 = $width;
		$config['height']	= $height;
		$config['new_image'] = $base_dir."uploads/product_images/$type/$image_id.jpg";
		
		$this->image_lib->initialize($config);
		
		if ( ! $this->image_lib->resize())
		{
		    echo $this->image_lib->display_errors();
		} else {
		}
		$this->image_lib->clear();
	}
	
}

?>