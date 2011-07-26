<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 7/24/11
 * Time: 5:05 AM
 * To change this template use File | Settings | File Templates.
 */

class BGeneral {

    var $errorCode = 0;
    var $errorMessage = "";

    function getLanguages() {
        $langs = LanguageModel::all();
        $result = array();
        foreach ($langs as $lang) {
            $result[] = Activerecord::createArrayFromModel($lang);
        }
        return $result;
    }

    function getImages($params) {
        $CI = &get_instance();
        $CI->load->library("business/BImages");
        return $CI->bimages->getAvailableImagesForCategory($params->imageCategory);
    }

}
