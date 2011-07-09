<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 7/10/11
 * Time: 12:05 AM
 * To change this template use File | Settings | File Templates.
 */
 
class Products_new extends MY_Controller {

    function Products_new() {
		parent::MY_Controller();
	}

	function index() {
		$this->showMainTemplate("admin/products/products_new", null, true);
	}

    function select() {
        // load the select popup....
        $this->load->view("admin/includes/select_product");
    }

}
