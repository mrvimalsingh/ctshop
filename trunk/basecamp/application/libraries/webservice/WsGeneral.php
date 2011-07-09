<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 7/1/11
 * Time: 2:03 AM
 * To change this template use File | Settings | File Templates.
 */

class WsGeneral {

    var $errorCode = 0;
    var $errorMessage = "";

    function getImagesForCategory($params) {
        $CI = &get_instance();
        $CI->load->library("business/BImages");
        $images = $CI->bimages->getAvailableImagesForCategory($params);
        if ($images == null) {
            // the selected category was not found
            $this->errorCode = -1;
            $this->errorMessage = "The Image category selected was not found on the server: $params";
            return null;
        } else if (count($images) == 0) {
            $this->errorCode = -2;
            $this->errorMessage = "The Image category selected has no images in it";
            return null;
        }
        return $images;
    }

    function getImageCategories($params) {
        $CI = &get_instance();
        $CI->load->library("business/BImages");
        $imageC = $CI->bimages->getAvailableImageCategories();
        if ($imageC == null) {
            $this->errorCode = -1;
            // TODO all internal error codes must be defined somewhere and used throughout the app
            $this->errorMessage = "Internal error, (1020) please contact the site administrator about this.";
            return null;
        } else if (count($imageC) == 0) {
            $this->errorCode = -2;
            $this->errorMessage = "There are no image categories. Please contact the site administrator about this.";
            return null;
        }
        return $imageC;
    }

}
