<fieldset>
	<legend>Setari limbi</legend>
	<table class="mytable">
		<thead>
			<tr>
				<th>Cod</th>
				<th>Denumire</th>
				<th>implicit</th>
				<th>administrare</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($languages as $k => $lang): ?>
			<tr <?php if ($k % 2 == 0) echo "class='odd'"; ?>>
				<td><?=$lang["code"]?></td>
				<td><?=$lang["name"]?></td>
				<td>
					<? if ($lang["default"] == "y"): ?>
						<img src="<?=base_url()?>img/action_check.png" />
					<? else: ?>
						<a href="<?=site_url("admin/languages/make_default/".$lang["id"])?>">fa-l default</a>
					<? endif; ?>
				</td>
				<td><?=$lang["admin_default"]?></td>
				<td><a href="<?=site_url("admin/languages/delete_lang")?>/<?=$lang["id"]?>" onclick="if (!confirm('Esti sigur ca vrei sa stergi?')) return false;"><img src="<?php echo base_url(); ?>img/action_delete.png" border="0" /></a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<form method="post" action="<?=site_url("admin/languages/add_lang")?>">
		<table class="mytable">
			<thead>
				<th colspan="2">Adauga</th>
			</thead>
			<tbody>
				<tr>
					<td><label for="add_code">Cod: </label></td>
					<td><input type="text" name="add_code" id="add_code" /></td>
				</tr>
				<tr class="odd">
					<td><label for="add_name">Denumire: </label></td>
					<td><input type="text" name="add_name" id="add_name" /></td>
				</tr>
				<tr>
					<td><label for="add_default">Implicit: </label></td>
					<td><input type="checkbox" name="add_default" id="add_default" /></td>
				</tr>
				<tr class="odd">
					<td><label for="add_admin_default">Administrare: </label></td>
					<td><input type="checkbox" name="add_admin_default" id="add_admin_default" /></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right"><input type="submit" value="salveaza" /></td>
				</tr>
			</tbody>
		</table>
	</form>
</fieldset>