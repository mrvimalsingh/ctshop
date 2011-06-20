<fieldset>
    <legend>Filtrari</legend>
    <table>
        <tr>
            <td>Client: </td>
            <td>
                <input type="text" id="filter_client" name="filter_client" />
                <input type="hidden" id="filter_client_id" name="filter_client_id" />
            </td>
            <td>
                <input type="button" value="clear" onclick="clearClient()" />
            </td>
            <td>Status: </td>
            <td>
                <?php echo form_dropdown('filter_status', $status_options, 'n', 'id="filter_status" onChange="loadOrders(0);"');?>
            </td>
            <td>Data inceput: </td>
            <td><input type="text" id="filter_start_date" name="filter_start_date" onChange="loadOrders(0);" /></td>
            <td>Data sfarsit: </td>
            <td><input type="text" id="filter_end_date" name="filter_end_date" onChange="loadOrders(0);" /></td>
        </tr>
    </table>
</fieldset>
<fieldset>
    <legend>Comenzi</legend>
    <div id="order_table"></div>
</fieldset>

<script>
    $("#filter_start_date").datepicker({dateFormat:'yy-mm-dd'});
    $("#filter_end_date").datepicker({dateFormat:'yy-mm-dd'});

    function loadOrders(page) {
        if (page == "") {
            page = 1;
        }
        $('#order_table').html("<img src='<?=base_url()?>img/ajax-loader.gif' />");

        var client_id = $('#filter_client_id').val();
        var start_date = $('#filter_start_date').val();
        var end_date = $('#filter_end_date').val();
        if (client_id == '') client_id = 0;
        if (start_date == '') start_date = 0;
        if (end_date == '') end_date = 0;

        var qStr = $('#filter_status').val()+'/'+
                client_id+'/'+
                start_date+'/'+
                end_date;
//		alert(qStr);
        $('#order_table').load(
                '<?php echo site_url("admin/orders/order_table"); ?>/'+page+'/'+qStr
                );
    }

    function clearClient() {
        $('#filter_client').val("");
        $('#filter_client_id').val(0);
        loadOrders(0);
    }

    $("#filter_client").autocomplete("<?php echo site_url("admin/clients/autocomplete"); ?>", {
        width: 260,
        selectFirst: false,
        noQueryString: true
    });

    $("#filter_client").result(function(event, data, formatted) {
        //alert(data[1]);
        $('#filter_client_id').val(data[1]);
        loadOrders(0);
    });

    loadOrders(0);
</script>