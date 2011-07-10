<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 7/1/11
 * Time: 1:47 AM
 * To change this template use File | Settings | File Templates.
 */
 
class WsProducts {

    var $errorCode = 0;
    var $errorMessage = "";

    function getProduct($params) {
        $product = ProductModel::find_by_id($params);
        // GET ALL OTHER DETAILS...
        return Activerecord::createArrayFromModel($product, array("id", "code", "price"));
    }

    function getProducts($params) {
        // check params
        if (!is_object($params)) {
            JsonRpc::setInvalidParamsError($this);
            return null;
        }
        // expected params are offset/count/filters(object)/order_by/order_dir.
        // for now the filters will include category/search_term/price_lower/price_higher/code/sale(y/n)/in_stock
        return ProductModel::getProducts($params->limit, $params->offset, $params->filters);
    }

    function saveProduct($params) {

    }

    function deleteProduct($params) {

    }

}
