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

    // this will eventually replace the old get image...
    function get_image_improved($category, $transform = 'n', $hash) {
        $t_values = array(
            'c' => 'crop',
            'f' => 'fit',
            'n' => 'noscale',
        );
        $t = substr($transform, 0, 1);
        if (strlen($transform) > 1) {
            $box = substr($transform, 1, strlen($transform)-1);
        } else {
            $box = 0;
        }
        $this->load->library('business/BImages');
        $this->bimages->outputImage($category, $hash, $t_values[$t], $box, $box);
    }
	
	function get_category_image($cat_id) {
		
		$query = $this->db->query("SELECT `img` FROM `categories` WHERE `id` = '$cat_id' ");
		$cat = $query->row_array();
		
		header("Content-type: image/png");
		echo $cat["img"];
	}

    function test_image_upload_form() {
        // this will be the way to do it
        $this->load->view("test_upload_form");
    }

    function upload_test_image() {
        // this will be the way to do it
        $this->load->library('business/BImages');
        echo $this->bimages->uploadImage("test");
//        redirect(site_url("images/test_image_upload_form"));
    }
	
}

?>