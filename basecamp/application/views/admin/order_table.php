<?=$pagination_links?>
<table class="mytable" width="100%">
	<thead>
		<th>Cod</th>
		<th>Data</th>
		<th>Client</th>
		<th>Total</th>
		<th>Status</th>
		<th>&nbsp;</th>
	</thead>
	<tbody>
		<?php foreach ($orders as $k => $order):?>
		<tr <?php if ($k % 2 == 0) echo "class='odd'"; ?>>
			<td><?=$order["order_nr"]?></th>
			<td><?=$order["date_added"]?></th>
			<td><?=$order["client_name"]?></th>
			<td><?=$order["total"]?></th>
			<td><?=$order["status_text"]?></th>
			<td><a href="<?php echo site_url("admin/orders/edit_order"); ?>/<?=$order["id"]?>"><img src="<?php echo base_url(); ?>img/edit.png" border="0" /></a></th>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>