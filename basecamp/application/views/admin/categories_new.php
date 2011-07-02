<!-- load the top level categories from the webservice -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/jsonrpc.js"></script>
<script>
    baseUri = '<?=base_url();?>';
    var parentCategory = null;

    function updateCategories(parent_id) {
        parentCategory = parent_id;

        makeJsonRpcCall('categories', 'getCategoriesForParent', {"parent_id":parentCategory}, function (data) {
                if (data.error != null) {
                    alert(data.error.message);
                } else {
                    alert('test');
                    $(data.result).each(function (index, item) {
                        alert(item.name);
                        $('#categories').append(createCategoryCardHTML(item));
                    });
                }
            });
    }

    function createCategoryCardHTML(category) {
        $("#templateCategoryName").html(category.name);
        return $("#templateCategoryCard").html();
    }
</script>

<div>Categorii: </div>
<div id="categories"></div>

<div id="templateCategoryCard" style="visibility: hidden;display: none;">
    <div style="float: left;width: 230px;height: 261px; background-image: url('<?=base_url();?>/img/category_card.png')">Category card: <span id="templateCategoryName"></span></div>
</div>
<script>
    updateCategories(null);
</script>