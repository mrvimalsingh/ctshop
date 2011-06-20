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
 * File: MyWishList.php
 * Created: Jul 17, 2010
 * 
 */

class MyWishList {

    var $settings = array(
        "table_name" => "whishlist",
        "product_field" => "product_id",
        "client_field" => "client_id",
        "date_field" => "date_added",
    );

    function MyWishList($settings = array()) {
        foreach ($settings as $k => $v) {
            $this->settings[$k] = $v;
        }
    }

    /**
     * Add a product to a user's wish list.
     * If the product already exists it's ignored.
     * @param  $product_id
     * @param  $client_id
     * @return void
     */
    function addToWishList($product_id, $client_id) {
        $CI =& get_instance();
        $CI->db->where($this->settings["client_field"], $client_id);
        $CI->db->where($this->settings["product_field"], $product_id);
        $query = $CI->db->get($this->settings["table_name"]);
        if ($query->num_rows() > 0) return;
        $data = array(
            $this->settings["product_field"] => $product_id,
            $this->settings["client_field"] => $client_id
        );
        $CI->db->insert($this->settings["table_name"], $data);
    }

    /**
     * Remove a product from the client's wish list
     * @param  $wishlist_id
     */
    function removeFromWishList($wishlist_id) {
        $CI =& get_instance();
        $CI->db->delete($this->settings["table_name"], array('id' => $wishlist_id));
    }

    /**
     * @param  $client_id
     * @return an array of wish list items
     */
    function getWishList($client_id) {
        $CI =& get_instance();
        $CI->db->where($this->settings["client_field"], $client_id);
        $query = $CI->db->get($this->settings["table_name"]);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

}

?>