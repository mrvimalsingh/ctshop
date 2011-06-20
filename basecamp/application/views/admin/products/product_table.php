<?=$pagination_links?>
<table class="mytable" width="100%">
	<thead>
		<th>Cod</th>
		<th>Denumire</th>
		<th>Pret</th>
		<th>In stoc</th>
		<th>Disponibil la comanda</th>
		<th>&nbsp;</th>
	</thead>
	<tbody>
		<?php foreach ($products as $k => $product):?>
		<tr <?php if ($k % 2 == 0) echo "class='odd'"; ?>>
			<td><?=$product["code"]?></td>
			<td><?=$product["name"]?></td>
			<td><?=$product["price"]?></td>
			<td>
				<? if ($product["in_stock"] == "y"): ?>
					<img src="<?=base_url()?>img/action_check.png" />
				<? endif; ?>
			</td>
			<td>
				<? if ($product["available_online"] == "y"): ?>
					<img src="<?=base_url()?>img/action_check.png" />
				<? endif; ?>
			</td>
			<td><a href="<?php echo site_url("admin/products/edit_product"); ?>/<?=$product["id"]?>"><img src="<?php echo base_url(); ?>img/edit.png" border="0" /></a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>