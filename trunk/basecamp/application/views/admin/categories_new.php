<!-- load the top level categories from the webservice -->
<script type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=base_url()?>ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jsonrpc.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.jstree.js"></script>
<script>
    baseUri = '<?=base_url();?>';
</script>

<table width="100%">
    <tr>
        <td valign="top" width="300px">
            Alege categoria pentru a modifica.
            <div id="categories_tree"></div>
            <a href="javascript:void(0)" onclick="editCategory(0)">Categories Noua</a>
        </td>
        <td valign="top">
            <div id="edit_category">

                <fieldset width="100%">
                    <legend>Adauga/Modifica Categorie</legend>
                    <table>
                        <tr>
                            <td colspan="2">
                                <!-- IMAGINE -->
                                <img src="" style="padding:5px;border:#aaa dotted 1px;margin:5px;" width="50px" height="50px" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="file">Imagine:</label>
                            </td>
                            <td>
                                <input type="file" name="file" id="file" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="categoryLanguageTabs">
                                    <ul>
                                        <? foreach ($languages_array as $lang): ?>
                                        <li><a href="#lang_tab_<?=$lang["code"]?>"><?=$lang["name"]?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <? foreach ($languages_array as $lang): ?>
                                    <div id="lang_tab_<?=$lang["code"]?>">
                                        <table>
                                            <tr>
                                                <td><label>Denumire: </label></td>
                                                <td>
                                                    <input type="text" id="add_category_name[<?=$lang["id"]?>]" name="add_category_name[<?=$lang["id"]?>]"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label>Cuvinte cheie: </label></td>
                                                <td>
                                                    <input type="text" id="add_category_keywords[<?=$lang["id"]?>]" name="add_category_keywords[<?=$lang["id"]?>]" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label>Descriere scurta: </label></td>
                                                <td>
                                                    <input type="text" id="add_category_short_desc[<?=$lang["id"]?>]" name="add_category_short_desc[<?=$lang["id"]?>]" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top"><label>Descriere: </label></td>
                                                <td>
                                                    <textarea id="add_category_description[<?=$lang["id"]?>]" name="add_category_description[<?=$lang["id"]?>]"></textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="add_category_parent">Categorie parinte</label></td>
                            <td>
                                <select id="add_category_parent" name="add_category_parent">
                                    <option value="0"> - categorie principala - </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" value="Salveaza" />
                                <input type="button" value="sterge" onclick="deleteCategory()" />
                            </td>
                        </tr>
                    </table>
                </fieldset>

            </div>
        </td>
    </tr>
</table>

<script>

    var categories;
    var selectedCategory;

    function findCategory(categoriesArr, category_id) {
        $(categoriesArr).each(function (index, item) {
            if (item.id == category_id) {
                selectedCategory = item;
                return false;
            } else {
                findCategory(item.subcategories, category_id);
            }
        });
    }

    function editCategory(category_id) {
        // load category from categories arr
        findCategory(categories, category_id);
        populateEditCategoryForm();
    }

    function populateEditCategoryForm() {
        if (selectedCategory != undefined) {
            $(selectedCategory.lang).each(function (index, item) {
                $('#add_category_name\\['+item.lang_id+'\\]').val(item.name);
                $('#add_category_keywords\\['+item.lang_id+'\\]').val(item.keywords);
                $('#add_category_short_desc\\['+item.lang_id+'\\]').val(item.short_desc);
                $('#add_category_description\\['+item.lang_id+'\\]').val(item.description);
                // set the image and the parent category
            });
        } else {
            // clear everything....
        }
    }

    function saveCategory() {

    }

    function deleteCategory() {

    }

    function loadCategoryTree() {
        makeJsonRpcCall('categories', 'getCategories', null, function (data) {
            if (data.error != null) {
                alert(data.error.message);
            } else {
                categories = data.result;
                jsonTreeData = convertCategoriesObjectToJsTree(data.result);
                $("#categories_tree").jstree({
                            "json_data" : {
                                "data" : jsonTreeData
                            },
                            "plugins" : [ "themes", "json_data", "ui" ]
                        }).bind("select_node.jstree", function (e, data) { editCategory(data.rslt.obj.attr("category_id")) });
            }
        });
    }

    function convertCategoriesObjectToJsTree(categories) {
        var jstreeData = [];
        $(categories).each(function (index, item) {
            jstreeData.push({
                        "data": item.name,
                        "attr" : { "category_id" : item.id },
                        "state" : "open",
                        "children" : convertCategoriesObjectToJsTree(item.subcategories)
                    });
        });
        return jstreeData;
    }

    loadCategoryTree();

    $('#categoryLanguageTabs').tabs();
    <? foreach ($languages_array as $lang): ?>
    $('#add_category_description\\[<?=$lang["id"]?>\\]').ckeditor();
    <?php endforeach; ?>

</script>