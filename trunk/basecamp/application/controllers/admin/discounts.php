<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/


class Discounts extends MY_Controller {

    function Discounts() {
        parent::MY_Controller();
    }

    function index() {
        $this->showMainTemplate("admin/discounts/discounts", array(), true);
    }

    /**
     * ajax call
     */
    function addDiscount() {

    }

    /**
     * ajax call
     */
    function addProduct($discountId, $productId) {

    }

    /**
     * ajax call
     */
    function removeDiscount($id) {

    }

    /**
     * ajax call
     */
    function removeDiscountProduct($id) {

    }

    function saveDiscountProductDetails() {

    }

    /**
     * ajax call
     * all filters and pagination data transmitted through post data...
     */
    function table() {
        $this->load->view('admin/discounts/discounts_table', array());
    }
}

?>