<?php

class News extends MY_Controller {
	
	function News() {
		parent::MY_Controller();
	}
	
	function index() {
		$query = $this->db->query("SELECT 
										`n`.*,
										`l`.`name` as `language_name`
									FROM 
										`news` as `n`
										LEFT JOIN `languages` as `l`
											ON (`l`.`id` = `n`.`lang_id`)
									WHERE 1 
									ORDER BY `date_added`");
		$data["news"] = $query->result_array();
		$this->showMainTemplate("admin/news", $data, true);
	}
	
	function edit($id = 0) {
		if ($id > 0) {
			// scoatem din baza de date ca trebuie sa editam
			$query = $this->db->query("SELECT * FROM `news` WHERE `id` = '$id' ");
			$data["news"] = $query->row_array();
		} else {
			$data["news"]["id"] = 0;
			$data["news"]["title"] = "";
			$data["news"]["keywords"] = "";
			$data["news"]["content"] = "";
			$data["news"]["lang_id"] = "";
		}
		$data["languages_array"] = $this->languages;
		
		$this->showMainTemplate("admin/edit_news", $data, true);
	}
	
	function save() {
		$news_id = mysql_real_escape_string($this->input->post('news_id'));
		$news_title = mysql_real_escape_string($this->input->post('news_title'));
		$news_lang = mysql_real_escape_string($this->input->post('news_lang'));
		$news_keywords = mysql_real_escape_string($this->input->post('news_keywords'));
		$news_content = $this->input->post('news_content');
		
		$data = array(
			"title" => $news_title,
			"lang_id" => $news_lang,
			"keywords" => $news_keywords,
			"content" => $news_content
		);
		
		if ($news_id > 0) {
			// facem update
			$this->db->update('news', $data, "`id` = '$news_id'"); 
		} else {
			$this->db->insert('news', $data); 
		}
		redirect('/admin/news', 'location');
	}
	
}
