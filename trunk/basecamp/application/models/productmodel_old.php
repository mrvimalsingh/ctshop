<?php

class Productmodel_old extends Model {
	
	var $id;
	var $code;
	var $producer_id;
	var $price;
	var $in_stock;
	var $available_online;
	var $appear_on_site;
	var $featured;
	
	// imaginile produsului
	var $main_picture;
	var $pictures;
	
	var $product_discounts; // TODO asta mai trebuie analizat...
	
	var $lang = array(); // asta-i array-ul care contine toate limbile pentru produs...
	
	// astea-s in limba default...
	var $name;
	var $keywords;
	var $description;
	var $short_desc;
	
	// TODO de bagat si prioprietatile produsului aici pe undeva...
	var $properties;
	
	function Productmodel() {
		parent::Model();
	}

	function getProductListSQL($category_id, $filter_values, $count = false, $offset = 0, $rows = 0, $extra_where = "") {
		$sorting = "`p`.`price` ASC";
		$where_array = array();
		
		if ($category_id > 0) {
			$where_array[] = "`prc`.`category_id` = '$category_id'";
		}
		if ($extra_where != "") {
			$where_array[] = $extra_where;
		}
//		echo "<pre>";
//		print_r($filter_values);
//		echo "</pre>";
		foreach ($filter_values as $filter_name => $filter_value) {
			if ($filter_value !== false && $filter_value != "") {
				switch ($filter_name) {
					case "from_price":
						$where_array[] = "`p`.`price` >= '$filter_value'";
						break;
					case "to_price":
						$where_array[] = "`p`.`price` <= '$filter_value'";
						break;
					case "in_stock":
						$where_array[] = "`p`.`in_stock` = 'y'";
						break;
					case "special_offer":
						// TODO asta trebuie vazut
						break;
					case "producer":
						if ($filter_value > 0) {
							$where_array[] = "`p`.`producer_id` = '$filter_value'";
						}
						break;
					case "search_string":
						$where_array[] = "`pl`.`name` LIKE '%$filter_value%'";
						break;
					case "sort_column":
						$sorting_arr = explode(",", $filter_value);
						if ($sorting_arr[0] == "name") {
							$sorting = "`pl`.`name` ASC";
						} else {
							$sorting = "`p`.`".$sorting_arr[0]."` ".$sorting_arr[1];
						}
						break;
				}
			}
		}
		
		$where_string = implode(" AND ", $where_array);
		
		if (trim($where_string) == "") {
			$where_string = "1";
		}
		
		if ($offset < 0) {
			$offset = 0;
		}
		
		$sql = "SELECT 
					".($count?"COUNT(`p`.`id`) as `rc`":"`p`.*")." 
				FROM 
					`products` as `p`
					LEFT JOIN `products_re_categories` as `prc` 
						ON (`prc`.`product_id` = `p`.`id`) 
					LEFT JOIN `products_lang` as `pl` 
						ON (`pl`.`product_id` = `p`.`id`)
				WHERE 
					`p`.`appear_on_site` = 'y' 
					AND `pl`.`language_id` = '".$this->lang_id."' 
					AND $where_string
				".($count?"":"ORDER BY $sorting LIMIT $offset, $rows");
//		echo "sql= ".$sql."<br />";
		return $sql;
	}
	
