<?php

class ProductFilters {
	
	var $filter_values = array();
	
	var $default_values = array(
		"sort_column" => "price,asc",
		"producer" => 0
	);
	
	function ProductFilters($category_id = 0) {
		// teoretic ar trebui sa scoatem ce se mai poate filtra pe categoria asta (prioprietati, da mai incolo)

		// scoatem filtrele standard din sesiune... (daca ele sunt in sesiune)
		$this->loadFilterValue("sort_column");
		$this->loadFilterValue("from_price");
		$this->loadFilterValue("to_price");
		$this->loadFilterValue("in_stock");
		$this->loadFilterValue("special_offer");
		$this->loadFilterValue("producer");
		$this->loadFilterValue("search_string");
		
	}

	function getTextArray() {
		$return_arr = array();
		foreach ($this->filter_values as $k => $v) {
			if ($k != "sort_column" && $v != "") {
				if (!isset($this->default_values[$k]) || $this->default_values[$k] != $v) {
					$return_arr[$k] = array("text" => $this->getFilterText($k, $v), "value" => $v);
				}
			}
		}
		return $return_arr;
	}
	
	function getFilterText($name, $value) {
		switch ($name) {
			case "from_price":
				return "Pret de la: ".$value;
				break;
			case "to_price":
				return "Pret pana la: ".$value;
				break;
			case "in_stock":
				return "Doar produse in stoc!";
				break;
			case "special_offer":
				return "Doar oferte!";
				break;
			case "producer":
				$CI =& get_instance();
				$query = $CI->db->query("SELECT * FROM `producers` WHERE `id` = '$value' ");
				if ($query->num_rows() > 0) {
					$row = $query->row_array();
					return "Producator: ".$row["name"];
				}
				break;
			case "search_string":
				return "Cauta: ".$value;
				break;
		}
		return "";
	}
	
	function getFilterValues() {
		return $this->filter_values;
	}
	
	function getSortColumnValues() {
		return array(
			"price,ASC" => "Pret (crescator)",
			"price,DESC" => "Pret (descrescator)",
			"name,ASC" => "Denumire (alfabetic)",
			"code,ASC" => "Cod produs"
		);
	}
	
	function setFilterValue($name, $value) {
		$this->filter_values[$name] = $value;
		$CI =& get_instance();
		$CI->session->set_userdata('filters_'.$name, $value);
	}
	
	function getFilterValue($name) {
		if (isset($this->filter_values[$name])) {
			return $this->filter_values[$name];
		}
		return false;
	}
	
	function unsetFilter($name) {
		$CI =& get_instance();
		$CI->session->unset_userdata('filters_'.$name);
		if (isset($this->default_values[$name])) {
			$this->filter_values[$name] = $this->default_values[$name];
		} else {
			$this->filter_values[$name] = false;
		}
	}
	
	function loadFilterValue($name) {
		$CI =& get_instance();
		$val = $CI->session->userdata('filters_'.$name);
		if ($val !== false) {
			$this->filter_values[$name] = $val;
		} else {
			if (isset($this->default_values[$name])) {
				$this->filter_values[$name] = $this->default_values[$name];
			} else {
				$this->filter_values[$name] = false;
			}
		}
	}
	
}

?>