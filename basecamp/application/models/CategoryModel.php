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

    /**
     * returns the categories and subcategories with all the lang information as a nested array
     * + the lang values for the selected language as keys to the category object
     * @static
     * @param null $parent_id
     * @param null $language_id if this is left blank the default language will be selected to place in the category object
     * @return void
     */
    static function getAllCategoriesRecursive($parent_id = null, $language_id = null) {
        // if the language selected is null we must load the default language
        if ($language_id == null) {
            $language_obj = LanguageModel::getDefault();
            $language_id = $language_obj->id;
        }
        $categories = array();
        $categoryObjects = CategoryModel::all(array('conditions' => 'parent_id '.(($parent_id == null)?'is NULL':'= '.$parent_id)));
        if ($categoryObjects !== null && is_array($categoryObjects)) {
            foreach ($categoryObjects as $catObj) {
                $cat = Activerecord::createArrayFromModel($catObj, array('id', 'parent_id', 'order', 'appear_on_site'));
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
                $subcategories = CategoryModel::getAllCategoriesRecursive($cat["id"], $language_id);
                if ($subcategories != null) {
                    $cat["subcategories"] = $subcategories;
                }

                $categories[] = $cat;
            }
            return $categories;
        }
        return null;
    }

    static function getCategoryArrayWithLanguages($category_id, $language_id = null) {
        if ($language_id == null) {
            $language_obj = LanguageModel::getDefault();
            $language_id = $language_obj->id;
        }
        $categoryObj = CategoryModel::find_by_id($category_id);
        if ($categoryObj != null) {
            $cat = Activerecord::createArrayFromModel($categoryObj, array('id', 'parent_id', 'order', 'appear_on_site'));
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

    function loadFromObject($category) {
//        'id', 'parent_id', 'order', 'appear_on_site'
        if (!isset($this->id) || $this->id == null) $this->id = $category->id;
        $this->parent_id = $category->parent_id;
        $this->order = $category->order;
        $this->appear_on_site = $category->appear_on_site;
    }

}
