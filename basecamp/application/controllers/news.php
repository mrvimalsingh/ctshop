<?php

class News extends MY_Controller {
	
	function News() {
		parent::MY_Controller();
	}
	
	function index() {
		
		$query = $this->db->query("SELECT 
										id, title, keywords, content, 
										DATE_FORMAT(`date_added`, '%d/%m/%Y %T') as `date_added`
									FROM 
										`news` 
									WHERE 
										`lang_id` = '".$this->lang_id."' 
									ORDER BY `date_added` DESC 
									LIMIT 10");
		$data["news"] = $query->result_array();
		
		// scurtam si bagam '...'
		foreach ($data["news"] as $k => $v) {
			if (strlen($v["content"]) > 100) {
				$data["news"][$k]["content"] = substr($v["content"], 0, 100)."...";
			}
		}
		
		$this->setTemplateDataArr($data);
		$this->showMainTemplate("news");
	}
	
	function show($id) {
		$query = $this->db->query("SELECT id, title, keywords, content, 
										DATE_FORMAT(`date_added`, '%d/%m/%Y %T') as `date_added` FROM `news` WHERE `id` = '$id'");
		$data["news"] = $query->row_array();
		
		$this->setTemplateDataArr($data);
		$this->showMainTemplate("show_news");
	}
	
}