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
        $category = null;
        if (isset($categoryJson->id)) {
            $category = CategoryModel::find_by_id($categoryJson->id);
        }
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
        $this->fixCategoryOrderRecursive();
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

    function fixCategoryOrderRecursive($parent_id = null) {
        $parent_condition = ($parent_id != null)?'`parent_id` = '.$parent_id:'`parent_id` IS NULL';
        $categories = CategoryModel::all(array('conditions' => $parent_condition, 'order' => '`order` ASC'));
        $order = 0;
        if ($categories != null) {
            foreach ($categories as $c) {
                $c->order = $order;
                $c->save();
                $order++;
                $this->fixCategoryOrderRecursive($c->id);
            }
        }
    }

    /**
     * @param  $category_id
     * @param  $direction up|down
     * @return boolean true if the operation is successful false otherwise
     */
    function moveCategory($category_id, $direction) {
        $category = CategoryModel::find_by_id($category_id);
        if ($category == false) {
            return false; // category was not found
        }
        $parent_condition = ($category->parent_id != null)?'`parent_id` = '.$category->parent_id:'`parent_id` IS NULL';
        if ($direction == 'up') {
            // get next
            $other = CategoryModel::first(array('conditions' => "`order` < '".$category->order."' AND ".$parent_condition, 'order' => '`order` DESC'));
        } else if ($direction == 'down') {
            // get previous
            $other = CategoryModel::first(array('conditions' => "`order` > '".$category->order."' AND ".$parent_condition, 'order' => '`order` ASC'));
        }
        if ($other != null) {
            // swap orders...
            $t = $other->order;
            $other->order = $category->order;
            $other->save();

            $category->order = $t;
            $category->save();
        } else {
            return false;
        }
        return true;
    }

}
