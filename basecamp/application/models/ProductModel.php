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
    static $has_many = array(
        array('products_lang', 'class_name' => 'ProductLangModel', 'foreign_key' => 'product_id'),
    );
    static $fields = array('id', 'code','producer_id', 'price', 'in_stock', 'available_online', 'appear_on_site', 'featured');
    static $lang_fields = array('name', 'keywords','short_desc', 'description');
    static $lang_ref = 'products_lang';
    static $lang_field = 'language_id';

    // TODO P1 implement filtering here

    static function getProducts($limit, $offset, $filters = null) {
        // TODO implement filterings
        $productObjects = ProductModel::all(array('limit' => $limit, 'offset' => $offset));
        $products = array();
        foreach ($productObjects as $p) {
            $products[] = Activerecord::returnArrayWithLang($p);
        }
        return $products;
    }

}
