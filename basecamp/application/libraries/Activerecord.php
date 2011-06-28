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
        // Load database configuration from CodeIgniter
        // TODO make this load our custom configuration instead of the codeigniter default
        include APPPATH.'/config/database.php';
        // Get connections from database.php
        $dsn = array();
        if ($db) {
            foreach ($db as $name => $db_values) {
            	// Convert to dsn format
            	$dsn[$name] = $db[$name]['dbdriver'] .
            		'://'   . $db[$name]['username'] .
            		':'     . $db[$name]['password'] .
            		'@'     . $db[$name]['hostname'] .
            		'/'     . $db[$name]['database'];
            }
        }

        // Initialize ActiveRecord
        ActiveRecord\Config::initialize(function($cfg) use ($dsn, $active_group){
            $cfg->set_model_directory(APPPATH.'/models');
            $cfg->set_connections($dsn);
            $cfg->set_default_connection($active_group);
        });

    }
}

/* End of file Activerecord.php */
/* Location: ./application/libraries/Activerecord.php */
?>