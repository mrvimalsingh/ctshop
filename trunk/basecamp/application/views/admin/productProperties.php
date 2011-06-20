<script type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script>
<fieldset>
	<legend>Administrare prioprietati produse</legend>
	<table class="mytable" width="100%">
		<tbody>
			<? foreach($property_categories as $k => $cat):?>
				<tr>
					<th colspan="3">
						<strong><?=$cat["name"]?></strong>
					</th>
					<th>
						<a href="javascript:void(0);" onclick="add_property(<?=$cat["id"]?>,0)">Adauga prioprietate</a>						
					</th>
					<th width="40px">
						<a href="<?=site_url("admin/productProperties/move/property_category/up/".$cat["id"])?>">
							<img src="<?=base_url()?>img/arrow_top.png" border="0" />
						</a>
						<a href="<?=site_url("admin/productProperties/move/property_category/down/".$cat["id"])?>">
							<img src="<?=base_url()?>img/arrow_down.png" border="0" />
						</a>
					</th>
					<th width="20px">
						<a href="javascript:void(0);" onclick="add_property_category(<?=$cat["id"]?>)">
							<img src="<?=base_url()?>img/edit.png" border="0" />
						</a>
					</th>
					<th width="20px">
						<a href="<?=site_url("admin/productProperties/delete/property_category/".$cat["id"])?>" onclick="if (!confirm('Esti sigur ca vrei sa stergi?!...')) return false;">
							<img src="<?=base_url()?>img/action_delete.png" border="0" />
						</a>
					</th>
				</tr>
				<? foreach($cat["properties"] as $k2 => $prop):?>
					<tr>
						<td><?=lang("admin_product_properties_type_".$prop["type"])?></td>
						<td><?=$prop["um"]?></td>
						<td><?=$prop["name"]?></td>
						<td><?=$prop["description"]?></td>
						<td>
							<a href="<?=site_url("admin/productProperties/move/property/up/".$prop["id"])?>">
								<img src="<?=base_url()?>img/arrow_top.png" border="0" />
							</a>
							<a href="<?=site_url("admin/productProperties/move/property/down/".$prop["id"])?>">
								<img src="<?=base_url()?>img/arrow_down.png" border="0" />
							</a>
						</td>
						<td width="20px">
							<a href="javascript:void(0);" onclick="add_property(<?=$cat["id"]?>, <?=$prop["id"]?>)"><img src="<?=base_url()?>img/edit.png" border="0" /></a>
						</td>
						<td>
							<a href="<?=site_url("admin/productProperties/delete/property/".$prop["id"])?>" onclick="if (!confirm('Esti sigur ca vrei sa stergi?!...')) return false;">
								<img src="<?=base_url()?>img/action_delete.png" border="0" />
							</a>
						</td>
					</tr>
				<? endforeach; ?>
			<? endforeach; ?>
		</tbody>
	</table>
	<a href="javascript:void" onclick="add_property_category(0)">Adauga categorie de prioprietati</a>
</fieldset>
<div id="add_property_category_div" title="Adauga/modifica categorie de prioprietati">
	<form method="post" id="add_property_category_form" name="add_property_category_form" action="<?=site_url("admin/productProperties/add_property_category")?>">
		<input type="hidden" name="property_category_id" id="property_category_id" value="0" />
		<table>
			<? foreach ($languages_array as $lang): ?>
			<tr>
				<td><label for="property_category_name[<?=$lang["id"]?>]">Denumire (<?=$lang["name"]?>)</label></td>
				<td><input type="text" name="property_category_name[<?=$lang["id"]?>]" id="property_category_name[<?=$lang["id"]?>]" /></td>
			</tr>
			<? endforeach; ?>
		</table>
	</form>
</div>
<div id="add_property_div" title="Adauga/Modifica prioprietate">
	<form method="post" id="add_property_form" name="add_property_form" action="<?=site_url("admin/productProperties/add_property")?>">
		<input type="hidden" name="property_id" id="property_id" value="0" />
		<input type="hidden" name="property_category_id2" id="property_category_id2" value="0" />
		<table>
			<tr>
				<td><label for="property_type">Tip</label></td>
				<td>
					<select name="property_type" id="property_type">
						<option value="numeric"><?=lang("admin_product_properties_type_numeric")?></option>
						<option value="fixed"><?=lang("admin_product_properties_type_fixed")?></option>
						<option value="yes_no"><?=lang("admin_product_properties_type_yes_no")?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="property_um">Unitate de masura</label></td>
				<td><input type="text" name="property_um" id="property_um" /></td>
			</tr>
			<tr>
				<td colspan="2">
					<div id="propertyLanguageTabs">
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
											<input type="text" id="property_name[<?=$lang["id"]?>]" name="property_name[<?=$lang["id"]?>]"  />
										</td>
									</tr>
									<tr>
										<td valign="top"><label>Descriere: </label></td>
										<td>
											<textarea type="text" id="property_desc[<?=$lang["id"]?>]" name="property_desc[<?=$lang["id"]?>]" cols="30" rows="10"></textarea>
										</td>
									</tr>
								</table>
							</div>
						<?php endforeach; ?>
					</div>
				</td>
			</tr>
		</table>
	</form>
</div>
<script>

	$('#propertyLanguageTabs').tabs();

	$('#add_property_category_div').dialog({
		autoOpen: false,
		modal:true,
		width: 300,
		buttons: {
			"Salveaza": function() { 
				document.add_property_category_form.submit();
			}
		}
	});

	$('#add_property_div').dialog({
		autoOpen: false,
		modal:true,
		width: 400,
		buttons: {
			"Salveaza": function() { 
				document.add_property_form.submit();
			}
		}
	});

	function add_property_category(cat_id) {
		$('#property_category_id').val(cat_id);
		if (cat_id > 0) {
			// scoatem datele cu json
			$.getJSON(
					'<?php echo site_url("admin/productProperties/property_category_JSON"); ?>/'+cat_id,
					function(data) {
						$.each(data.lang, function (index, item) {
							$('#property_category_name\\['+item.lang_id+'\\]').val(item.name);
						});
						$('#add_property_category_div').dialog('open');
					}
				);
		} else {
			$('#add_property_category_div').dialog('open');
		}
	}

	function add_property(cat_id, prop_id) {
		$('#property_category_id2').val(cat_id);
		$('#property_id').val(prop_id);
		if (prop_id > 0) {
			// scoatem datele cu json
			$.getJSON(
					'<?php echo site_url("admin/productProperties/property_JSON"); ?>/'+prop_id,
					function(data) {
						$('#property_type').val(data.type);
						$('#property_um').val(data.um);
						$.each(data.lang, function (index, item) {
							$('#property_name\\['+item.lang_id+'\\]').val(item.name);
							$('#property_desc\\['+item.lang_id+'\\]').val(item.description);
						});
						$('#add_property_div').dialog('open');
					}
				);
		} else {
			$('#add_property_div').dialog('open');
		}
	}

</script>