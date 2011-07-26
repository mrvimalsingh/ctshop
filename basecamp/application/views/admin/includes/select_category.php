<!-- IMAGE SELECTION DIALOG STUFF -->
<div id="category_select_dialog">
    <div>
        <input type="text" id="selectCategoryFilter" onkeyup="searchCategory(this.value)" />
    </div>
    <div><a href="javascript:void(0);" onClick="selectCategory(null);" style="margin:5px;">Root category</a></div>
    <div id="category_select_dialog_search_results"></div>
</div>
<script>

    $('#category_select_dialog').dialog({ title: 'Select a category:', height: 530, width: 600, autoOpen:false });

    function startSelectCategory() {
        $('#category_select_dialog').dialog('open');
        $('#selectCategoryFilter').focus();
        searchCategory('');
    }

    function searchCategory(query) {
        // TODO add ajax loader image...
        makeJsonRpcCall('categories', 'searchCategory', {'query':query}, function (data) {
            // TODO delete ajax loader image
            if (data.error != null) {
                alert(data.error.message);
            } else {
                $('#category_select_dialog_search_results').empty();
                var categories = data.result;
                $(categories).each(function (index, item) {
                    $('#category_select_dialog_search_results').prepend('<div class="ui-grid-header ui-widget-header ui-corner-all" style="margin: .5em;vertical-align: middle"><a href="javascript:void(0);" onClick="selectCategory(\''+item.id+'\');" style="margin:5px;"><img src="<?=base_url()?>/images/get_image_improved/categories/c30/'+item.img+'" style="border: 0;" />'+item.name+'</a></div>');
                });
            }
        });
    }
</script>