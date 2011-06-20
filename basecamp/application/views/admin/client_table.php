<?=$pagination_links?>
<table class="mytable" width="100%">
	<thead>
		<th>Data</th>
		<th>Client</th>
		<th>Telefon</th>
		<th>Email</th>
		<th>&nbsp;</th>
	</thead>
	<tbody>
		<?php foreach ($clients as $k => $client):?>
		<tr <?php if ($k % 2 == 0) echo "class='odd'"; ?>>
			<td><?=$client["date_added"]?></th>
			<td><?=$client["client_name"]?></th>
			<td><?=$client["phone"]?></th>
			<td><?=$client["email"]?></th>
			<td><a href="<?php echo site_url("admin/clients/edit_client"); ?>/<?=$client["id"]?>"><img src="<?php echo base_url(); ?>img/edit.png" border="0" /></a></th>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>