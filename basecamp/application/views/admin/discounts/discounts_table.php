<table class="mytable" width="100%">
	<thead>
		<th>Denumire</th>
		<th>Data inceput</th>
		<th>Data sfarsit</th>
		<th>Tip</th>
        <th>Valoare</th>
		<th>&nbsp;</th>
	</thead>
    <tbody>
        <? if (isset($discounts)): ?>
            <?php foreach ($discounts as $k => $discount) : ?>
            <tr <?php if ($k % 2 == 0) echo "class='odd'"; ?>>
                <th><?=$discount["name"];?></th>
                <th><?=$discount["start_date"];?></th>
                <th><?=$discount["end_date"];?></th>
                <th><?=$discount["type"];?></th>
                <th><?=$discount["value"];?></th>
                <th>
                    <a href="javascript:void(0);" onclick="removeDiscount('<?=$discount["id"];?>')">
                        <img src="<?=base_url(); ?>img/action_delete.png" border="0" />
                    </a>
                </th>
            </tr>
            <? endforeach; ?>
        <? else: ?>
            <tr>
                <td colspan="6"><strong style="color:#ff0000;">No data</strong></td>
            </tr>
        <? endif; ?>
    </tbody>
</table>