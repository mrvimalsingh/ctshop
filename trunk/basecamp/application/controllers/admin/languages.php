<?php

class Languages extends MY_Controller {
	
	function Languages() {
		parent::MY_Controller();
	}
	
	function index() {
		
		$query = $this->db->query("SELECT * FROM `languages` WHERE 1 ");
		$data["languages"] = $query->result_array();
		$this->showMainTemplate("admin/languages", $data, true);
	}
	
	function add_lang() {
		
		$add_code = mysql_real_escape_string($this->input->post('add_code'));
		$add_name = mysql_real_escape_string($this->input->post('add_name'));
		$add_default = ($this->input->post('add_default')?"y":"n");
		$add_admin_default = ($this->input->post('add_admin_default')?"y":"n");
		
		$sql_arr = array(
			"code" => "$add_code",
			"name" => "$add_name",
			"default" => "$add_default",
			"admin_default" => "$add_admin_default"
		);
		
		// daca-i default trebuie sa le facem pe celelalte sa nu fie
		if ($add_default == "y") {
			$this->db->query("UPDATE `languages` SET `default` = 'n' ");
		}
		if ($add_admin_default == "y") {
			$this->db->query("UPDATE `languages` SET `admin_default` = 'n' ");
		}
		
		$query = $this->db->query("SELECT `id` FROM `languages` WHERE `code` = '$add_code' ");
		if ($query->num_rows() > 0) {
			// facem update
			$row = $query->row_array();
			$where = "`id` = '".$row["id"]."'"; 
			$str = $this->db->update_string('languages', $sql_arr, $where);
			$this->db->query($str);
		} else {
			// facem insert
			$str = $this->db->insert_string('languages', $sql_arr);
			$this->db->query($str);
		}
		
		redirect('/admin/languages', 'location');
	}
	
	function make_default($id) {
		$this->db->query("UPDATE `languages` SET `default` = 'n' ");
		$this->db->query("UPDATE `languages` SET `default` = 'y' WHERE `id` = '$id' ");
		redirect('/admin/languages', 'location');
	}
	
	function delete_lang($id) {
		$this->db->query("DELETE FROM `languages` WHERE `id` = '$id' ");
		redirect('/admin/languages', 'location');
	}
	
}

?>