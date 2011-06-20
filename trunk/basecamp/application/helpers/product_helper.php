<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/

// TODO asta se poate scoate de aici... de tot...
/**
 * 
 * @param $cat_id
 */
// TODO si asta se poate scoate de aici si folosit clasa pentru a scoate...
function createCategoryLink($cat_id) {
	$controller =& get_instance();
	$query = $controller->db->query("SELECT `name` FROM `categories_lang` WHERE `category_id` = '$cat_id' AND `lang_id` = '".$controller->lang_id."' ");
	$cat = $query->row_array();
	return site_url("products/$cat_id/".url_title($cat["name"]));
}

/**
 * 
 * @param $prod_id
 */
function createProductLink($cat_id, $prod_id) {
	$controller =& get_instance();
	$query = $controller->db->query("SELECT `name` FROM `categories_lang` WHERE `category_id` = '$cat_id' AND `lang_id` = '".$controller->lang_id."' ");
	if ($query->num_rows() > 0) {
		$cat = $query->row_array();
		$category_name = $cat["name"];
	} else {
		$category_name = "-";
	}
	if ($category_name == "") {
		$category_name = "-";
	}
	$query = $controller->db->query("SELECT `name` FROM `products_lang` WHERE `product_id` = '$prod_id' AND `language_id` = '".$controller->lang_id."' ");
	if ($query->num_rows() > 0) {
		$prod = $query->row_array();
		$name = $prod["name"];
	} else {
		$name = "-";
	}
	if ($name == "") {
		$name = "-";
	}
	return site_url("products/$cat_id/".url_title($category_name)."/$prod_id/".url_title($name));
}

/**
 * 
 * @param $prod_id
 */
function getProductMainImage($prod_id) {
	$controller =& get_instance();
	$query = $controller->db->query("SELECT `id` FROM `product_pictures` WHERE `product_id` = '$prod_id' AND `main` = 'y' LIMIT 1 ");
	if ($query->num_rows() == 0) {
		$query = $controller->db->query("SELECT `id` FROM `product_pictures` WHERE `product_id` = '$prod_id' ORDER BY `order` LIMIT 1 ");
	}
	if ($query->num_rows() > 0) {
		$pic = $query->row_array();
		return $pic["id"];
	}
	return 0;
}

/**
 * 
 * @param unknown_type $product_id
 * @param unknown_type $lang_id
 */
function getProductLang($product_id, $lang_id = false) {
	$controller =& get_instance();
	if ($lang_id === false) {
		$lang_id = $controller->lang_id;
	}
	$sql = "SELECT name, keywords, description, short_desc FROM `products_lang` WHERE `product_id` = '$product_id' AND `language_id` = '$lang_id' LIMIT 1 ";
	$query = $controller->db->query($sql);
	if ($query->num_rows() > 0) {
		$prod_lang = $query->row_array();
	} else {
		$prod_lang["name"] = "";
		$prod_lang["keywords"] = "";
		$prod_lang["description"] = "";
		$prod_lang["short_desc"] = "";
	}
	return $prod_lang;
}

/**
 * 
 * @param $category_id
 * @param $lang_id
 */
// TODO asta se poate scoate... ca avem aceeasi chestie in ProductCategory
function getCategoryLang($category_id, $lang_id = false) {
	$controller =& get_instance();
	if ($lang_id === false) {
		$lang_id = $controller->lang_id;
	}
	$sql = "SELECT * FROM `categories_lang` WHERE `category_id` = '$category_id' AND `lang_id` = '$lang_id' LIMIT 1 ";
	$query = $controller->db->query($sql);
	if ($query->num_rows() > 0) {
//		echo "hj kghjk gsql= ".$sql."<br />";
		$category_lang = $query->row_array();
	} else {
		$category_lang["name"] = "";
		$category_lang["keywords"] = "";
		$category_lang["short_desc"] = "";
		$category_lang["description"] = "";
	}
	return $category_lang;
}

/**
 * 
 * @param $product_id
 */
function getProductDiscount($product_id) {
	$controller =& get_instance();
	$sql = "SELECT * FROM `products_discount` WHERE `product_id` = '$product_id' LIMIT 1 ";
	$query = $controller->db->query($sql);
	if ($query->num_rows() > 0) {
//		echo "hj kghjk gsql= ".$sql."<br />";
		$discount = $query->row_array();
	} else {
		$discount["start_date"] = "";
		$discount["end_date"] = "";
		$discount["value"] = "0";
	}
	return $discount;
}

/**
 * 
 * @param unknown_type $product
 */
function getProductTemplate($category_id, $product) {
	$controller =& get_instance();
	$product["thumb_image_link"] = base_url()."img/farapozaMic.jpg";
	$product["big_image_link"] = "#";
	if (isset($product["image_id"]) && $product["image_id"] != 0) {
		$product["thumb_image_link"] = site_url("images/get_image/thumbnail")."/".$product["image_id"];
		$product["big_image_link"] = site_url("images/get_image/big")."/".$product["image_id"];
	}
	$product["product_link"] = createProductLink($category_id, $product["id"]);
    if (!isset($product["wishListRemoveLink"])) {
        $product["wishListRemoveLink"] = "";
    }
	return $controller->parser->parse("products/one_product", $product, TRUE);
}

?>