<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 7/24/11
 * Time: 5:11 AM
 * To change this template use File | Settings | File Templates.
 */
 
class BUser {

    function login($params) {
        // params must be a username and a password hash
        if (is_object($params) && isset($params->userName) && isset($params->pass) && isset($params->salt)) {
            $user = UserModel::authenticateUser($params->userName, $params->pass, $params->salt);
            if ($user === false) {
                $this->errorCode = -1;
                $this->errorMessage = "Authentication failure!";
            }
            return ($user !== false);
        } else {
            JsonRpc::setInvalidParamsError($this);
        }
    }

}
