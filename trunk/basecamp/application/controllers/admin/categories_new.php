<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/


class Categories_new extends MY_Controller {
	
	function Categories_new() {
		parent::MY_Controller();
	}
	
	function index() {
		$this->showMainTemplate("admin/categories_new", null, true);
	}

    function select() {
        // load the select popup....
        $this->load->view("admin/includes/select_category");
    }

}

?>