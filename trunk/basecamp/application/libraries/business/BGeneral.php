<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 7/24/11
 * Time: 5:05 AM
 * To change this template use File | Settings | File Templates.
 */

class BGeneral {

    function getLanguages() {
        $langs = LanguageModel::all();
        $result = array();
        foreach ($langs as $lang) {
            $result[] = Activerecord::createArrayFromModel($lang);
        }
        return $result;
    }

    function checkUserLoggedIn() {
        $this->load->library('session');
        return array("user_id" => $this->session->userdata('user_id'));
    }

}
