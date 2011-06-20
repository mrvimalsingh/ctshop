<fieldset>
	<legend>Setari plata &amp; transport</legend>
	<table>
		<tr>
			<td valign="top">
				<table class="mytable">
					<thead>
						<tr>
							<th>Modalitate plata</th>
							<th>Pret</th>
							<th>Limba</th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($payment_types as $pt): ?>
							<tr>
								<td><?=$pt["name"]?></td>
								<td><?=$pt["price"]?></td>
								<td><?=$pt["lang_name"]?></td>
								<td><a href="javascript:void(0);" onclick="edit('pt', '<?=$pt["id"]?>', '<?=$pt["name"]?>', '<?=$pt["price"]?>', '<?=$pt["language_id"]?>')"><img src="<?php echo base_url(); ?>img/edit.png" border="0" /></a></td>
								<td><a href="<?=site_url("admin/ptSettings/delete/payment_type")?>/<?=$pt["id"]?>" onclick="if (!confirm('Esti sigur ca vrei sa stergi?')) return false;"><img src="<?php echo base_url(); ?>img/action_delete.png" border="0" /></a></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</td>
			<td valign="top">
				<table class="mytable">
					<thead>
						<tr>
							<th>Modalitate transport</th>
							<th>Pret</th>
							<th>Limba</th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($transport_types as $tt): ?>
							<tr>
								<td><?=$tt["name"]?></td>
								<td><?=$tt["price"]?></td>
								<td><?=$tt["lang_name"]?></td>
								<td><a href="javascript:void(0);" onclick="edit('tt', '<?=$tt["id"]?>', '<?=$tt["name"]?>', '<?=$tt["price"]?>', '<?=$tt["language_id"]?>')"><img src="<?php echo base_url(); ?>img/edit.png" border="0" /></a></td>
								<td><a href="<?=site_url("admin/ptSettings/delete/transport_type")?>/<?=$tt["id"]?>" onclick="if (!confirm('Esti sigur ca vrei sa stergi?')) return false;"><img src="<?php echo base_url(); ?>img/action_delete.png" border="0" /></a></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" value="Adauga mod. plata" onclick="edit('pt', 0, '', '', 0);" />
			</td>
			<td>
				<input type="button" value="Adauga mod. transport" onclick="edit('tt', 0, '', '', 0);" />
			</td>
		</tr>
	</table>
</fieldset>

<div id="edit_pt_panel" title="Adauga/Modifica modalitate plata">
	<form id="edit_pt_form" name="edit_pt_form" method="post" action="<?=site_url("admin/ptSettings/save/pt")?>">
		<input type="hidden" name="edit_pt_id" id="edit_pt_id" value="0" />
		<table>
			<tr>
				<td>Denumire</td>
				<td><input type="text" id="edit_pt_name" name="edit_pt_name" /></td>
			</tr>
			<tr>
				<td>Pret</td>
				<td><input type="text" id="edit_pt_price" name="edit_pt_price" /></td>
			</tr>
			<tr>
				<td>Limba</td>
				<td>
					<select id="edit_pt_lang" name="edit_pt_lang">
						<? foreach ($languages_array as $lang): ?>
							<option value="<?=$lang["id"]?>"><?=$lang["name"]?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
		</table>
	</form>
</div>

<div id="edit_tt_panel" title="Adauga/Modifica modalitate transport">
	<form id="edit_tt_form" name="edit_tt_form" method="post" action="<?=site_url("admin/ptSettings/save/tt")?>">
		<input type="hidden" name="edit_tt_id" id="edit_tt_id" value="0" />
		<table>
			<tr>
				<td>Denumire</td>
				<td><input type="text" id="edit_tt_name" name="edit_tt_name" /></td>
			</tr>
			<tr>
				<td>Pret</td>
				<td><input type="text" id="edit_tt_price" name="edit_tt_price" /></td>
			</tr>
			<tr>
				<td>Limba</td>
				<td>
					<select id="edit_tt_lang" name="edit_tt_lang">
						<? foreach ($languages_array as $lang): ?>
							<option value="<?=$lang["id"]?>"><?=$lang["name"]?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
		</table>
	</form>
</div>

<script>

	$('#edit_pt_panel').dialog({
		autoOpen: false,
		modal:true,
		width: 300,
		buttons: {
			"Salveaza": function() { 
				document.edit_pt_form.submit();
	//			$(this).dialog("close"); 
			}
		}
	});

	$('#edit_tt_panel').dialog({
		autoOpen: false,
		modal:true,
		width: 300,
		buttons: {
			"Salveaza": function() { 
				document.edit_tt_form.submit();
	//			$(this).dialog("close"); 
			}
		}
	});

	function edit(type, id, name, price, lang) {
		$('#edit_'+type+'_id').val(id);
		$('#edit_'+type+'_name').val(name);
		$('#edit_'+type+'_price').val(price);
		$('#edit_'+type+'_lang').val(lang);
		$('#edit_'+type+'_panel').dialog('open');
	}

</script>