<?php
/**
 * User: codetwister
 * Date: 12/27/10
 * Time: 11:48 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Wishlist extends MY_Controller {

    function Wishlist() {
        parent::MY_Controller();
        $this->load->library('MyWishList');
        $this->load->model('Productmodel');
    }

    function index() {
        $wishList = $this->mywishlist->getWishList($this->client_id);
        if ($wishList !== null) {
            foreach ($wishList as $k => $v) {
                $where = "`p`.`id` = '".$v["product_id"]."'";
                $products = $this->Productmodel->getProductList(0, array(), 0, 1, $where);
                $wishList[$k]["product"] = $products[0];
                $wishList[$k]["product"]["wishListRemoveLink"] =
                        "<a href=\"".site_url("wishlist/remove/".$v["id"])."\">Sterge de pe wishlist</a>";
            }
            $this->setTemplateData("wishList", $wishList);
        }
        $this->showMainTemplate("wishlist");
    }

    function add($product_id) {
        $this->mywishlist->addToWishList($product_id, $this->client_id);
        redirect(site_url("wishlist"), 'location');
    }

    function remove($id) {
        $this->mywishlist->removeFromWishList($id);
        redirect(site_url("wishlist"), 'location');
    }

}
