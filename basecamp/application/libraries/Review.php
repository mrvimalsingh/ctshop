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
 * File: Review.php
 * Created: Jul 17, 2010
 * 
 * class for handling reviews with codeIgniter...
 * methods for adding, retrieving, deleting, approving reviews
 * 
 */

class Review {
	
	var $settings = array(
		"table_name" => "reviews",
		"object_id_field" => "product_id", 
		"rating_field" => "rating",
		"desc_field" => "description",  
		"language_field" => "lang_id", 
		"user_field" => "client_id", 
		"approved_field" => "approved",
		"date_field" => "date_added",
	);
	
	/**
	 * @param array $params
	 */
	function Review($params = array()) {
		foreach ($params as $k => $v) {
			$this->settings[$k] = $v;
		}
	}
	
	/**
	 * for admin purposes
	 */
	function getUnapprovedReviews() {
		$CI =& get_instance();
		$CI->db->where($this->settings["approved_field"], "n");
		$query = $CI->db->get($this->settings["table_name"]);
		$return_array = $query->result_array();
		if (is_array($return_array)) {
			foreach ($return_array as $k => $v) {
				$return_array[$k] = $this->getReviewDetails($v);
			}
		}
		return $return_array;
	}
	
	/**
	 * 
	 */
    function getReviewsForId($id, $only_approved = false) {
        $CI =& get_instance();
        $CI->db->where($this->settings["language_field"], $CI->lang_id);
        $CI->db->where($this->settings["object_id_field"], $id);
        if ($only_approved) {
            $CI->db->where($this->settings["approved_field"], "y");
        }
        $query = $CI->db->get($this->settings["table_name"]);
        $return_array = $query->result_array();
        if (is_array($return_array)) {
            foreach ($return_array as $k => $v) {
                $return_array[$k] = $this->getReviewDetails($v);
            }
        }
        return $return_array;
    }
	
	/**
	 *
	 */
	function addReview($object_id, $rating, $desc, $lang, $user) {
		$CI =& get_instance();
		// we must check if there already is a review from this user... for the object
		$data = array(
			$this->settings["object_id_field"] => $object_id, 
			$this->settings["rating_field"] => $rating,
			$this->settings["desc_field"] => $desc,  
			$this->settings["language_field"] => $lang, 
			$this->settings["user_field"] => $user, 
			$this->settings["approved_field"] => "n",
			$this->settings["date_field"] => date("Y-m-d")
		);
		$CI->db->insert($this->settings["table_name"], $data); 
	}
	
	/**
	 *
	 */
	function deleteReview($review_id) {
		$CI =& get_instance();
		$CI->db->delete($this->settings["table_name"], array('id' => $review_id)); 
	}
	
	/**
	 *
	 */
	function approveReview($review_id) {
		$CI =& get_instance();
		$data = array(
               $this->settings["approved_field"] => "y",
		);

		$CI->db->where('id', $review_id);
		$CI->db->update($this->settings["table_name"], $data);
	}
	
	/**
	 *	PROJECT SPECIFIC FUNCTION... TO BE REPLACED WHEN USED ELSEWHERE
	 */
	function getReviewDetails($review) {
		$CI =& get_instance();
		
		$CI->db->select('name');
		$CI->db->where("product_id", $review[$this->settings["object_id_field"]]);
		$CI->db->where("language_id", $CI->lang_id);
		$query = $CI->db->get('products_lang');
		$row = $query->row_array();
		$review["product_name"] = $row["name"];
		
		$CI->db->select('person_name, company_name');
		$CI->db->where("id", $review[$this->settings["user_field"]]);
		$query = $CI->db->get('clients');
		$row = $query->row_array();
		$review["client_name"] = $row["person_name"]." ".$row["company_name"];
		
		return $review;
	}
	
}

?>