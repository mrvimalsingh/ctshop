<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 7/2/11
 * Time: 3:03 PM
 * To change this template use File | Settings | File Templates.
 */

class CategoryModel extends Activerecord\Model {
    static $table_name = 'categories';
    static $has_many = array(
        array('categories_lang', 'class_name' => 'CategoryLangModel', 'foreign_key' => 'category_id'),
    );

    /**
     * returns the categories and subcategories with all the lang information as a nested array
     * + the lang values for the selected language as keys to the category object
     * @static
     * @param null $parent_id
     * @param null $language_id if this is left blank the default language will be selected to place in the category object
     * @param bool $rec if this is set to false it will not recurse (default true)
     * @return void
     */
    static function getAllCategoriesRecursive($parent_id = null, $language_id = null, $rec = true) {
        // if the language selected is null we must load the default language
        if ($language_id == null) {
            $language_obj = LanguageModel::getDefault();
            $language_id = $language_obj->id;
        }
        $categories = array();
        $categoryObjects = CategoryModel::all(array('conditions' => 'parent_id '.(($parent_id == null)?'is NULL':'= '.$parent_id)));
        if ($categoryObjects !== null && is_array($categoryObjects)) {
            foreach ($categoryObjects as $catObj) {
                $cat = Activerecord::createArrayFromModel($catObj, array('id', 'img', 'parent_id', 'order', 'appear_on_site'));
                // get language values
                $langObjects = CategoryLangModel::all(array('conditions' => 'category_id = '.$cat["id"]));
                $langArray = array();
                foreach ($langObjects as $langObj) {
                    $lang = Activerecord::createArrayFromModel($langObj, array('lang_id', 'name', 'keywords', 'short_desc', 'description'));
                    $langArray[] = $lang;
                    if ($language_id == $lang["lang_id"]) {
                        $cat['name'] = $lang['name'];
                        $cat['keywords'] = $lang['keywords'];
                        $cat['short_desc'] = $lang['short_desc'];
                        $cat['description'] = $lang['description'];
                    }
                }
                $cat["lang"] = $langArray;
                // get subcategories
                if ($rec) {
                    $subcategories = CategoryModel::getAllCategoriesRecursive($cat["id"], $language_id);
                    if ($subcategories != null) {
                        $cat["subcategories"] = $subcategories;
                    }
                }

                $categories[] = $cat;
            }
            return $categories;
        }
        return null;
    }

    static function searchCategories($query, $limit = 10) {
//        $query = mysql_real_escape_string($query);
        $categoryObjects = CategoryModel::all(
            array(
                 'conditions' => 'categories_lang.name LIKE \'%'.$query.'%\'',
                 "limit" => $limit,
                 'order' => '`order` ASC, `id` ASC',
                 'joins' => array('categories_lang'),
                 'group' => 'id'
            )
        );

        $categories = array();
        foreach ($categoryObjects as $c) {
            $cat = Activerecord::createArrayFromModel($c, array('id', 'img', 'parent_id', 'order', 'appear_on_site'));
            $lang = $c->getDefaultLangValues();
            $cat["name"] = $lang["name"];
            $categories[] = $cat;
        }

        return $categories;
    }

    static function getCategoriesForParent($parent_id = null, $language_id = null) {
        return CategoryModel::getAllCategoriesRecursive($parent_id, $language_id, false);
    }

    static function getCategoryArrayWithLanguages($category_id, $language_id = null) {
        if ($language_id == null) {
            $language_obj = LanguageModel::getDefault();
            $language_id = $language_obj->id;
        }
        $categoryObj = CategoryModel::find_by_id($category_id);
        if ($categoryObj != null) {
            $cat = Activerecord::createArrayFromModel($categoryObj, array('id', 'img', 'parent_id', 'order', 'appear_on_site'));
            $langObjects = CategoryLangModel::all(array('conditions' => 'category_id = '.$cat["id"]));
            $langArray = array();
            foreach ($langObjects as $langObj) {
                $lang = Activerecord::createArrayFromModel($langObj, array('lang_id', 'name', 'keywords', 'short_desc', 'description'));
                $langArray[] = $lang;
                if ($language_id == $lang["lang_id"]) {
                    $cat['name'] = $lang['name'];
                    $cat['keywords'] = $lang['keywords'];
                    $cat['short_desc'] = $lang['short_desc'];
                    $cat['description'] = $lang['description'];
                }
            }
            $cat["lang"] = $langArray;
            return $cat;
        }
        return null;
    }

//    function getSimpleCategories($language_id = null) {
//        if ($language_id == null) {
//            $language_obj = LanguageModel::getDefault();
//            $language_id = $language_obj->id;
//        }
//        $categories = CategoryModel::all();
//        $resultArr = array();
//        foreach ($categories as $cat) {
//            $category_lang = CategoryLangModel::find(array('conditions' => 'category_id = '.$cat->id.' AND lang_id = '.$language_id));
//            $resultArr[] = array($cat->id, $category_lang->name);
//        }
//        return $resultArr;
//    }

    function getDefaultLangValues($language_id = null) {
        if ($language_id == null) {
            $language_obj = LanguageModel::getDefault();
            $language_id = $language_obj->id;
        }
        $deflang['name'] = "";
        $deflang['keywords'] = "";
        $deflang['short_desc'] = "";
        $deflang['description'] = "";
        foreach ($this->categories_lang as $lang) {
            if ($lang->lang_id == $language_id) {
                $deflang['name'] = $lang->name;
                $deflang['keywords'] = $lang->keywords;
                $deflang['short_desc'] = $lang->short_desc;
                $deflang['description'] = $lang->description;
                break;
            }
        }
        return $deflang;
    }

    function loadFromObject($category) {
        //        'id', 'parent_id', 'order', 'appear_on_site'
        if ((!isset($this->id) || $this->id == null) && isset($category->id) && $category->id != null) $this->id = $category->id;
        $this->parent_id = (isset($category->parent_id))?$category->parent_id:null;
        $this->order = (isset($category->order))?$category->order:0;
        $this->img = (isset($category->img))?$category->img:null;
        $this->appear_on_site = (isset($category->appear_on_site))?$category->appear_on_site:'n';
    }

}
