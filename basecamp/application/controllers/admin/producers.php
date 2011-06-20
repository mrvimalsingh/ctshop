<?php

class Producers extends MY_Controller {
	
	function Producers() {
		parent::MY_Controller();
	}
	
	function index() {
		
		$query = $this->db->query("SELECT * FROM `producers` WHERE 1");
		$data["producers"] = $query->result_array();
		
		$this->showMainTemplate("admin/producers", $data, true);
	}
	
	function add_producer() {
		$producer_name = mysql_real_escape_string($this->input->post('producer_name'));
		$producer_link = mysql_real_escape_string($this->input->post('producer_link'));
		$producer_desc = $this->input->post('producer_desc');
		
		$data = array(
			"name" => $producer_name,
			"web" => $producer_link,
			"description" => $producer_desc
		);
		
		$this->db->insert("producers", $data);
		redirect("admin/producers", 'location');
	}
	
	function delete($id) {
		$this->db->query("DELETE FROM `producers` WHERE `id` = '$id' ");
		redirect("admin/producers", 'location');
	}
	
}

?>