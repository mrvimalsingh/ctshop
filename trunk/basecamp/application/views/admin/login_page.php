<HTML><HEAD><META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <LINK href="<?php echo base_url(); ?>css/admin.css" type="text/css" rel="stylesheet">
    <TITLE>Administrare Shop - Login</TITLE>

    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.4.2.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jsonrpc.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/sha256.js"></script>
    <SCRIPT type="text/javascript">

        $(document).ready(function () {
            baseUri = '<?=base_url();?>';
            $('[type="text"]:first').focus();

            $('[type="text"],[type="password"]').bind("keydown", function(e) {
                var n = $('[type="text"],[type="password"]').length;
                if (e.which == 13)
                { //Enter key
                    e.preventDefault(); //Skip default behavior of the enter key
                    var nextIndex = $('[type="text"],[type="password"]').index(this) + 1;
                    if(nextIndex < n)
                        $('[type="text"],[type="password"]')[nextIndex].focus();
                    else
                    {
                        $('[type="text"],[type="password"]')[nextIndex-1].blur();
                        $('#btnSubmit').click();
                    }
                }
            });
        });

    </SCRIPT>
</HEAD>
<BODY style="background: none;">
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
        <TD><input type="text" name="admin_user" id="admin_user"></TD>
    </TR>
    <TR>
        <TD class="loginLabel">
            Parola:
        </TD>
        <TD><input type="password" name="admin_parola" id="admin_parola"></TD>
    </TR>
    <TR>
        <TD colspan="2" align="right">
            <input type="button" id="btnSubmit" value="Autentificare" class="buton" onclick="login()">
        </TD>
    </TR>
    <TR>
        <TD colspan="2">
        </TD>
    </TR>
    </TBODY></TABLE>
</BODY></HTML>

<script>
    function login() {
        // create a salt
        var pwHash = sha256_digest($('#admin_parola').val());
        var salt = Math.random();
        salt = salt * 1000000;
        salt = Math.ceil(salt);
        var saltHash = sha256_digest(''+salt);
        var hash = sha256_digest(pwHash+saltHash);
        makeJsonRpcCall(
                'users',
                'authenticate',
                {
                    "userName": $('#admin_user').val(),
                    "password": hash,
                    "salt": ''+salt
                },
                function (data) {
                    if (data.error != null) {
                        alert('error: '+data.error.message);
                    } else {
                        if (data.result) {
                            window.location.href = '<?=base_url()?>admin/products';
                        } else {
                            alert('login failed');
                        }
                    }
                });
    }
</script>