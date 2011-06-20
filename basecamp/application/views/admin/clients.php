<fieldset>
	<legend>Clienti</legend>
	<div id="client_table"></div>
	
</fieldset>
<script>

function loadClients(page) {
	if (page == "") {
		page = 1;
	}
	$('#client_table').html("<img src='<?=base_url()?>img/ajax-loader.gif' />");
	$('#client_table').load(
		'<?php echo site_url("admin/clients/client_table"); ?>/'+page
	);
}

loadClients(0);

</script>