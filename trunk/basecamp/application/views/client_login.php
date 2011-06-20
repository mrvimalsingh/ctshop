<style>
.half_page_panel {
	width:400px;
	float:left;
	margin-left:20px;
}
.login_label {
	color: #666;
	display: block;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	height: 18px;
	line-height: 18px;
	text-align: left;
}
.login_input {
	border: #B6B6B6 solid 1px;
	color: #2F2F2F;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	height: 15px;
	line-height: 15px;
}
</style>

<script>
	var valiation_messages = {
		'register_name': 'Trebuie sa introduceti un nume!',
		'register_email': 'Pentru a putea intra in contul dumneavoastra trebuie sa aveti un email!',
		'register_password': 'Va rugam introduceti o parola pe care o puteti retine!',
		'register_password_repeat': 'Repetarea parolei este necesara pentru a evita greselile de introducere!',
		'passwords_dont_match': 'Parolele nu corespund va rugam sa le mai introduceti!'
	};
	function validate() {

		if (!validate_field('register_name', "")) return false;
		if (!validate_field('register_email', "")) return false;
		if (!validate_field('register_password', "")) return false;
		if (!validate_field('register_password_repeat', "")) return false;

		if ($('#register_password').val() != $('#register_password_repeat').val()) {
			alert(valiation_messages['passwords_dont_match']);
			$('#register_password').val("");
			$('#register_password_repeat').val("");
			$('#register_password').focus();
			return false;
		}
		
		return true;
	}

	/* TODO de bagat in ceva librarie treaba asta... */
	function validate_field(field_id, wrong_value) {
		if ($('#'+field_id).val() == wrong_value) {
			$('#'+field_id).focus();
			alert(valiation_messages[field_id]);
			return false;
		}
		return true;
	}
</script>

<form method="post" action="<?=site_url("client/register")?>" onsubmit="if (!validate()) return false;">
	<div class="shop_panel half_page_panel">
		<div class="panel_header">Inscrie-te acum!</div>
		<div class="panel_body">
			Inscrie-te pentru a beneficia de toate avantajele oferite pentru clientii site-ului nostru!...
				<label for="register_name" class="login_label">Nume: </label>
				<input type="text" name="register_name" id="register_name" class="login_input" /><br />
				<label for="register_email" class="login_label">E-mail: </label>
				<input type="text" name="register_email" id="register_email" class="login_input" /><br />
				<label for="register_password" class="login_label">Parola: </label>
				<input type="password" name="register_password" id="register_password" class="login_input" /><br />
				<label for="register_password_repeat" class="login_label">Repeta Parola: </label>
				<input type="password" name="register_password_repeat" id="register_password_repeat" class="login_input" /><br />
		</div>
		<div class="panel_footer">
			<input type="submit" value="Inscrie-te" />
		</div>
	</div>
</form>
<form method="post" action="<?=site_url("client/login")?>">
	<div class="shop_panel half_page_panel">
		<div class="panel_header">Login</div>
		<div class="panel_body">
				<label for="email" class="login_label">E-mail: </label>
				<input type="text" name="email" id="email" class="login_input" /><br />
				<label for="password" class="login_label">Parola: </label>
				<input type="password" name="password" id="password" class="login_input" /><br />
		</div>
		<div class="panel_footer">
			<input type="submit" value="Login" />
		</div>
	</div>
</form>
