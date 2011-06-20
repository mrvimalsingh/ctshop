<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/


class Users extends MY_Controller {
	
	function Users()
	{
		parent::MY_Controller();
		$this->load->library('session');
		$user_id = $this->session->userdata('user_id');
		if ($user_id === false) { 
			redirect('/admin/user/login_page', 'location');
		}
	}
	
	function index()
	{
		$this->load->view('admin_template');
	}
	
}

?>