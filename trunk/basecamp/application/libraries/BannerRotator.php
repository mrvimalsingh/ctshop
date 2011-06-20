<?php
/*
 * Copyright (C)
 * _________            .___      
 * \_   ___ \  ____   __| _/____  
 * /    \  \/ /  _ \ / __ |/ __ \ 
 * \     \___(  <_> ) /_/ \  ___/ 
 *  \______  /\____/\____ |\___  >
 *         \/            \/    \/ 
 * ___________       .__          __                       
 * \__    ___/_  _  _|__| _______/  |_  ___________  ______
 *   |    |  \ \/ \/ /  |/  ___/\   __\/ __ \_  __ \/  ___/
 *   |    |   \     /|  |\___ \  |  | \  ___/|  | \/\___ \ 
 *   |____|    \/\_/ |__/____  > |__|  \___  >__|  /____  >
 *                           \/            \/           \/
 * 
 * Nagy Mihaly Ferencz
 * 
 * File: BannerRotator.php
 * Created: Jul 18, 2010
 * 
 */

class BannerRotator {
	
	var $settings = array(
		"controller" => "banners",
		
	);
	
	function BannerRotator($params = array()) {
		foreach ($params as $k => $v) {
			$this->settings[$k] = $v;
		}
	}
	
	/**
	 *	this one is the magic one... (pentru asta am facut aceasta clasa...)
	 *	scoatem urmatorul banner pentru un grup si incrementam view-ul...
	 */
	function getNextBanner($group) {
		$CI =& get_instance();
		$output = "";
		
		$CI->db->where("banner_group", $group);
		$CI->db->where("order", "1");
		$query = $CI->db->get('banners');
		if ($query->num_rows() > 0) {
			$prev_banner = $query->row_array();
			$prev_id = $prev_banner["id"];
		} else {
			$prev_id = 0;
		}
		
		$CI->db->where("banner_group", $group);
		$CI->db->select_max('id', 'last_id');
		$query = $CI->db->get('banners');
		$last_banner = $query->row_array();
		$last_id = $last_banner["last_id"];
		
		$banner_id_where = "AND `b`.`id` > (SELECT `id` FROM `banners` WHERE `order` = '1')";
		if ($prev_id == 0 || $prev_id == $last_id) {
			$banner_id_where = "";
		}
		
		$query = $CI->db->query("SELECT 
									`b`.*,
									`bl`.`name`,
									`bl`.`description`
								FROM 
									`banners` as `b`
									LEFT JOIN `banners_lang` as `bl`
										ON (`bl`.`banner_id` = `b`.`id`)
								WHERE
									`b`.`banner_group` = '$group'
									AND `bl`.`lang_id` = '".$CI->lang_id."'
									$banner_id_where
								LIMIT 1
								");
		if ($query->num_rows() > 0) {
			$banner = $query->row_array();
			// setam toate la 0 si asta curent la 1
			$CI->db->query("UPDATE `banners` SET `order` = '0' WHERE `banner_group` = '$group' ");
			$CI->db->query("UPDATE `banners` SET `order` = '1', `views` = `views`+1 WHERE `id` = '".$banner["id"]."' ");
			
			$output .= '<a href="'.site_url("banners/navigate/".$banner["id"]).'" target="_blank" title="'.$banner["name"].' - '.$banner["description"].'">
				<img src="'.base_url().'uploads/banners/'.$banner["file_name"].'" alt="'.$banner["name"].' - '.$banner["description"].'"/></a>';
			
		}
		return $output;
	}
	
	/**
	 *	cand il apelezi pe asta in mod normal ii cand dai click pe banner
	 *	deci incrementam aici click-urile, pentru bannerul asta...
	 */
	function getBannerLink($banner_id) {
		$CI =& get_instance();
		$CI->db->query("UPDATE `banners` SET `clicks` = `clicks`+1 WHERE `id` = '$banner_id' ");
		$query = $CI->db->query("SELECT 
									`link`
								FROM 
									`banners`
								WHERE
									`id` = '$banner_id'
								");
		if ($query->num_rows() > 0) {
			$banner = $query->row_array();
			return $banner["link"];
		}
		return "";
	}
	
}

?>