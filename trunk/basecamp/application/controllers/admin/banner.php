<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/


class Banner extends MY_Controller {
	
	var $banner_sizes = array(
		"no_resize" => array("width" => 0, "height" => 0, "name" => "Fara redimensionare"),
//		"large_rectangle" => array("width" => 336, "height" => 280, "name" => "Large rectangle"),
//		"medium_rectangle" => array("width" => 300, "height" => 250, "name" => "Medium rectangle"),
//		"31rectangle" => array("width" => 300, "height" => 100, "name" => "3:1 Rectangle"),
//		"rectangle" => array("width" => 180, "height" => 150, "name" => "Rectangle"),
//		"vertical_rectangle" => array("width" => 240, "height" => 400, "name" => "Vertical rectangle"),
//		"square_popup" => array("width" => 250, "height" => 250, "name" => "Square popup"),
//		"square_button" => array("width" => 125, "height" => 125, "name" => "Square button"),
//		"button_1" => array("width" => 120, "height" => 90, "name" => "Button 1"),
//		"button_2" => array("width" => 120, "height" => 60, "name" => "Button 2"),
//		"micro_bar" => array("width" => 88, "height" => 31, "name" => "Micro bar"),
		"leaderboard" => array("width" => 728, "height" => 90, "name" => "Leaderboard"),
//		"full_banner" => array("width" => 468, "height" => 60, "name" => "Full banner"),
//		"half_banner" => array("width" => 234, "height" => 60, "name" => "Half banner"),
//		"vertical_banner" => array("width" => 120, "height" => 240, "name" => "Vertical banner"),
		"pop_under" => array("width" => 720, "height" => 300, "name" => "Pop under")
//		"half_page_ad" => array("width" => 300, "height" => 600, "name" => "Half page ad"),
//		"wide_skyscraper" => array("width" => 160, "height" => 600, "name" => "Wide skyscraper"),
//		"skyscraper" => array("width" => 120, "height" => 600, "name" => "Skyscraper")
	);
	
	function Banner()
	{
		parent::MY_Controller();
	}
	
	function index()
	{
		$data["banner_sizes"] = $this->banner_sizes;
		$data["languages_array"] = $this->languages;
		
		// scoatem bannerele care sunt in administrare
		$query = $this->db->query("SELECT 
										`b`.*, 
										`bl`.`name`, 
										`bl`.`description` 
									FROM 
										`banners` as `b`
										LEFT JOIN `banners_lang` as `bl`
											ON (`bl`.`banner_id` = `b`.`id`) 
									WHERE 
										`bl`.`lang_id` = '".$this->lang_id."' ");
		$data["banners"] = $query->result_array();
		
		$this->showMainTemplate("admin/banner", $data, true);
	}
	
	function delete($id) {
		$this->config->load('myconf');
		$base_dir = $this->config->item("site_base_dir");
		$query = $this->db->query("SELECT `file_name` FROM `banners` WHERE `id` = '$id' ");
		$row = $query->row_array();
		$this->db->query("DELETE FROM `banners` WHERE `id` = '$id' ");
		$this->db->query("DELETE FROM `banners_lang` WHERE `banner_id` = '$id' ");
		unlink($base_dir."uploads/banners/".$row["file_name"]);
		redirect('/admin/banner', 'location');
	}
	
	function add_banner() {
		$this->config->load('myconf');
		
		$banner_type = mysql_real_escape_string($this->input->post('banner_type'));
		$banner_group = mysql_real_escape_string($this->input->post('banner_group'));
		$banner_link = mysql_real_escape_string($this->input->post('banner_link'));
		$name = $this->input->post('name');
		$desc = $this->input->post('desc');
		
		if ($_FILES["file"]["error"] == 0) {
//			move_uploaded_file 
			if ($banner_type == "no_resize") {
				$base_dir = $this->config->item("site_base_dir");
				move_uploaded_file($_FILES["file"]["tmp_name"], $base_dir."uploads/banners/".$_FILES["file"]["name"]);
			} else {
				$this->load->library('image_lib');
				$this->_upload_image($_FILES["file"]["tmp_name"], $_FILES["file"]["name"], $this->banner_sizes[$banner_type]["width"], $this->banner_sizes[$banner_type]["height"]);
			}
		}
		
		$data = array(
			"banner_type" => $banner_type,
			"banner_group" => $banner_group,
			"link" => $banner_link,
			"file_name" => $_FILES["file"]["name"],
		);
		
		$this->db->insert("banners", $data);
		$banner_id = $this->db->insert_id();
		
		$languages_array = $this->languages;
		foreach ($languages_array as $lang) {
			$set = "`name` = '".mysql_real_escape_string($name[$lang["id"]])."', 
					`description` = '".mysql_real_escape_string($desc[$lang["id"]])."'";
			$query = $this->db->query("INSERT INTO `banners_lang` SET 
											$set,
											`banner_id` = '".$banner_id."', 
											`lang_id` = '".$lang["id"]."'
										ON DUPLICATE KEY UPDATE $set ");
		}
		
		redirect('/admin/banner', 'location');
		
	}
	
	function _upload_image($tmp_name, $name, $width, $height) {
		$base_dir = $this->config->item("site_base_dir");
		
		$config['image_library'] = 'gd2';
		$config['source_image']	= $tmp_name;
		$config['maintain_ratio'] = false;
		$config['width']	 = $width;
		$config['height']	= $height;
		$config['new_image'] = $base_dir."uploads/banners/$name";
		$config['x_axis'] = 0;
		$config['y_axis'] = 0;
		
		$this->image_lib->initialize($config);
		
		if ( ! $this->image_lib->resize())
		{
		    echo $this->image_lib->display_errors();
		} else {
		}
		$this->image_lib->clear();
	}
	
}

?>