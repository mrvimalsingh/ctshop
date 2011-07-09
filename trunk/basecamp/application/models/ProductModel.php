<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 6/14/11
 * Time: 12:49 AM
 * To change this template use File | Settings | File Templates.
 */
 
class ProductModel extends ActiveRecord\Model {
    static $table_name = 'products';

    // TODO P1 implement filtering here

    static function getProducts($limit, $offset, $filters = null) {
        // TODO implement filterings
        $productObjects = ProductModel::all(array('limit' => $limit, 'offset' => $offset));
        $products = array();
        foreach ($productObjects as $p) {
            $product = ShopWs::_createArrayFromModel($p, array("id", "code", "price"));
            $products[] = $product;
        }
        return $products;
    }
}
