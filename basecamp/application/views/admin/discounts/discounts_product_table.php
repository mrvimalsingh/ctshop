<table class="mytable" width="100%">
    <thead>
        <th>Cod</th>
        <th>Denumire</th>
        <th>Pret</th>
        <th>Pret cu discount</th>
        <th>Data start</th>
        <th>Data sfarsit</th>
        <th>Valoare discount</th>
        <th>&nbsp;</th>
    </thead>
    <tbody>
        <?php foreach ($products as $k => $product):?>
            <tr <?php if ($k % 2 == 0) echo "class='odd'"; ?>>
                <td><?=$product["code"]?></td>
                <td><?=$product["name"]?></td>
                <td><?=$product["price"]?></td>
                <td><span id="discount_price_<?=$product["id"];?>">-calc-</span></td>
                <td><input type="text" id="discount_start_<?=$product["id"];?>"
                           onchange="saveDiscount('<?=$product["id"];?>')" /></td>
                <td><input type="text" id="discount_end_<?=$product["id"];?>" /></td>
                <td><input type="text" id="discount_val_<?=$product["id"];?>" /></td>
                <td>
                    <a href="javascript:void(0);" onclick="removeProductFromDiscount()">
                        <img src="<?=base_url(); ?>img/action_delete.png" border="0" />
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script type="text/javascript">
    function saveDiscount(productId) {
       <? // TODO M1 12/31/10 save discount ?>

    }
</script>