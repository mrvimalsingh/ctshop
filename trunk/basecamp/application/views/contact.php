<h2>Formular Online</h2>
<? if ($success): ?>
<strong style="color:green">Mesajul dumneavoastra a fost trimis cu succes!...</strong>
<? endif; ?>
<? if ($captcha_error): ?>
<strong style="color:red">Introduceti mai atent codul de securitate!...</strong>
<? endif; ?>
<p>*Toate campurile sunt obligatorii</p>
<form action="<?=site_url("contact/send")?>" method="post" onsubmit="if (!validate()) return false;">
	<table align="center" cellpadding="5px">
		<tr>
			<td align="right">
				<label>
					Nume: 
				</label>
			</td>
			<td>
				<input type="text" id="nume" name="nume" size="32" value="" onFocus="this.select()" />
			</td>
		<tr>
		<tr>
			<td align="right">
				<label>
					E-mail: 
				</label>
			</td>
			<td>
				<input type="text" id="email" name="email" size="32" value="" onFocus="this.select()" />
			</td>
		<tr>
		<tr>
			<td align="right">
				<label>
					Titlu: 
				</label>
			</td>
			<td>
				<input type="text" id="titlu" name="titlu" size="32" value="" onFocus="this.select()" />
			</td>
		<tr>
		<tr>
			<td valign="top" align="right">
				<label>
					Mesaj: 
				</label>
			</td>
			<td>
				<textarea id="mesaj" name="mesaj" rows="10" cols="25" onFocus="this.select()"></textarea>
			</td>
		</tr>
		<tr>
			<td valign="top" align="right">
				<label>
					Cod securitate:<br />
					<img src="<?=site_url("contact/captcha")?>" />
				</label>
			</td>
			<td>
				<input type="text" id="security_code" name="security_code" />
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
			<td>
				<input type="submit" value="Trimite" />
			</td>
		</tr>
	</table>
</form>
<script>
	function checkFieldSimple(fieldId, wrongValue, message) {
		if ($("#"+fieldId).val() == wrongValue) {
			alert(message);
			$("#"+fieldId).focus();
			return false;
		}
		return true; 
	}
	function validate() {
		if (!checkFieldSimple('nume', '', 'Trebuie sa completati numele!')) return false;
		if (!checkFieldSimple('email', '', 'Trebuie sa completati email-ul!')) return false;
		if (!checkFieldSimple('titlu', '', 'Trebuie sa-i dati mesajului un titlu!')) return false;
		if (!checkFieldSimple('mesaj', '', 'Mesajul nu poate fi gol')) return false;
		if (!checkFieldSimple('security_code', '', 'Codul de securitate va deosebeste de roboti care scriu mesaje rautacioase, va rugam sa-l completati!')) return false;
		return true;
	}
</script>