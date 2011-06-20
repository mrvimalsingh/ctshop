<html>
<head>
	<title>CT-Shop Installation</title>
	<link href="css/table.css" type="text/css" rel="stylesheet">
</head>
<body>
	<div align="center" style="top:70px;">
		<form method="post" action="install/do_install">
			<table class="mytable" width="500px;">
				<thead>
					<tr>
						<th colspan="2"><h2>CT-Shop Installation</h2></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th colspan="2" align="left"><strong>Db Connection</strong></th>
					</tr>
					<tr class="odd">
						<td align="right"><label for="db_name">Database Name: </label></td>
						<td><input type="text" name="db_name" id="db_name" style="width:100%;" /></td>
					</tr>
					<tr>
						<td align="right"><label for="db_host">Host: </label></td>
						<td><input type="text" name="db_host" id="db_host" style="width:100%;" value="localhost" /></td>
					</tr>
					<tr class="odd">
						<td align="right"><label for="db_user">Database User: </label></td>
						<td><input type="text" name="db_user" id="db_user" style="width:100%;" /></td>
					</tr>
					<tr>
						<td align="right"><label for="db_pass">Database Password: </label></td>
						<td><input type="password" name="db_pass" id="db_pass" style="width:100%;" /></td>
					</tr>
					<tr>
						<th colspan="2" align="left"><strong>Site configuration</strong></th>
					</tr>
					<tr>
						<td align="right"><label for="lang">Default language: </label></td>
						<td>
							<select id="lang" name="lang">
								<option value="ro" selected="selected">Romana</option>
								<option value="en">English</option>
							</select>
						</td>
					</tr>
					<tr class="odd">
						<td align="right"><label for="currency">Currency: </label></td>
						<td><input type="text" name="currency" id="currency" style="width:100%;" value="RON" /></td>
					</tr>
					<tr>
						<th colspan="2" align="left"><strong>Administrator account</strong></th>
					</tr>
					<tr>
						<td align="right"><label for="admin_user">User name: </label></td>
						<td><input type="text" name="admin_user" id="admin_user" style="width:100%;" value="admin" /></td>
					</tr>
					<tr class="odd">
						<td align="right"><label for="admin_pass">Password: </label></td>
						<td><input type="password" name="admin_pass" id="admin_pass" style="width:100%;" value="admin" /></td>
					</tr>
					<tr>
						<td colspan="2" align="right" style="text-align:right;">
							<input type="submit" value="Install" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</body>
</html>