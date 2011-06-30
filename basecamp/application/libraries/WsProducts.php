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
        return ShopWs::_createArrayFromModel($product, array("id", "code", "price"));
    }

}
