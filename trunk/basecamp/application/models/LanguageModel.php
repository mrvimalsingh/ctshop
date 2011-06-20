<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 6/14/11
 * Time: 1:05 AM
 * To change this template use File | Settings | File Templates.
 */
 
class LanguageModel extends ActiveRecord\Model {
    static $table_name = 'languages';
    static $after_save = "checkLanguages";
    static $after_destroy = "checkLanguages";

    public static function getDefault() {
        $default_language = LanguageModel::find_by_default("y");
        return $default_language;
    }

    public static function getAdminDefault() {
        $default_language = LanguageModel::find_by_admin_default("y");
        return $default_language;
    }

    public function checkLanguages() {
        // TODO P1 check all tables that have language fields and add/remove fields from their tables
    }

}
