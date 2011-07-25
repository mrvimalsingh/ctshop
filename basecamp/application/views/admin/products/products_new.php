<script>
    baseUri = '<?=base_url();?>';
</script>
<style>
    .styleTable { border-collapse: separate; }
    .styleTable TD { font-weight: normal !important; padding: .4em; border-top-width: 0px !important; }
    .styleTable TH { text-align: center; padding: .8em .4em; }
    .styleTable TD.first, .styleTable TH.first { border-left-width: 0px !important; }
</style>
<script>
    (function ($) {
        $.fn.styleTable = function (options) {
            var defaults = {
                css: 'styleTable ui-widget ui-widget-content ui-corner-all'
            };
            options = $.extend(defaults, options);

            return this.each(function () {

                input = $(this);
                input.addClass(options.css);

                input.find("tr").live('mouseover mouseout', function (event) {
                    if (event.type == 'mouseover') {
                        $(this).children("td").addClass("ui-state-hover");
                    } else {
                        $(this).children("td").removeClass("ui-state-hover");
                    }
                });

                input.find("th").addClass("ui-state-default");
                input.find("td").addClass("ui-widget-content");

                input.find("tr").each(function () {
                    $(this).children("td:not(:first)").addClass("first");
                    $(this).children("th:not(:first)").addClass("first");
                });
            });
        };
    })(jQuery);

    function loadProducts() {
//        product_table_data
        makeJsonRpcCall('products', 'getProducts', {'limit':10, 'offset':0, 'filters':null}, function (data) {
            if (data.error != null) {
                alert(data.error.message);
            } else {
                $('#product_table_data').empty();
                $(data.result).each(function (index, item) {
                    addProductRow(item);
                });
                $("#myTable").styleTable();
//                alert(data.result);
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
        $("#myTable").styleTable();
        loadProducts();
    });
</script>

<div class="ui-grid-header ui-widget-header ui-corner-top" style="padding: 5px">jQuery UI Grid Header</div>
<table id="myTable" width="100%" class="">
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
    </tbody>
</table>
<div class="ui-grid-header ui-widget-header ui-corner-bottom" style="padding: 5px">jQuery UI Grid Header</div>