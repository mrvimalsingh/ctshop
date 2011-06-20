<? if ($reviews): ?>
<table class="mytable" width="100%">
	<thead>
		<th>Data</th>
		<th>Produs</th>
		<th>Client</th>
		<th>Rating</th>
		<th>Descriere</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
	</thead>
	<tbody>
		<? foreach ($reviews as $review): ?>
			<tr>
				<td><?=$review["date_added"]?></td>
				<td><?=$review["product_name"]?></td>
				<td><?=$review["client_name"]?></td>
				<td><?=$review["rating"]?></td>
				<td><?=$review["description"]?></td>
				<td>
					<a href="<?=site_url("admin/productReviews/approve")?>/<?=$review["id"]?>">
						<img src="<?=base_url()?>img/action_check.png" />
					</a>
				</td>
				<td>
					<a href="<?=site_url("admin/productReviews/delete")?>/<?=$review["id"]?>">
						<img src="<?=base_url()?>img/action_delete.png" />
					</a>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
<? else: ?>
<strong style="color:darkgrey">Nu sunt review-uri neaprobate!...</strong>
<? endif; ?>