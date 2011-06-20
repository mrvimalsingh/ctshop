<fieldset width="100%">
	<legend>Filtrari</legend>
	<table>
		<tr>
			<td>
				<label for="filter_category">Categorie: </label>
			</td>
			<td>
				<select id="filter_category" name="filter_category" onchange="loadProducts(1);">
					<option value="0"> - toate categoriile - </option>
					<?php foreach($categories as $k => $category):?>
						<option value="<?=$category["id"]?>"><?=$category["name"]?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<label for="filter_discount">In reducere</label>
			</td>
			<td>
				<input type="checkbox" name="filter_discount" id="filter_discount" onchange="loadProducts(1);" />
			</td>
			<td>
				<label for="filter_in_stock">In stoc</label>
			</td>
			<td>
				<input type="checkbox" name="filter_in_stock" id="filter_in_stock" onchange="loadProducts(1);" />
			</td>
			<td>
				<label for="search_product_code">Cod produs: </label>
			</td>
			<td>
				<input type="text" name="search_product_code" id="search_product_code" />
			</td>
		</tr>
	</table>
</fieldset>
<fieldset width="100%">
	<legend>Produse</legend>
	<div id="product_table"></div>
	<input type="button" value="Adauga Produs" onclick="$('#add_product_div').dialog('open')" />
</fieldset>

<div id="add_product_div" title="Adauga produs">
	<form method="post" name="add_product_form" id="add_product_form" action="<?php echo site_url("admin/products/add_product"); ?>">
		<table>
			<tr>
				<td><label for="add_product_code">Cod: </label></td>
				<td>
					<input type="text" name="add_product_code" id="add_product_code" onkeyup="check_code()" />
				</td>
				<td id="product_code_result"></td>
			</tr>
			<!-- 
			<tr>
				<td><label for="add_product_name">Nume: </label></td>
				<td colspan="2">
					<input type="text" name="add_product_name" id="add_product_name" />
				</td>
			</tr>
			 -->
		</table>
	</form>
</div>

<script>

	$('#add_product_div').dialog({
		autoOpen: false,
		modal:true,
		width: 300,
		buttons: {
			"Salveaza": function() { 
				document.add_product_form.submit();
			}
		}
	});

	function loadProducts(page) {
		if (page == "") {
			page = 1;
		}
		var in_reducere = $('#filter_discount').is(':checked')?'y':'n';
		var in_stock = $('#filter_in_stock').is(':checked')?'y':'n';
		$('#product_table').load(
			'<?php echo site_url("admin/products/product_table"); ?>/'+page+'/'+$('#filter_category').val()+'/'+in_reducere+'/'+in_stock
		);
	}

	function check_code() {
		$.getJSON(
				'<?php echo site_url("admin/products/check_code"); ?>/'+$('#add_product_code').val(),
				function(data) {
					if (data.rows > 0) {
						$('#product_code_result').html("<img src='<?php echo base_url(); ?>img/action_delete.png' />");
					} else {
						$('#product_code_result').html("<img src='<?php echo base_url(); ?>img/action_check.png' />");
					}
				}
			);
	}

	$("#search_product_code").autocomplete("<?php echo site_url("admin/products/search_product_code"); ?>", {
		width: 260,
		selectFirst: false,
		noQueryString: true
	}).result(function(event, item) {
		  document.location.href = '<?php echo site_url("admin/products/edit_product"); ?>/'+item[1];
	});
	
	loadProducts();
</script>