<?php
/**
 * Created by CodeTwister.
 * Date: 6/29/11
 * Time: 12:14 AM
 * standard JSON-RPC webservice implementation...
 * detailed WS documentation coming soon...
 */

// TODO this might be refactored (maybe extract the WS part and make it a library so other controllers might implement other webservices and/or split WS in multiple classes that handle different parts of the backend)
class ShopWs extends Controller {

    var $errorCode = 0;
    var $errorMessage = "";

    function ShopWs() {
        parent::Controller();
    }

    function index() {

    }

    function jsonrpc($ws = null) {

        $webservices = array(
            "products" => "WsProducts",
            "general" => "WsGeneral",
            "user" => "WsUser",
            "orders" => "WsOrders"
        );

        $this->load->library('JsonRpc');
        if ($ws == null) {
            $this->jsonrpc->registerHandlerClass($this);
        } else {
            if ($webservices[$ws]) {
                $handlerClassName = $webservices[$ws];
                $handlerClassNameLc = strtolower($handlerClassName);
                $this->load->library($handlerClassName);
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
