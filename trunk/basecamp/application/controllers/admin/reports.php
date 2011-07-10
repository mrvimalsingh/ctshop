<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 7/10/11
 * Time: 5:59 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Reports extends MY_Controller {

    function index() {
        $this->showMainTemplate("admin/reports", null, true);
    }

}
