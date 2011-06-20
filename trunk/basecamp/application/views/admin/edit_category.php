<script type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script>
<fieldset width="100%">
	<legend>Adauga/Modifica Categorie</legend>
	<form method="post" action="<? echo site_url("admin/categories/save_category") ?>" enctype="multipart/form-data">
		<input type="hidden" id="add_category_id" name="add_category_id" value="<?=$selected_category["id"]?>" />
		<table>
			<tr>
				<td colspan="2">
					<!-- IMAGINE -->
					<img src="<?php echo site_url("images/get_category_image")?>/<?=$selected_category["id"]?>" style="padding:5px;border:#aaa dotted 1px;margin:5px;" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="file">Imagine:</label>
				</td>
				<td>
					<input type="file" name="file" id="file" /> 
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div id="categoryLanguageTabs">
						<ul>
							<? foreach ($languages_array as $lang): ?>
							<li><a href="#lang_tab_<?=$lang["code"]?>"><?=$lang["name"]?></a></li>
							<?php endforeach; ?>
						</ul>
						<? foreach ($languages_array as $lang): ?>
							<div id="lang_tab_<?=$lang["code"]?>">
								<table>
									<tr>
										<td><label>Denumire: </label></td>
										<td>
											<input type="text" id="add_category_name[<?=$lang["id"]?>]" name="add_category_name[<?=$lang["id"]?>]" value="<?=$selected_category[$lang["code"]]["name"]?>" />
										</td>
									</tr>
									<tr>
										<td><label>Cuvinte cheie: </label></td>
										<td>
											<input type="text" id="add_category_keywords[<?=$lang["id"]?>]" name="add_category_keywords[<?=$lang["id"]?>]" value="<?=$selected_category[$lang["code"]]["keywords"]?>" />
										</td>
									</tr>
									<tr>
										<td><label>Descriere scurta: </label></td>
										<td>
											<input type="text" id="add_category_short_desc[<?=$lang["id"]?>]" name="add_category_short_desc[<?=$lang["id"]?>]" value="<?=$selected_category[$lang["code"]]["short_desc"]?>" />
										</td>
									</tr>
									<tr>
										<td valign="top"><label>Descriere: </label></td>
										<td>
											<textarea id="add_category_description[<?=$lang["id"]?>]" name="add_category_description[<?=$lang["id"]?>]"><?=$selected_category[$lang["code"]]["description"]?></textarea>
										</td>
									</tr>
								</table>
							</div>
						<?php endforeach; ?>
					</div>
				</td>
			</tr>
			<tr>
				<td><label for="add_category_parent">Categorie parinte</label></td>
				<td>
					<select id="add_category_parent" name="add_category_parent">
						<option value="0"> - categorie principala - </option>
						<?php foreach($categories as $k => $category):?>
							<?php if ($selected_category["id"] != $category["id"]): ?>
							<option value="<?=$category["id"]?>"<?php if ($selected_category["parent_id"] == $category["id"]) echo " selected='selected'"; ?>><?=$category["name"]?></option>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="Salveaza" />
					<input type="button" value="sterge" onclick="document.location.href = '<?=site_url("admin/categories/delete_category")?>/<?=$selected_category["id"]?>';" />
				</td>
			</tr>
		</table>
	</form>	
</fieldset>
<? if ($selected_category["id"] > 0): ?>
	<fieldset>
		<legend>Prioprietati</legend>
		<table class="mytable" width="100%">
			<thead>
				<tr>
					<th>Tip</th>
					<th>UM</th>
					<th>Denumire</th>
					<th>Descriere</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<? foreach($properties as $k2 => $prop):?>
					<tr>
						<td><?=lang("admin_product_properties_type_".$prop["type"])?></td>
						<td><?=$prop["um"]?></td>
						<td><?=$prop["name"]?></td>
						<td><?=$prop["description"]?></td>
						<td>
							<a href="<?=site_url("admin/categories/del_re_property/".$prop["id"])?>/<?=$selected_category["id"]?>" onclick="if (!confirm('Esti sigur ca vrei sa stergi?!...')) return false;">
								<img src="<?=base_url()?>img/action_delete.png" border="0" />
							</a>
						</td>
					</tr>
				<? endforeach; ?>
			</tbody>
		</table>
		<form method="post" action="<?=site_url("admin/categories/add_re_property")?>">
			<input type="hidden" name="category_id" value="<?=$selected_category["id"]?>" />
			<table>
				<tr>
					<td><label for="property_id">Adauga prioprietate</label></td>
					<td>
						<select name="property_id" id="property_id">
							<? foreach($all_properties as $k2 => $prop):?>
								<option value="<?=$prop["id"]?>"><?=$prop["name"]?></option>
							<? endforeach; ?>
						</select>
					</td>
					<td>
						<input type="submit" value="adauga" />
					</td>
				</tr>
			</table>
		</form>
	</fieldset>
<? endif; ?>
<div id="edit_category_dialog" title="Adauga/Modifica categorie">
	<form id="edit_category_form" name="edit_category_form" method="post" action="<?php echo site_url("admin/categories/add"); ?>">
		<input type="hidden" name="add_category_id" id="add_category_id" />
		<table>
			<tr>
				<td><label for="add_category_name">Denumire</label></td>
				<td><input type="text" id="add_category_name" name="add_category_name" /></td>
			</tr>
			<tr>
				<td><label for="add_category_parent">Categorie parinte</label></td>
				<td>
					<select id="add_category_parent" name="add_category_parent">
						<option value="0"> - categorie principala - </option>
						<?php foreach($categories as $k => $category):?>
							<option value="<?=$category["id"]?>"<?php if ($selected_category["id"] == $category["id"]) echo " selected='selected'"; ?>><?=$category["name"]?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="add_category_keywords">Cuvinte cheie</label></td>
				<td><input type="text" id="add_category_keywords" name="add_category_keywords" /></td>
			</tr>
		</table>
	</form>
</div>

<script>

	$('#categoryLanguageTabs').tabs();

	$('#edit_category_dialog').dialog({
		autoOpen: false,
		modal:true,
		width: 300,
		buttons: {
			"Salveaza": function() { 
				document.edit_category_form.submit();
//				$(this).dialog("close"); 
			}
		}
	});

	function editCategory(id) {
		$('#edit_category_dialog').dialog('open');
	}

	<? foreach ($languages_array as $lang): ?>
		CKEDITOR.replace( 'add_category_description[<?=$lang["id"]?>]' );
	<?php endforeach; ?>
	
</script>