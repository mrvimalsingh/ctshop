<fieldset>
	<legend>Modifica client</legend>
	<form method="post" action="<?=site_url("admin/clients/save_client/".$client["id"])?>">
		<table class="mytable" style="width:100%">
			<tbody>
				<tr>
					<td width="200px;"><label for="order_client_type">Tip Client:</label></td>
					<td>
						<select id="client_type" name="client_type" onchange="selectClientType()">
							<option value="person" <? if ($client["type"] == 'person') echo "selected='selected'" ?>>Persoana fizica</option>
							<option value="company" <? if ($client["type"] == 'company') echo "selected='selected'" ?>>Companie</option>
						</select>
					</td>
				</tr>
				<tr id="company_name_row">
					<td><label for="company_name">Denumire Companie: </label></td>
					<td><input type="text" name="company_name" id="company_name" value="<?=form_prep($client["company_name"])?>" style="width:100%" /></td>
				</tr>
				<tr id="fiscal_code_row">
					<td><label for="fiscal_code">Cod Fiscal: </label></td>
					<td><input type="text" name="fiscal_code" id="fiscal_code" value="<?=form_prep($client["fiscal_code"])?>" style="width:100%" /></td>
				</tr>
				<tr id="nr_ord_reg_com_row">
					<td><label for="nr_ord_reg_com">Nr ord. reg. Com.: </label></td>
					<td><input type="text" name="nr_ord_reg_com" id="nr_ord_reg_com" value="<?=form_prep($client["nr_ord_reg_com"])?>" style="width:100%" /></td>
				</tr>
				<tr id="person_name_row">
					<td><label for="person_name">Nume, Prenume: </label></td>
					<td><input type="text" name="person_name" id="person_name" value="<?=form_prep($client["person_name"])?>"  style="width:100%"/></td>
				</tr>
				<tr id="cnp_row">
					<td><label for="cnp">CNP: </label></td>
					<td><input type="text" name="cnp" id="cnp" value="<?=form_prep($client["cnp"])?>" style="width:100%" /></td>
				</tr>
				<tr>
					<td><label for="phone">Telefon: </label></td>
					<td><input type="text" name="phone" id="phone" value="<?=form_prep($client["phone"])?>" style="width:100%" /></td>
				</tr>
				<tr>
					<td><label for="address">Adresa: </label></td>
					<td><input type="text" name="address" id="address" value="<?=form_prep($client["address"])?>" style="width:100%" /></td>
				</tr>
				<tr>
					<td><label for="town">Localitate: </label></td>
					<td><input type="text" name="town" id="town" value="<?=form_prep($client["town"])?>" style="width:100%" /></td>
				</tr>
				<tr>
					<td><label for="zip">Cod Postal: </label></td>
					<td><input type="text" name="zip" id="zip" value="<?=form_prep($client["zip"])?>" style="width:100%" /></td>
				</tr>
				<tr>
					<td><label for="county">Judet: </label></td>
					<td>
						<select name="county" id="county">
							<option value="0"> - alege judet - </option>
							<?php foreach ($counties as $k => $county): ?>
								<option value="<?=$county["id"]?>" <? if ($client["county"] == $county["id"]) echo "selected='selected'" ?>><?=$county["name"]?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="new_email">Email: </label></td>
					<td><input type="text" name="new_email" id="new_email" value="<?=form_prep($client["email"])?>" style="width:100%" /></td>
				</tr>
				<tr>
					<td><label for="new_password">Parola: </label></td>
					<td><input type="password" name="new_password" id="new_password" value="<?=form_prep($client["password"])?>" style="width:100%" /></td>
				</tr>
			</tbody>
		</table>
		<input type="submit" value="Modifica date" />
	</form>		
</fieldset>

<script>
function selectClientType() {
	if ($('#client_type').val() == "person") {
		$('#company_name_row').hide();
		$('#fiscal_code_row').hide();
		$('#nr_ord_reg_com_row').hide();
		$('#person_name_row').show();
		$('#cnp_row').show();
	} else {
		$('#company_name_row').show();
		$('#fiscal_code_row').show();
		$('#nr_ord_reg_com_row').show();
		$('#person_name_row').hide();
		$('#cnp_row').hide();
	}
}

selectClientType();
</script>