	function countProducts($category_id, $filter_values, $extra_where = "") {
		$query = $this->db->query($this->getProductListSQL($category_id, $filter_values, true, 0, 0, $extra_where));
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			return $row["rc"];
		}
		return 0;
	}
	
	function getProductList($category_id, $filter_values, $offset, $rows, $extra_where = "") {
		$query = $this->db->query($this->getProductListSQL($category_id, $filter_values, false, $offset, $rows, $extra_where));
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			foreach ($result as $k => $v) {
				$result[$k]["image_id"] = getProductMainImage($v["id"]);
				$prod_lang = getProductLang($v["id"]);
				$result[$k]["name"] = $prod_lang["name"];
				$result[$k]["short_desc"] = $prod_lang["short_desc"];
				$result[$k]["price"] = number_format($result[$k]["price"], 2, ".", "");
			}
		} else {
			$result = array();
		}
		return $result;
	}
	
	function load_product($id) {
		$query = $this->db->query("
				SELECT 
					`p`.*,
					`pl`.`name`,
					`pl`.`keywords`,
					`pl`.`description`,
					`pl`.`short_desc`
				FROM
					`products` as `p`
					LEFT JOIN `products_lang` as `pl` 
						ON (`pl`.`product_id` = `p`.`id`)
				WHERE 
					`p`.`id` = '$id'
					AND `pl`.`language_id` = '".$this->lang_id."'  
			");
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			foreach ($row as $key => $val) {
//				echo "$key => $val <br />";
                $this->{$key} = $val;
	        }
		}
		
		// scoatem imaginile...
		$query = $this->db->query("SELECT
										`p`.*,
										`pl`.`name` 
									FROM 
										`product_pictures` as `p`
										LEFT JOIN `product_pictures_lang` as `pl` 
											ON (`pl`.`picture_id` = `p`.`id`)
									WHERE 
										`p`.`product_id` = '$id'
										AND `pl`.`lang_id` = '".$this->lang_id."' 
									ORDER BY `order`");
		if ($query->num_rows() > 0) {
			$this->pictures = $query->result_array();
			$found = false;
			foreach ($this->pictures as $k => $v) {
				if ($v["main"] == "y") {
					// trebuie bagat la main_picture
					$this->main_picture = $v;
					unset($this->pictures[$k]);
					$found = true;
					break;
				}
			}
			if ($found === false) {
				$this->main_picture = array_shift($this->pictures);
			}
		}
		
		// scoatem discountul, daca are si calculam pretul cu discount
		$query = $this->db->query("SELECT 
										* 
									FROM 
										`products_discount`
									WHERE
										`product_id` = '$id' 
										AND `start_date` <= CURDATE()
										AND `end_date` >= CURDATE() 
									LIMIT 1");
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$this->discount_price = number_format($this->price * (1 - $row["value"]/100), 2, ".", "");
			$this->discount_value = $row["value"];
		} else {
			$this->discount_price = $this->price;
			$this->discount_value = 0;
		}
		
		$this->use_discount = ($this->discount_value > 0);
		
		return $this;
	}
	
	function load_product_languages() {
		// daca apelam functie asta se presupune ca am incarcat deja produsul... si avem $id
		if (!$this->id) {
			return false;
		}
	}
	
	function load_product_properties() {
		// daca apelam functie asta se presupune ca am incarcat deja produsul... si avem $id
		if (!$this->id) {
			return false;
		}
	}
	
	function return_array() {
		$return_value = array();
		$return_value["id"] = $this->id;
		$return_value["code"] = $this->code;
		$return_value["producer_id"] = $this->producer_id;
		$return_value["price"] = $this->price;
		$return_value["use_discount"] = $this->use_discount;
		$return_value["discount_price"] = $this->discount_price;
		$return_value["discount_value"] = $this->discount_value;
		$return_value["in_stock"] = $this->in_stock;
		$return_value["available_online"] = $this->available_online;
		$return_value["appear_on_site"] = $this->appear_on_site;
		$return_value["featured"] = $this->featured;
		$return_value["main_picture"] = $this->main_picture;
		$return_value["pictures"] = $this->pictures;
		$return_value["product_discounts"] = $this->product_discounts;
		$return_value["lang"] = $this->lang;
		$return_value["name"] = $this->name;
		$return_value["keywords"] = $this->keywords;
		$return_value["description"] = $this->description;
		$return_value["short_desc"] = $this->short_desc;
		$return_value["properties"] = $this->properties;
		return $return_value;
	}
	
}

?>