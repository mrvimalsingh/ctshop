<fieldset width="100%">
    <legend>Filtrari</legend>
    <table>
        <tr>
            <td>
                <label>Categorie: </label>
            </td>
            <td>
                <div id="selected_category"></div>
                <a href="javascript:void(0)" id="add_category_parent" onclick="startSelectCategory()">Select category</a>
            </td>
            <td>
                <label for="filter_discount">In reducere</label>
            </td>
            <td>
                <input type="checkbox" name="filter_discount" id="filter_discount" onchange="loadProducts(1);" />
            </td>
            <td>
                <label for="filter_in_stock">In stoc</label>
            </td>
            <td>
                <input type="checkbox" name="filter_in_stock" id="filter_in_stock" onchange="loadProducts(1);" />
            </td>
            <td>
                <label for="search_product_code">Cod produs: </label>
            </td>
            <td>
                <input type="text" name="search_product_code" id="search_product_code" />
            </td>
        </tr>
    </table>
</fieldset>
<fieldset width="100%">
    <legend>Produse</legend>
    <table class="fancy_table" width="100%">
        <thead>
        <tr>
            <th width="70px">Code</th>
            <th>Name</th>
            <th width="70px">Price</th>
            <th width="70px">In stock</th>
            <th width="70px">Available to order</th>
        </tr>
        </thead>
        <tbody id="product_table_data">
        <tr>
            <td>123</td>
            <td>some name</td>
            <td>239.23</td>
            <td>y</td>
            <td>n</td>
        </tr>
        </tbody>
    </table>

    <table id="testGrid" width="100%">
        <thead>
        <tr>
            <th width="70px">Code</th>
            <th>Name</th>
            <th width="70px">Price</th>
            <th width="70px">In stock</th>
            <th width="70px">Available to order</th>
        </tr>
        </thead>
        <tbody id="product_table_data">
        <tr>
            <td>123</td>
            <td>some name</td>
            <td>239.23</td>
            <td>y</td>
            <td>n</td>
        </tr>
        </tbody>
    </table>
    <input type="button" id="addProductButton" value="Adauga Produs" onclick="$('#add_product_div').dialog('open')" />
</fieldset>

<div id="categorySelect"></div>

<script>

    var selectCategory = function(categoryId) {
        // select the parent category
        alert('selected category: '+categoryId);
        $('#category_select_dialog').dialog('close');
    }

    function loadProducts() {
        makeJsonRpcCall('products', 'getProducts', {'limit':10, 'offset':0, 'filters':null}, function (data) {
            if (data.error != null) {
                alert(data.error.message);
            } else {
                $('#product_table_data').empty();
                $(data.result).each(function (index, item) {
                    addProductRow(item);
                });
            }
        });
    }

    function addProductRow(product) {
        $('#product_table_data').append("<tr>");
        $('#product_table_data').append("<td>"+product.code+"</td>");
        $('#product_table_data').append("<td>"+product.name+"</td>");
        $('#product_table_data').append("<td>"+product.price+"</td>");
        $('#product_table_data').append("<td>"+product.in_stock+"</td>");
        $('#product_table_data').append("<td>"+product.available_online+"</td>");
        $('#product_table_data').append("</tr>");
    }

    $(document).ready(function () {
        baseUri = '<?=base_url();?>';
        loadProducts();
        $('#addProductButton').button();
        $('#categorySelect').load('<?=site_url('admin/categories_new/select')?>');

        $("#testGrid").dataTable({
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers"
                });

    });

</script>