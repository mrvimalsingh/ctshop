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

    function schema($ws = null) {
        $this->load->library('webservice/WebServiceImpl');
        $this->webserviceimpl->getDescriptor($ws);
    }

    function jsonrpc($ws = null) {
        $this->load->library('webservice/JsonRpc');
        $this->load->library('webservice/WebServiceImpl.php');
        $this->webserviceimpl->setSelectedGroup($ws);
        $this->jsonrpc->registerHandlerClass($this->webserviceimpl);
        $this->jsonrpc->startJsonRpc();
    }

}
