<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 7/2/11
 * Time: 3:03 PM
 * To change this template use File | Settings | File Templates.
 */
 
class CategoryLangModel extends Activerecord\Model {
    static $table_name = 'categories_lang';
    static $fields = array('lang_id', 'name', 'keywords', 'short_desc', 'description');
    static $lang_id_field = 'lang_id';
}
