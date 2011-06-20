<?php

class DbGeneralSettings {
	
	var $settings = array(
		"table_name" => "general_settings",
		"key_field" => "key",
		"value_field" => "value"
	);
	
	function DbGeneralSettings($params = array()) {
		foreach ($params as $k => $v) {
			$this->settings[$k] = $v;
		}
	}
	
	function getKey($key) {
		$CI =& get_instance();
    	$query = $CI->db->query("SELECT `".$this->settings["value_field"]."` FROM `".$this->settings["table_name"]."` WHERE `".$this->settings["key_field"]."` = '$key' LIMIT 1 ");
    	if ($query->num_rows() > 0) {
    		$row = $query->row_array();
    		return $row[$this->settings["value_field"]];
    	}
    }
    
    function setKey($key, $value) {
    	$CI =& get_instance();
    	$CI->db->query("INSERT INTO 
    							`".$this->settings["table_name"]."` 
    						SET 
    							`".$this->settings["key_field"]."` = '$key',
    							`".$this->settings["value_field"]."` = '".$value."'
    						ON DUPLICATE KEY UPDATE 
    							`".$this->settings["value_field"]."` = '".$value."' ");
    }
	
}

?>