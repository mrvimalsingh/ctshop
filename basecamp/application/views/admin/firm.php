<fieldset>
	<legend>Detalii firma</legend>
	<form method="post" action="<?=site_url("admin/firm/save")?>">
		<table class="mytable" style="width:100%" border="0">
			<tbody>
				<tr>
					<td width="200px">Denumire firma</td>
					<td><input type="text" name="company_name" id="company_name" value="<?=$company_name?>" style="width:100%" /></td>
				</tr>
				<tr>
					<td>Cod fiscal</td>
					<td><input type="text" name="company_fiscal_code" id="company_fiscal_code" value="<?=$company_fiscal_code?>" style="width:100%" /></td>
				</tr>
				<tr>
					<td>Nr. Reg. Com.</td>
					<td><input type="text" name="company_register_nr" id="company_register_nr" value="<?=$company_register_nr?>" style="width:100%" /></td>
				</tr>
				<tr>
					<td>E-mail formular de contact</td>
					<td><input type="text" name="contact_email" id="contact_email" value="<?=$contact_email?>" style="width:100%" /></td>
				</tr>
			</tbody>
		</table>
		<input type="submit" value="Salveaza" />
	</form>
</fieldset>