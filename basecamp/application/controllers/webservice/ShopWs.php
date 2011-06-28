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

    var $error;

    function ShopWs() {
        parent::Controller();
    }

    function index() {
        global $HTTP_RAW_POST_DATA;
        // parse json input
        $input = json_decode($HTTP_RAW_POST_DATA);

        $response = array("jsonrpc" => "2.0");

        if ($input !== null && is_object($input)) {
            // check for required parameters
            if (isset($input->method)) {
                // this is where we call the method...
                $response["result"] = $this->_callJsonRpcMethod($input->method,
                                                                isset($input->params)?$input->params:null);
                if ($response["result"] == null) {
                    $response["error"] = $this->error;
                }
            } else {
                // we can live without the method, but not the param
                $response["error"] = array("code" => "-1001", "message" => "JSON-RPC Error: no method");
            }
            if (isset($input->id)) $response["id"] = $input->id;
        } else {
            // json rpc error
            $response["error"] = array("code" => "-1000", "message" => "JSON could not be parsed");
            $response["id"] = null;
        }

        header("Content-type:application/json");
        echo json_encode($response);
    }

    function _callJsonRpcMethod($method, $params) {
        // for now we implement this
        if (method_exists($this, $method)) {
            return $this->$method($params);
        } else {
            $this->error = array("code" => "-1002", "message" => "JSON-RPC Error: method does not exist");
            return null;
        }
    }

    function get_languages($params) {
        $langs = LanguageModel::all();
        $result = array();
        foreach ($langs as $lang) {
            $result[] = $this->_createArrayFromModel($lang, array("id", "code", "name", "default", "admin_default"));
        }
        return $result;
    }

    function _createArrayFromModel($model, $params) {
        $res = array();
        foreach ($params as $p) {
            $res[$p] = $model->$p;
        }
        return $res;
    }

}
