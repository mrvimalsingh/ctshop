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
        $('#templateCategoryShortDesc').html(category.short_desc);
        return $("#templateCategoryCard").html();
    }
</script>

<div>Categorii: </div>
<div id="categories"></div>

<div id="templateCategoryCard" style="visibility: hidden;display: none;">
    <div style="float: left;width: 218px;height: 234px; background-image: url('<?=base_url();?>/img/category_card.png')">
        <div style="padding-top: 15px;margin-left: 15px;font-size: 14px; font-weight: bold;"><span id="templateCategoryName"></span></div>
        <div style="margin-left: 15px;">
            <img src="" width="50px" height="50px" style="float: left;" />
            <div style="font-size: 12px; font-weight: normal; padding: 3px" id="templateCategoryShortDesc"></div>
        </div>
        <div style="clear: both;line-height: 0px;"></div>
        <div style="margin-left: 15px;margin-right: 15px;">
            <table width="100%" style="font-size: 12px; font-weight: bold;">
                <tr>
                    <td>Subcategorii:</td>
                    <td align="right">3</td>
                </tr>
                <tr>
                    <td>Produse:</td>
                    <td align="right">102</td>
                </tr>
                <tr>
                    <td>Activ:</td>
                    <td align="right">Da</td>
                </tr>
            </table>
        </div>
        <div style="margin-left: 15px;margin-right: 15px;" align="center">
            <table width="70%" style="font-size: 12px; font-weight: bold;">
                <tr>
                    <td>L</td>
                    <td align="right">R</td>
                </tr>
                <tr>
                    <td>Edit</td>
                    <td align="right">Delete</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script>
    updateCategories(null);
</script>