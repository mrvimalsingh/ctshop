<HTML><HEAD><META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<LINK href="<?php echo base_url(); ?>css/admin.css" type="text/css" rel="stylesheet">
	<TITLE>Administrare Shop - Login</TITLE>
	<SCRIPT type="text/javascript">
		
			function focus_id(id){
				$(id).focus();
			}
		
	</SCRIPT>
</HEAD>
<BODY onload="focus_id('admin_user');" style="background: none;">
	<FORM method="post" action="<?php echo site_url("admin/user/login"); ?>">
		<DIV align="center" style="margin-bottom: 5px; font-weight: bold;">
			[ Va rugam sa va autentificati ]
		</DIV>
		<TABLE cellpadding="2" cellspacing="4" align="center" border="0" style="border: 4px #00abbd solid;">
			<TBODY><TR>
				<TD align="center" colspan="2" style="background-color: #575757;">
					<TABLE cellpadding="0" cellspacing="0">
						<TBODY><TR>
							<TH align="center">
								<IMG src="<?php echo base_url(); ?>img/logo-small.png">
							</TH>
							<TH align="center" class="loginTitle">
								Login
							</TH>
						</TR>
					</TBODY></TABLE>
				</TD>
			</TR>
			<TR>
				<TD class="loginLabel">
					Utilizator:
				</TD>
				<TD><INPUT type="text" name="admin_user" id="admin_user"></TD>
			</TR>
			<TR>
				<TD class="loginLabel">
					Parola:
				</TD>
				<TD><INPUT type="password" name="admin_parola" id="admin_parola"></TD>
			</TR>
			<TR>
				<TD colspan="2" align="right">
					<INPUT type="submit" value="Autentificare" class="buton">
				</TD>
			</TR>
			<TR>
				<TD colspan="2">
					
				</TD>
			</TR>
		</TBODY></TABLE>
	</FORM>
</BODY></HTML>