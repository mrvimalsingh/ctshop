<form action="<?php echo site_url("admin/$type/upload_image"); ?>/<?=$type_id?>" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<td><label for="file">Fisier:</label></td>
			<td><input type="file" name="file" id="file" /> </td>
		</tr>
		<? foreach ($languages_array as $lang): ?>
			<tr>
				<td><label for="name">Denumire (<?=$lang["name"]?>):</label></td>
				<td><input type="text" name="name[<?=$lang["id"]?>]" id="name[<?=$lang["id"]?>]" /></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<input type="submit" name="submit" value="Incarca" />
</form>
<?php if ($type == "products"): ?>
<script>
	parent.loadProductImages();
</script>
<?php endif; ?>