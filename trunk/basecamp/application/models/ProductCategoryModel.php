<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 6/14/11
 * Time: 1:14 AM
 * To change this template use File | Settings | File Templates.
 */
 
class ProductCategoryModel extends ActiveRecord\Model {
    static $table_name = 'categories';

    public function getParentCategory() {
        $parent_id = $this->parent_id;
        if ($parent_id != null && $parent_id > 0) {
            $parent = ProductCategoryModel::find_by_id($parent_id);
            return $parent;
        }
        return null;
    }

    public function getChildCategories() {
        if (!isset($this->id)) {
            return ProductCategoryModel::all(array('conditions' => 'parent_id IS NULL'));
        }
        return ProductCategoryModel::all(array('conditions' => 'parent_id = '.$this->id));
    }

    public function getProducts() {
        $prcList = ProductReCategoryModel::all(array('conditions' => 'category_id = '.$this->id));
        $products = array();
        foreach ($prcList as $prc) {
            $prod = ProductModel::find_by_id($prc->product_id);
            if ($prod != null) {
                $products[] = $prod;
            }
        }
        return $products;
    }
}
