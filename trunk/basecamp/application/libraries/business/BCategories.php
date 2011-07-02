<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 7/2/11
 * Time: 6:03 PM
 * To change this template use File | Settings | File Templates.
 */
 
class BCategories {

    /**
     * saves/updates a category from a json-rpc call
     * @param  $categoryJson
     * @return a status array which contains the error message if needed
     * {category_id:'', errorCode:'', errorMessage:''}
     */
    function saveCategoryFromJsonObject($categoryJson) {
        // TODO make a sanity check to see if required parameters are set and check if the user has privileges to update a category
        $category = CategoryModel::find_by_id($categoryJson->id);
        if ($category == null) {
            $category = new CategoryModel();
        }
        $category->loadFromObject($categoryJson);
        $category->save();
        // also save languages
        $language_values = $categoryJson->lang;
        foreach ($language_values as $lang) {
            $category_lang = CategoryLangModel::find(array('conditions' => 'category_id = '.$category->id.' AND lang_id = '.$lang->lang_id));
            if ($category_lang == null) {
                $category_lang = new CategoryLangModel();
            }
            $category_lang->category_id = $category->id;
            $category_lang->lang_id = $lang->lang_id;
            $category_lang->name = $lang->name;
            $category_lang->keywords = $lang->keywords;
            $category_lang->short_desc = $lang->short_desc;
            $category_lang->description = $lang->description;

            $category_lang->save();
        }
        return array('category_id' => $category->id, 'errorCode' => 0, 'errorMessage' => '');
    }

    function deleteCategory($id) {
        $category = CategoryModel::find_by_id($id);
        if ($category == null) {
            return array('deleted' => false, 'errorCode' => -1, 'errorMessage' => 'Category not found');
        }
        // TODO check for critical dependencies
        // TODO delete dependencies
        $category->delete();
        return array('deleted' => true, 'errorCode' => 0, 'errorMessage' => '');
    }

}
