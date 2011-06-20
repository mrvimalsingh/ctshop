<table>
    <tr>
        <td>
            <fieldset>
                <legend>Discount-uri</legend>
                <div id="discounts_table"></div>
            </fieldset>
        </td>
        <td>
            <fieldset>
                <legend>Produse pe discount</legend>
                cautare<br />
                d'n'd
            </fieldset>
        </td>
    </tr>
</table>

<script type="text/javascript">
    function loadDiscounts(page) {
        if (page == "" || page < 1) {
            page = 1;
        }
        $('#discounts_table').html("<img src='<?=base_url()?>img/ajax-loader.gif' />");
        $('#discounts_table').load(
                '<?=site_url("admin/discounts/table"); ?>/'+page
            );
    }
    function loadDiscountProducts(discountId) {

    }
    function addProductToDiscount(discountId, productId) {

    }

    loadDiscounts(0);

</script>