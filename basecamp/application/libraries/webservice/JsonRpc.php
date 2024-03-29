<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 7/1/11
 * Time: 12:43 AM
 * To change this template use File | Settings | File Templates.
 */
 
class JsonRpc {

    var $handlers = array();
    var $error;


    /**
     * classes that register must have $errorCode $errorMessage variables defined
     * @param  $class
     * @return void
     */
    function registerHandlerClass($class) {
        $this->handlers[] = $class;
    }

    function startJsonRpc() {
        global $HTTP_RAW_POST_DATA;
        // parse json input
        $input = json_decode($HTTP_RAW_POST_DATA);
        if ($input === null) {
            if (isset($_POST["jsonrpc"])) {
                $input = json_decode($_POST["jsonrpc"]);
            }
        }

        if ($input !== null && (is_object($input) || is_array($input))) {
            if (is_array($input)) {
                $response = array();
                foreach ($input as $i) {
                    $response[] = $this->_processRequest($i);
                }
            } else {
                $response = $this->_processRequest($input);
            }
        } else {
            // json rpc error
            $response = array("jsonrpc" => "2.0");
            $response["error"] = array("code" => "-32700", "message" => "Parse error.");
            $response["id"] = null;
        }

        header("Content-type:application/json");
        echo json_encode($response);
    }

    private function _processRequest($jsonRpc) {
        // initialize default values
        $response = array("jsonrpc" => "2.0");
        $response["result"] = null;
        $response["error"] = null;
        if ($this->_checkRequest($jsonRpc)) {
            $this->_callJsonRpcMethod($jsonRpc, $response);
        }
        return $response;
    }

    private function _checkRequest($jsonRpc) {
        if (!isset($jsonRpc->method)) {
            $response["error"] = array("code" => "-32600", "message" => "Invalid Request.");
            return false;
        }
        return true;
    }

    private function _callJsonRpcMethod($jsonRpc, &$response) {
        if (isset($jsonRpc->id)) $response["id"] = $jsonRpc->id;
        $method = $jsonRpc->method;

        foreach ($this->handlers as $cls) {
            $r = $cls->callJsonRPC($method, (isset($jsonRpc->params)?$jsonRpc->params:null));
            if ($r != null) {
                $response["result"] = $r["result"];
                $response["error"] = $r["error"];
                return;
            }
        }

        $response["error"] = array("code" => "-32601", "message" => "Method not found.");
    }

    public static function getInvalidParamsError() {
        return array("errorCode" => -32602, "errorMessage" => "Invalid params.");
    }

    public static function setInvalidParamsError($cls) {
        $cls->errorCode = -32602;
        $cls->errorMessage = "Invalid params.";
    }

}
