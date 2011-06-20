<?php

class ProductCategory {
	
	var $settings = array(
		"main_ul_id" => "categories_tree_div",
		"main_ul_class" => "sf-menu"
	);
	
	function ProductCategory($params = array()) {
		foreach ($params as $k => $v) {
			$this->settings[$k] = $v;
		}
	}
	
	function loadCategory($category_id) {
		$CI =& get_instance();
		$sql = "SELECT * FROM `categories` WHERE `id` = '$category_id' LIMIT 1 ";
		$query = $CI->db->query($sql);
		$category = $query->row_array();
		$category_lang = $this->getCategoryLang($category_id);
		$category = array_merge($category_lang, $category);
		
		$category["link"] = $this->createCategoryLink($category_id);
		
		return $category;
	}
	
	/**
	 *	loads all categories in a list to be used in combo boxes
	 */
	function getCategoriesList($parent_id = null) {
		$CI =& get_instance();
		$returnList = array();
		$query = $CI->db->query("SELECT `id` FROM `categories` WHERE ".(($parent_id == null)?" `parent_id` is NULL ":" `parent_id` = '$parent_id' ")." ORDER BY `order` ");
		if ($query->num_rows() > 0) {
			foreach($query->result_array() as $k => $cat) {
				$returnList[] = $this->loadCategory($cat["id"]);
				$childs = $this->getCategoriesList($cat["id"]);
				foreach ($childs as $child) {
					$returnList[] = $child;
				}
			}
		}
		return $returnList;
	}
	
	/**
	 *	loads the category tree 
	 *	and returns it in html UL format
	 *	ex:
	 *		<ul id="category_tree" class="category_tree">
	 *			<li>Some parent category
	 *				<ul>
	 *					<li>Subcategory</li>
	 *					...
	 *				</ul>
	 *			</li>
	 *			...
	 *		</ul>
	 *	in case it's admin, it gets some more info...
	 */
	function getCategoryULTree($from_admin = false) {
		return $this->getCategoryTemplateRec(null, $from_admin);
	}
	
	function getCategoryTemplateRec($category_id, $from_admin) {
		$CI =& get_instance();
		$output = "";
		// scoatem datele pentru categoria curenta...
		if ($category_id != null) {
			$category = $this->loadCategory($category_id);
			$details = "";
			if ($from_admin) {
				 $details = " style=\"clear:both;\" class=\"draggable droppable\" cat_id=\"$category_id\"";
			}
			$output .= "<li".$details.">";
			if ($from_admin) {
				$output .= "<input type=\"text\" name=\"order[$category_id]\" value=\"".$category["order"]."\" size=\"2\" style=\"width:20;float:right;\" />
							<a href=\"".site_url("admin/categories/edit_category")."/$category_id\" style=\"float:right;\">
								<img src=\"".base_url()."img/edit.png\" />
							</a>";
				$output .= $category["name"];
			} else {
				$output .= "<a href=\"".$category["link"]."\">".$category["name"]."</a>";
			}
		}
		
		// scoatem subcategoriile
		$query = $CI->db->query("SELECT `id` FROM `categories` WHERE ".(($category_id == null)?" `parent_id` is NULL ":" `parent_id` = '$category_id' ")." ORDER BY `order` ");
		if ($query->num_rows() > 0) {
			if ($category_id != null) { // we're on the main ul...
				$output .= "<ul>";
			} else {
				$output .= "<ul id=\"".$this->settings["main_ul_id"]."\" class=\"".$this->settings["main_ul_class"]."\">";
			}
			foreach($query->result_array() as $k => $cat) {
				$output .= $this->getCategoryTemplateRec($cat["id"], $from_admin);
			}
			$output .= "</ul>";
		}
		
		if ($category_id != null) {
			$output .= "</li>";
		}
		
		return $output;
	}
	
	function getCategoryLang($category_id, $lang_id = false) {
		$CI =& get_instance();
		if ($lang_id === false) {
			$lang_id = $CI->lang_id;
		}
		$sql = "SELECT * FROM `categories_lang` WHERE `category_id` = '$category_id' AND `lang_id` = '$lang_id' LIMIT 1 ";
		$query = $CI->db->query($sql);
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$category_lang["name"] = $row["name"];
			$category_lang["keywords"] = $row["keywords"];
			$category_lang["short_desc"] = $row["short_desc"];
			$category_lang["description"] = $row["description"];
		} else {
			$category_lang["name"] = "n/a";
			$category_lang["keywords"] = "";
			$category_lang["short_desc"] = "";
			$category_lang["description"] = "";
		}
		return $category_lang;
	}
	
	function createCategoryLink($cat_id) {
		$controller =& get_instance();
		$query = $controller->db->query("SELECT `name` FROM `categories_lang` WHERE `category_id` = '$cat_id' AND `lang_id` = '".$controller->lang_id."' ");
		$cat = $query->row_array();
		return site_url("products/$cat_id/".url_title($cat["name"]));
	}
	
}

?>