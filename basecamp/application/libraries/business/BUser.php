<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 7/24/11
 * Time: 5:11 AM
 * To change this template use File | Settings | File Templates.
 */

class BUser {

    var $errorCode = 0;
    var $errorMessage = "";

    function authenticate($params) {
        // params must be a username and a password hash
        if (is_object($params) && isset($params->userName) && isset($params->password) && isset($params->salt)) {
            $user = UserModel::authenticateUser($params->userName, $params->password, $params->salt);
            if ($user === false) {
                $this->errorCode = -1;
                $this->errorMessage = "Authentication failure!";
            }
            if ($user !== false) {
                $CI = &get_instance();
                $CI->load->library('session');
                $CI->session->set_userdata('user_id', $user->id);
                return true;
            }
            return false;
        } else {
            JsonRpc::setInvalidParamsError($this);
        }
        return false;
    }

}
