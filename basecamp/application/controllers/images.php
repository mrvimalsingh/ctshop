<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/


class Images extends MY_Controller {
	
	function Images()
	{
		parent::MY_Controller();	
	}

	function get_image($type, $id) {
		
		$this->config->load('myconf');
		$base_dir = $this->config->item("site_base_dir");
		
		header("Content-type: image/jpg");
		echo readfile($base_dir."uploads/product_images/$type/$id.jpg");
	}

    function test($x = 100, $y = 100, $t = 'fit') {
        $this->load->library('business/BImages');
        $this->bimages->outputImage('test', 'h1234', $x, $y, $t);
    }
	
	function get_category_image($cat_id) {
		
		$query = $this->db->query("SELECT `img` FROM `categories` WHERE `id` = '$cat_id' ");
		$cat = $query->row_array();
		
		header("Content-type: image/png");
		echo $cat["img"];
	}
	
}

?>