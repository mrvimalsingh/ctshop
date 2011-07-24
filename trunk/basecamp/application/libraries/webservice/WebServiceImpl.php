<?php
/**
 * User: codetwister
 * Date: 7/23/11
 * Time: 10:22 PM
 * all the webservices for this project will be handled by this class...
 * all methods invoked by the webservices implementation must follow these rules:
 * 1. Every method returns a status object containing: errorCode, errorMessage, and response
 * The webservices implementation will check if parameters are set based on the configuration file
 */
 
class WebServiceImpl {

    var $errorCode = 0;
    var $errorMessage = "";
    var $descriptors;
    var $selectedGroup;

    function __construct() {
        // load webservice descriptors
        $jsonData = file_get_contents(FCPATH."basecamp/application/libraries/webservice/webservice_descriptors.json");
        $this->descriptors = json_decode($jsonData, true);
        // replace {{domain}} with current domain...
        array_walk_recursive($this->descriptors, array($this, '_replaceDomain'));
    }

    function getDescriptor($ws) {
        if (isset($this->descriptors[$ws])) {
            echo json_encode($this->descriptors[$ws]);
        } else {
            $webservices = array();
            foreach ($this->descriptors as $w) {
                if (is_array($w)) {
                    $webservices[] = array(
                        "id" => $w["id"],
                        "description" => $w["description"],
                        "version" => $w["version"],
                        "location" => isset($w["location"])?$w["location"]:""
                    );
                }
            }
            $data = array(
                "error" => "there is no such webservice: ".$ws,
                "available_webservices" => $webservices
            );
            // list webservices
            echo json_encode($data);
        }
    }

    function setSelectedGroup($group) {
        $this->selectedGroup = $group;
    }

    function callJsonRPC($method, $params = null) {
        // check if the method exists...
        if (!$this->checkMethod($this->selectedGroup, $method)) return null;
        if (!$this->checkParams($this->selectedGroup, $method, $params)) {
            return array("result" => null, "error" => JsonRpc::getInvalidParamsError());
        }
        // load class
        $CI = &get_instance();
        $handlerClassName = $this->descriptors[$this->selectedGroup]["handlerClass"];
        $handlerClassNameLc = strtolower($handlerClassName);
        $CI->load->library('business/'.$handlerClassName);
        $result = $CI->$handlerClassNameLc->$method($params);
        $errorCode = $CI->$handlerClassNameLc->errorCode;
        $errorMessage = $CI->$handlerClassNameLc->errorMessage;
        return array("result" => $result, "error" => ($errorCode != 0)?array('errorCode' => $errorCode, 'errorMessage' => $errorMessage):null);
    }

    function checkParams($group, $method, $params = null) {
        // TODO Mihaly 7/24/11 TOP implement validation of params...
        return true;
    }

    function checkMethod($group, $method) {
        if (!isset($this->descriptors[$group])) return false;
        $descriptor = $this->descriptors[$group];
        if (!isset($descriptor[$method])) return false;
        $method = $descriptor[$method];
        if (!isset($method["type"]) || $method["type"] != "method") return false;
        return true;
    }

    function _replaceDomain(&$item, $key) {
        if (in_array($key, array("id", "type", "returns", "location"))) {
            $item = str_replace("{{domain}}", base_url(), $item);
        }
    }

}
