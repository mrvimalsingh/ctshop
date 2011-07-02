<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 4/9/11
 * Time: 1:27 AM
 * To change this template use File | Settings | File Templates.
 */

/**
 * Init for php.activerecord
 */

// Load php.activerecord
require_once APPPATH.'/libraries/php-activerecord/ActiveRecord.php';

// Load CodeIgniter's Model class
require_once BASEPATH.'/libraries/Model.php';

class Activerecord {

    function __construct() {
        global $config;
        // Load database configuration from CodeIgniter
        include APPPATH.'/config/site_config.php';

        // Get connections from database.php
        $dsn = array();
        if ($config["db"]) {
            // Convert to dsn format
            $dsn["default"] = $config["db"]['dbdriver'] .
                              '://'   . $config["db"]['username'] .
                              ':'     . $config["db"]['password'] .
                              '@'     . $config["db"]['hostname'] .
                              '/'     . $config["db"]['database'];
        }
        $active_group = "default";

        // Initialize ActiveRecord
        ActiveRecord\Config::initialize(function($cfg) use ($dsn, $active_group){
                $cfg->set_model_directory(APPPATH.'/models');
                $cfg->set_connections($dsn);
                $cfg->set_default_connection($active_group);
            });

    }

    /**
     * utility function to get only the desired fields from a db model and turn it into an array
     * @static
     * @param  $model
     * @param  $params
     * @return array
     */
    static function createArrayFromModel($model, $params) {
        $res = array();
        foreach ($params as $p) {
            $res[$p] = $model->$p;
        }
        return $res;
    }
}

/* End of file Activerecord.php */
/* Location: ./application/libraries/Activerecord.php */
?>