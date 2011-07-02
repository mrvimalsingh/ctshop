<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 7/1/11
 * Time: 1:47 AM
 * To change this template use File | Settings | File Templates.
 */
 
class WsCategories {

    var $errorCode = 0;
    var $errorMessage = "";

    function getCategories($params) {
        return CategoryModel::getAllCategoriesRecursive();
    }

    function getCategory($params) {
        // TODO check language if is set to be valid... and throw invalid params if not
        if (!is_object($params)) {
            JsonRpc::setInvalidParamsError($this);
            return null;
        }
        $category = CategoryModel::getCategoryArrayWithLanguages($params->id);
        if ($category == null) {
            $this->errorCode = -1;
            $this->errorMessage = "Category not found";
        }
        return $category;
    }

    function saveCategory($params) {
        // insert/update category
        $CI = &get_instance();
        $CI->load->library("business/BCategories");
        $status = $CI->bcategories->saveCategoryFromJsonObject($params);
        $this->errorCode = $status["errorCode"];
        $this->errorMessage = $status["errorMessage"];
        return $status["category_id"];
    }

    function deleteCategory($params) {
        $CI = &get_instance();
        $CI->load->library("business/BCategories");
        $status = $CI->bcategories->deleteCategory($params->id);
        $this->errorCode = $status["errorCode"];
        $this->errorMessage = $status["errorMessage"];
        return $status["deleted"];
    }

}
