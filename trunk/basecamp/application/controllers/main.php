<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/

class Main extends MY_Controller {
	
	function Main() {
		parent::MY_Controller();
	}
	
	function home() {
		// incarc bannerele...
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
		
		$this->load->model('Productmodel');
		$data["featured_prods"] = $this->Productmodel->getProductList(0, array(), 0, 6, "`p`.`featured` = 'y'");
		
		$query = $this->db->query("SELECT 
										id, title, keywords, content, 
										DATE_FORMAT(`date_added`, '%d/%m/%Y %T') as `date_added`
									FROM 
										`news` 
									WHERE 
										`lang_id` = '".$this->lang_id."' 
									ORDER BY `date_added` DESC 
									LIMIT 1");
		if ($query->num_rows() > 0) {
			
			$data["news"] = $query->row_array();
			
			// scurtam si bagam '...'
			if (strlen($data["news"]["content"]) > 100) {
				$data["news"]["content"] = substr($data["news"]["content"], 0, 100)."...";
			}
		}
		
		$this->setTemplateDataArr($data);
		$this->showMainTemplate("home");
	}
	
	function show_page($page) {
		$this->showMainTemplate('default_pages/'.$page);
	}
	
	function change_lang($lang_id) {
		$this->session->set_userdata("lang_id", $lang_id);
		$this->lang_id = $lang_id;
		$from_page = $_SERVER["HTTP_REFERER"];
		if (!$from_page) {
			$from_page = "/home";
		}
		redirect($from_page, 'location');
	}
	
}

?>