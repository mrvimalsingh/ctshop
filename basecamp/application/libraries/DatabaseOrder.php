<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DatabaseOrder {

	var $table_name;
	var $order_field = "order";
	var $id_field = "id";
	
	/**
	 * @param array $params
	 * 		- table_name (*required)
	 * 		- order_field (default: order)
	 * 		- id_field (default: id)
	 */
	function DatabaseOrder($params) {
		if (isset($params["order_field"])) {
			$this->order_field = $params["order_field"];
		}
		if (isset($params["id_field"])) {
			$this->id_field = $params["id_field"];
		}
		$this->table_name = $params["table_name"];
	}
	
	/**
	 *		direction: left|up, down|right
	 */
	function moveItem($item_id, $direction, $extra_where = "1") {
		$controller =& get_instance();
		
		// scoatem si order-ul vechi 
		$query = $controller->db->query("SELECT `".$this->order_field."` FROM `".$this->table_name."` WHERE `".$this->id_field."` = '$item_id' ");
		$row = $query->row_array();
		$old_order = $row["order"];
		
		if ($direction == "left" || $direction == "up") {
			$sql_function = "MAX";
			$sql_cmp = "<";
			$compare_result = -1;
			$sql_op = "+";
		} else if ($direction == "right" || $direction == "down") {
			$sql_function = "MIN";
			$sql_cmp = ">";
			$compare_result = 1;
			$sql_op = "-";
		} else {
			return false;
		}
		
		/* ################# */
		$query = $controller->db->query("
				SELECT $sql_function(`".$this->order_field."`) as mo
				FROM `".$this->table_name."` 
				WHERE $extra_where AND `".$this->order_field."` $sql_cmp '$old_order' ");
		$item_to_replace = $query->row_array();
		$new_order = $item_to_replace["mo"];
		
		if ($this->compare($new_order, $old_order) == $compare_result) {
			// itemul care trebuie inlocuit il punem cu orderul mai mic cu 1
			$controller->db->query("UPDATE `".$this->table_name."` SET `".$this->order_field."` = $new_order $sql_op 1 WHERE `order` = '$new_order' AND $extra_where ");
			// salvam itemul nostru cu orderul nou
			$controller->db->query("UPDATE `".$this->table_name."` SET `".$this->order_field."` = '$new_order' WHERE `".$this->id_field."` = '$item_id' ");
		}
		
		return true;
		
	}
	
	/**
	 * compares two items and returns the following
	 *  $left < $right - '-1'
	 *  $left = $right - '0'
	 *  $left > $right - '1'
	 */
	function compare($left, $right) {
		if ($left < $right) {
			return -1;
		}
		if ($left > $right) {
			return 1;
		}
		if ($left == $right) {
			return 0;
		}
		return false;
	}
	
}

?>