<?php

class MY_Controller extends Controller {

    var $user_id;
    var $lang_id;
    var $template_data;
    var $client_id;
    var $languages;

    function MY_Controller()
    {
        parent::Controller();
        // verificam daca exista instalare daca nu redirectam spre pagina de instalare
        $this->_check_installation();
        $this->config->load('site_config');

        $db_conf = $this->config->item('db');
        $this->load->database($db_conf);
        // incarcam extensia de session dupa baza de date fiindca stocam date despre sesiune in db
        $this->load->library('session');
        $this->load->library('cart');

        $this->load->library('DbGeneralSettings');
        $this->load->library('ProductCategory');

        $skin = $this->dbgeneralsettings->getKey("selected_skin");
        $this->load->library('CTSkins', array("selected_skin" => $skin));

        $this->_load_language();

        $this->client_id = $this->session->userdata('client_id');
        $this->template_data["client_id"] = $this->client_id;

        // aici verificam daca suntem pe admin
        if ($this->uri->segment(1) == "admin") {
            $this->user_id = $this->session->userdata('user_id');
            // !!!!!!!!!!!!!!!!!!!!!!!
            // !!!!! IMPORTANT !!!!!!! sa nu confundam user_id cu client_id
            // !!!!!!!!!!!!!!!!!!!!!!!
            $login_pages = array("login_page", "login", "logout");
            if ($this->user_id === false && !in_array($this->uri->segment(3), $login_pages) ) {
                redirect('/admin/user/login_page', 'location');
            }
        }

        $this->template_data["base_url"] = base_url();

        //scoatem si bagam in template_data cate produse is in cos si cat valoreaza
        $this->template_data["cart_products_count"] = count($this->cart->contents());
        $this->template_data["cart_products_total"] = $this->cart->format_number($this->cart->total());

    }

    /**
     *	checks if site is installed... and configured... if not redirects to install script
     */
    function _check_installation() {
        // if there is no site_config.php it's not installed
        $this->load->helper('file');
        $info = get_file_info(APPPATH."config/site_config.php");
        if ($info === false) {
            redirect('/install', 'location');
        }
    }

    /**
     *	loads all language details... sets every lang related variables
     */
    function _load_language() {
        $this->lang_id = $this->session->userdata('lang_id');
        if (!$this->lang_id) {
            $query = $this->db->query("SELECT `id` FROM `languages` WHERE `default` = 'y' LIMIT 1");
            $row = $query->row_array();
            $this->lang_id = $row["id"];
        }
        $query = $this->db->query("SELECT `code` FROM `languages` WHERE `id` = '".$this->lang_id."' ");
        $row = $query->row_array();
        $this->config->set_item('language', $row["code"]);

        // load main language file...
        $this->lang->load('main');

        // bagam si celelalte limbi intr-o variabila
        $query = $this->db->query("SELECT * FROM `languages` WHERE 1 ");
        $this->languages = $query->result_array();
        $this->template_data["languages_array"] = $this->languages;
    }

    function showMainTemplate($view, $extra_data = array(), $admin = false) {
        $this->setTemplateDataArr($extra_data);
        if (!$admin) {
            $this->template_data["category_ul_tree"] = $this->productcategory->getCategoryULTree();
        }
        $this->template_data["content"] = $this->load->view($view, $this->template_data, true);
        $this->load->view((($admin)?"admin_template":"main_template"), $this->template_data);
    }

    function setTemplateData($key, $value) {
        $this->template_data[$key] = $value;
    }

    function setTemplateDataArr($data = array()) {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $this->template_data[$k] = $v;
            }
        }
    }

}

?>