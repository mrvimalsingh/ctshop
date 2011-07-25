<!-- load the top level categories from the webservice -->
<script type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=base_url()?>ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.jstree.js"></script>

<table width="100%">
    <tr>
        <td valign="top" width="300px">
            <fieldset width="100%" class="ui-widget-content ui-corner-all">
                    <legend class="ui-corner-all ui-widget-header" style="padding: 5px;">Alege categoria pentru a modifica.</legend>
                <button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon" onclick="editCategory(0)">
                    <span class="ui-icon ui-icon-plusthick"></span><span class="ui-button-text">Categorie Noua</span>
                </button>
                <div id="categories_tree"></div>
            </fieldset>
        </td>
        <td valign="top">
            <div id="edit_category">

                <fieldset width="100%" class="ui-widget-content ui-corner-all">
                    <legend class="ui-corner-all ui-widget-header" style="padding: 5px;">Adauga/Modifica Categorie</legend>
                    <table>
                        <tr>
                            <td colspan="2">
                                <!-- IMAGINE -->
                                <div id="categoryImage"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a href="javascript:void(0)" onclick="startSelectImage('categories')">Select an image</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="visible_on_site">Visible on site: </label>
                            </td>
                            <td>
                                <input type="checkbox" id="visible_on_site" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="javascript:void(0);" onclick="moveSelectedCategory('up')">
                                    <img src="<?=base_url()?>img/arrow_top.png" />
                                </a>
                            </td>
                            <td>
                                <a href="javascript:void(0);" onclick="moveSelectedCategory('down')">
                                    <img src="<?=base_url()?>img/arrow_down.png" />
                                </a>
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
                                <div id="selected_category_parent"></div>
                                <a href="javascript:void(0)" id="add_category_parent" onclick="startSelectCategory()">Select category parent</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="button" value="Salveaza" onclick="saveCategory()" />
                                <input type="button" value="sterge" onclick="deleteCategory()" />
                            </td>
                        </tr>
                    </table>
                </fieldset>

            </div>
        </td>
    </tr>
</table>


<div id="categoryImageSelect"></div>
<div id="categoryParentSelect"></div>

<!-- TODO add category properties -->

<script>

    var categories;
    var selectedCategory = {};

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
        if (category_id > 0) {
            findCategory(categories, category_id);
        } else {
            selectedCategory = {};
        }
        populateEditCategoryForm();
    }

    function populateEditCategoryForm() {
        // clear everything out first
        loadCategoryImage();
        loadParentCategoryLabel(null, categories);
        $('#visible_on_site').attr('checked', false);
    <? foreach ($languages_array as $lang): ?>
        $('#add_category_name\\[<?=$lang["id"]?>\\]').val('');
        $('#add_category_keywords\\[<?=$lang["id"]?>\\]').val('');
        $('#add_category_short_desc\\[<?=$lang["id"]?>\\]').val('');
        $('#add_category_description\\[<?=$lang["id"]?>\\]').val('');
        <? endforeach; ?>
        if (selectedCategory != undefined && selectedCategory != null) {
            $('#visible_on_site').attr('checked', selectedCategory.appear_on_site == 'y');
            loadParentCategoryLabel(selectedCategory.parent_id, categories);
            $(selectedCategory.lang).each(function (index, item) {
                $('#add_category_name\\['+item.lang_id+'\\]').val(item.name);
                $('#add_category_keywords\\['+item.lang_id+'\\]').val(item.keywords);
                $('#add_category_short_desc\\['+item.lang_id+'\\]').val(item.short_desc);
                $('#add_category_description\\['+item.lang_id+'\\]').val(item.description);
                // set the image and the parent category
            });
        }
    }

    function loadCategoryImage() {
        if (selectedCategory != undefined && selectedCategory != null
                && selectedCategory.img != undefined && selectedCategory.img != null) {
            $('#categoryImage').html('<img src="<?=site_url('images/get_image_improved/categories/c100');?>/'+selectedCategory.img+'" style="padding:5px;border:#aaa dotted 1px;margin:5px;" />');
        } else {
            // default image
            $('#categoryImage').html("category has no image...");
        }
    }

    function saveCategory() {
        // prepare data
        selectedCategory.lang = [];
        <? foreach ($languages_array as $lang): ?>
        selectedCategory.lang.push({
                "lang_id": '<?=$lang["id"]?>',
                "name": $('#add_category_name\\[<?=$lang["id"]?>\\]').val(),
                "keywords": $('#add_category_keywords\\[<?=$lang["id"]?>\\]').val(),
                "short_desc": $('#add_category_short_desc\\[<?=$lang["id"]?>\\]').val(),
                "description": $('#add_category_description\\[<?=$lang["id"]?>\\]').val()
                });
        <? endforeach; ?>
        selectedCategory.appear_on_site = $('#visible_on_site').attr('checked')?'y':'n';
        makeJsonRpcCall('categories', 'saveCategory', selectedCategory, function (data) {
            if (data.error != null) {
                alert(data.error.message);
            } else {
                alert('category saved!');
                loadCategoryTree();
                editCategory(0); // make a new category after this;
            }
        });
    }

    function deleteCategory() {
        if (!confirm("Are you sure you want to delete the category?")) return;
        makeJsonRpcCall('categories', 'deleteCategory', {"id": selectedCategory.id}, function (data) {
            if (data.error != null) {
                alert(data.error.message);
            } else {
                alert('category deleted!');
                editCategory(0);
                loadCategoryTree();
            }
        });
    }

    function selectCategory(parentId) {
        // select the parent category
        selectedCategory.parent_id = parentId;
        // set the name that appears on the label
        loadParentCategoryLabel(parentId, categories);
        $('#category_select_dialog').dialog('close');
    }

    function loadParentCategoryLabel(parentId, categoriesArr) {
        if (parentId == null) {
            $('#selected_category_parent').html(' - Categorie principala - ');
        } else {
            $(categoriesArr).each(function (index, item) {
                if (item.id == parentId) {
                    $('#selected_category_parent').html(item.name);
                    return false;
                } else {
                    loadParentCategoryLabel(parentId, item.subcategories);
                }
            });
        }
    }

    function loadCategoryTree() {
        categories = null;
        jsonTreeData = null;
        $("#categories_tree").empty();
        makeJsonRpcCall('categories', 'getCategories', null, function (data) {
            if (data.error != null) {
                alert(data.error.message);
            } else {
                categories = data.result;
                jsonTreeData = convertCategoriesObjectToJsTree(data.result);
                $("#categories_tree").jstree({
                            "themes" : {
                                        "theme" : "classic",
                                        "dots" : true,
                                        "icons" : true
                                    },
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

    function moveSelectedCategory(direction) {
        makeJsonRpcCall('categories', 'moveCategory', {'id':selectedCategory.id, 'direction':direction}, function (data) {
            if (data.error != null) {
                alert(data.error.message);
            } else {
                if (!data.result) {
                    alert('category could not be moved');
                } else {
                    loadCategoryTree();
                }
            }
        });
    }

    loadCategoryTree();

    $('#categoryLanguageTabs').tabs();
    <? foreach ($languages_array as $lang): ?>
    $('#add_category_description\\[<?=$lang["id"]?>\\]').ckeditor();
        <?php endforeach; ?>

    function selectImage(imageCategory, hash) {
        selectedCategory.img = hash;
        loadCategoryImage();
        $('#image_select_dialog').dialog('close');
    }

    $('#categoryImageSelect').load('<?=site_url('images/ajax_select')?>');
    $('#categoryParentSelect').load('<?=site_url('admin/categories_new/select')?>');

</script>
