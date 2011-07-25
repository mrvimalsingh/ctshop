<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/


class User extends MY_Controller {

    function login_page() {
        $this->load->view('admin/login_page');
    }

    function login() {

        $this->load->library('session');

        $user = mysql_real_escape_string($this->input->post('admin_user'));
        $parola = mysql_real_escape_string($this->input->post('admin_parola'));

        $query = $this->db->query("SELECT * FROM `users` WHERE `username` = '$user' AND `password` = MD5('$parola')");
        $userObj = $query->row();

        if ($userObj) {
            $this->session->set_userdata('user_id', $userObj->id);
        }

        redirect('admin/products', 'location');
    }

    function logout() {
        $this->load->library('session');
        $this->session->unset_userdata('user_id');

        redirect('/', 'location');
    }

}
?>