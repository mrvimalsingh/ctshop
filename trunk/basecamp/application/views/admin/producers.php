<script type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script>
<fieldset>
	<legend>Producatori</legend>
	<table class="mytable" width="100%">
		<thead>
			<tr>
				<th>Denumire</th>
				<th>Link</th>
				<th>Descriere</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<? foreach($producers as $k => $producer):?>
				<tr>
					<td><?=$producer["name"]?></td>
					<td><?=$producer["web"]?></td>
					<td><?=$producer["description"]?></td>
					<td>
						<a href="<?=site_url("admin/producers/delete")?>/<?=$producer["id"]?>" onclick="if (!confirm('Esti sigur ca vrei sa stergi?')) return false;">
							<img src="<?php echo base_url(); ?>img/action_delete.png" border="0" />
						</a>
					</td>
				</tr>
			<? endforeach; ?>
		</tbody>
	</table>
	<form method="post" action="<?=site_url("admin/producers/add_producer")?>">
		<table>
			<tr>
				<td><label for="producer_name">Denumire</label></td>
				<td><input type="text" name="producer_name" id="producer_name" /></td>
			</tr>
			<tr>
				<td><label for="producer_link">Link</label></td>
				<td><input type="text" name="producer_link" id="producer_link" /></td>
			</tr>
			<tr>
				<td valign="top"><label for="producer_desc">Descriere</label></td>
				<td>
					<textarea name="producer_desc" id="producer_desc"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Adauga" /></td>
			</tr>
		</table>
	</form>
</fieldset>
<script>
CKEDITOR.replace( 'producer_desc' );
</script>