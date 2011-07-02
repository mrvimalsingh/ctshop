<?php
/**
 * Created by CodeTwister.
 * Date: 6/29/11
 * Time: 12:14 AM
 * standard JSON-RPC webservice implementation...
 * detailed WS documentation coming soon...
 */

class Webservices extends Controller {

    var $errorCode = 0;
    var $errorMessage = "";

    function ShopWs() {
        parent::Controller();
    }

    function index() {
        echo "you have to specify which webservice you're going to use";
    }

    function jsonrpc($ws = null) {

        $webservices = array(
            "products" => "WsProducts",
            "categories" => "WsCategories",
            "general" => "WsGeneral",
            "user" => "WsUser",
            "orders" => "WsOrders"
        );

        $this->load->library('JsonRpc');
        if ($ws == null || $ws == "") {
            $this->jsonrpc->registerHandlerClass($this);
        } else {
            if ($webservices[$ws]) {
                $handlerClassName = $webservices[$ws];
                $handlerClassNameLc = strtolower($handlerClassName);
                $this->load->library('webservice/'.$handlerClassName);
                $this->jsonrpc->registerHandlerClass($this->$handlerClassNameLc);
            } else {
                echo "Unknown webservice: ".$ws;
                return;
            }
        }
        $this->jsonrpc->startJsonRpc();
    }

    function get_languages($params) {
        $langs = LanguageModel::all();
        $result = array();
        foreach ($langs as $lang) {
            $result[] = $this->_createArrayFromModel($lang, array("id", "code", "name", "default", "admin_default"));
        }
        return $result;
    }

    function check_user_logged_in($params) {
        $this->load->library('session');
        return array("user_id" => $this->session->userdata('user_id'));
    }

    function check_header() {
        return getallheaders();
    }

    function subtract($params) {
        if (is_array($params) && count($params) == 2) {
            return $params[0]-$params[1];
        } else {
            JsonRpc::setInvalidParamsError($this);
            return null;
        }
    }

    static function _createArrayFromModel($model, $params) {
        $res = array();
        foreach ($params as $p) {
            $res[$p] = $model->$p;
        }
        return $res;
    }

}
