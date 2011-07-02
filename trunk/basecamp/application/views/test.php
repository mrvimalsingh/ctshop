<html>
<head>
    <title>TEST Page for all sorts of stuff</title>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.4.2.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jsonrpc.js"></script>
    <script>
        baseUri = '<?=base_url();?>';
        function chekUserLoggedIn() {
            makeJsonRpcCall('', 'check_user_logged_in', null, function (data) {
                if (data.error != null) {
                    alert(data.error.message);
                } else {
                    alert("user_id: "+data.result.user_id);
                }
            });
        }
    </script>
</head>
<body>

    <div id="ajaxResult"></div>

    <input type="button" value="Test" onclick="chekUserLoggedIn()" />

</body>
</html>