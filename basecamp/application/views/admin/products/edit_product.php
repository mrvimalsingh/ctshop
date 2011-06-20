<script type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script> 
<fieldset style="width:100%">
	<legend>Adauga/Modifica Produs</legend>
	<form method="post" action="<? echo site_url("admin/products/save_product") ?>">
		<input type="hidden" id="product_id" name="product_id" value="<?=$product["id"]?>" />
		<div style="float:left;">
			<table>
				<tr>
					<td><label>Cod: </label></td>
					<td>
						<input type="text" id="product_code" name="product_code" value="<?=$product["code"]?>" />
					</td>
				</tr>
				<tr>
					<td><label>Pret: </label></td>
					<td>
						<input type="text" id="product_price" name="product_price" value="<?=$product["price"]?>" />
					</td>
				</tr>
				<tr>
					<td><label for="product_producer">Producator: </label></td>
					<td>
						<select name="product_producer" id="product_producer">
							<option value="0"> - alege producator - </option>
							<? foreach($producers as $k => $producer):?>
								<option value="<?=$producer["id"]?>"<? if ($producer["id"] == $product["producer_id"]) echo ' selected="selected"';?>><?=$producer["name"]?></option>
							<? endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="product_featured">Produs recomandat: </label></td>
					<td>
						<?=form_checkbox('product_featured', 'y', $product["featured"] == "y")?>
					</td>
				</tr>
				<tr>
					<td><label for="product_in_stock">Este pe stoc: </label></td>
					<td>
						<?=form_checkbox('product_in_stock', 'y', $product["in_stock"] == "y")?>
					</td>
				</tr>
				<tr>
					<td><label for="product_available_online">Disponibil online: </label></td>
					<td>
						<?=form_checkbox('product_available_online', 'y', $product["available_online"] == "y")?>
					</td>
				</tr>
				<tr>
					<td><label for="product_appear_on_site">Apare pe site: </label></td>
					<td>
						<?=form_checkbox('product_appear_on_site', 'y', $product["appear_on_site"] == "y")?>
					</td>
				</tr>
				<tr>
					<td><label for="product_discount_date_start">Data inceput discount: </label></td>
					<td>
						<input type="text" id="product_discount_date_start" name="product_discount_date_start" value="<?=$product["discount"]["start_date"]?>" />
					</td>
				</tr>
				<tr>
					<td><label for="product_discount_date_end">Data sfarsit discount: </label></td>
					<td>
						<input type="text" id="product_discount_date_end" name="product_discount_date_end" value="<?=$product["discount"]["end_date"]?>" />
					</td>
				</tr>
				<tr>
					<td><label for="product_discount_value">Valoare discount: </label></td>
					<td>
						<input type="text" id="product_discount_value" name="product_discount_value" value="<?=$product["discount"]["value"]?>" />
						<span style="font-weight:bold;color:green;"><?=$product["discount"]["calculated_price"]?></span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div id="productLanguageTabs">
							<ul>
								<? foreach ($languages_array as $lang): ?>
								<li><a href="#lang_tab_<?=$lang["code"]?>"><?=$lang["name"]?></a></li>
								<?php endforeach; ?>
							</ul>
							<? foreach ($languages_array as $lang): ?>
								<div id="lang_tab_<?=$lang["code"]?>">
									<table>
										<tr>
											<td><label>Denumire: </label></td>
											<td>
												<input type="text" id="product_name[<?=$lang["id"]?>]" name="product_name[<?=$lang["id"]?>]" value="<?=$product[$lang["code"]]["name"]?>" />
											</td>
										</tr>
										<tr>
											<td><label>Cuvinte cheie: </label></td>
											<td>
												<input type="text" id="product_keywords[<?=$lang["id"]?>]" name="product_keywords[<?=$lang["id"]?>]" value="<?=$product[$lang["code"]]["keywords"]?>" />
											</td>
										</tr>
										<tr>
											<td><label>Descriere scurta: </label></td>
											<td>
												<input type="text" id="product_short_desc[<?=$lang["id"]?>]" name="product_short_desc[<?=$lang["id"]?>]" value="<?=$product[$lang["code"]]["short_desc"]?>" />
											</td>
										</tr>
										<tr>
											<td valign="top"><label>Descriere: </label></td>
											<td>
												<textarea id="product_desc[<?=$lang["id"]?>]" name="product_desc[<?=$lang["id"]?>]" cols="80" rows="10"><?=$product[$lang["code"]]["description"]?></textarea>
											</td>
										</tr>
									</table>
								</div>
							<?php endforeach; ?>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Salveaza" /></td>
				</tr>
			</table>
		</div>
		<div style="float:left;margin-left:20px;">
			<fieldset>
				<legend>Categorii</legend>
				<div id="re_categories_div"></div>
				<!-- ADAUGARE INTR-O CATEGORIE -->
				<select id="re_category" name="re_category">
					<option value="0"> - alege categorie - </option>
					<?php foreach($categories as $k => $category):?>
						<option value="<?=$category["id"]?>"><?=$category["name"]?></option>
					<?php endforeach; ?>
				</select>
				<input type="button" value="Adauga" onclick="addReCategory()" />
			</fieldset>
		</div>
	</form>
</fieldset>
<fieldset style="width:100%">
	<legend>Poze</legend>
	<div id="product_pictures_div"></div>
	<div style="clear:both;"></div>
	<iframe src="<?php echo site_url("admin/products/image_upload_form"); ?>/<?=$product["id"]?>" style="width:100%;border:0px;"></iframe>
	
	<div id="change_picture_name_panel" title="Modifica denumire">
		<form id="change_picture_name_form" onsubmit="return false;">
			<input type="hidden" name="change_picture_name_id" id="change_picture_name_id" value="" />
			<table>
				<? foreach ($languages_array as $lang): ?>
					<tr>
						<td><label for="name">Denumire (<?=$lang["name"]?>):</label></td>
						<td><input type="text" name="name[<?=$lang["id"]?>]" id="name[<?=$lang["id"]?>]" /></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</form>
	</div>
	
</fieldset>
<fieldset style="width:100%">
	<legend>Caracteristici</legend>
	<div id="product_properties_div"></div>
	<!-- ADAUGARE VALOARE PRIOPRIETATE -->
	<div id="add_property_value_dialog" title="Adauga/modifica valoare prioprietate">
		<form id="add_property_value_form" name="add_property_value_form" method="post" onsubmit="return false">
			<input type="hidden" id="property_id" name="property_id" />
			<input type="hidden" id="product_re_property_id" name="product_re_property_id" />
			<table>
				<tr id="numeric_value_row">
					<td><label for="numeric_value">Valoare numerica: </label></td>
					<td><input type="text" id="numeric_value" name="numeric_value" /></td>
				</tr>
				<tr id="yes_no_value_row">
					<td><label for="yes_no_value">Valoare da/nu: </label></td>
					<td><input type="checkbox" id="yes_no_value" name="yes_no_value" /></td>
				</tr>
				<tr>
					<td><label for="change_price">Schimbare pret: </label></td>
					<td>
						<select id="change_price" name="change_price">
							<option value="no">Nu</option>
							<option value="add">Adaugare</option>
							<option value="replace">Inlocuire</option>
							<option value="add_percent">Adaugare procent</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="change_price_value">Schimba pretul cu: </label></td>
					<td><input type="text" id="change_price_value" name="change_price_value" /></td>
				</tr>
				<tr id="property_value_row">
					<td colspan="2">
						<div id="propertyValuesLanguageTabs">
							<ul>
								<? foreach ($languages_array as $lang): ?>
								<li><a href="#prop_lang_tab_<?=$lang["code"]?>"><?=$lang["name"]?></a></li>
								<?php endforeach; ?>
							</ul>
							<? foreach ($languages_array as $lang): ?>
								<div id="prop_lang_tab_<?=$lang["code"]?>">
									<table>
										<tr>
											<td><label>Valoare: </label></td>
											<td>
												<input type="text" id="prop_value[<?=$lang["id"]?>]" name="prop_value[<?=$lang["id"]?>]" />
											</td>
										</tr>
									</table>
								</div>
							<?php endforeach; ?>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
</fieldset>
<script>

	$('#productLanguageTabs').tabs();

	$('#propertyValuesLanguageTabs').tabs();

	$("#product_discount_date_start").datepicker({dateFormat:'yy-mm-dd'});
	$("#product_discount_date_end").datepicker({dateFormat:'yy-mm-dd'});

	function edit_property_value(type, property_id, product_re_property_id) {
		$('#property_id').val(property_id);
		if (product_re_property_id > 0) {
			// trebuie sa scoatem cu json datele
			loadPropertyValue(product_re_property_id, type);
		} else {
			//aici mai trebuie sa vedem daca este ceva valoare selectata...
			prp = $('#property_value_select\\['+property_id+'\\]').val();
			if (prp > 0) {
				loadPropertyValue(prp, type);
			} else {
				open_property_value_dialog(type);
			}
		}
	}

	function loadPropertyValue(product_re_property_id, type) {
		$('#product_re_property_id').val(product_re_property_id);
		$.getJSON(
				"<?php echo site_url("admin/products/product_re_property_JSON"); ?>/"+product_re_property_id,
				function(data) {
//					alert(data.property_values_id);
					$('#numeric_value').val(data.value.numeric_value);
					$('#yes_no_value').val(data.value.yes_no_value);
					$('#change_price').val(data.change_price);
					$('#change_price_value').val(data.change_price_value);
					
					$.each(data.lang, function(index, item) {
						$('#prop_value\\['+item.lang_id+'\\]').val(item.value);
					});
					open_property_value_dialog(type);
				}
			);
	}

	function delete_property_value(property_id, product_re_property_id) {
		if (product_re_property_id == 0) {
			product_re_property_id = $('#property_value_select\\['+property_id+'\\]').val();
		}
		$.post("<?=site_url("admin/products/delete_product_property")?>/"+product_re_property_id, 
				function (data) { 
					loadProperties(); 
//					alert(data);
			});
	}

	function open_property_value_dialog(type) {
		// trebuie sa afisam doar campurile relevante tipului de prioprietate
		// daca mai bagam si alte tipuri trebuie schimbat un pic...
		if (type == 'numeric') {
			$('#numeric_value_row').show();
		} else {
			$('#numeric_value_row').hide();
		}

		if (type == 'yes_no') {
			$('#yes_no_value_row').show();
			$('#property_value_row').hide();
		} else {
			$('#yes_no_value_row').hide();
			$('#property_value_row').show();
		}
		
		$('#add_property_value_dialog').dialog('open');
	}
	
	$('#add_property_value_dialog').dialog({
		autoOpen: false,
		modal:true,
		width: 300,
		buttons: {
			"Salveaza": function() {
				$.post("<?=site_url("admin/products/add_property_value/".$product["id"])?>", 
						$('#add_property_value_form').serialize(), 
						function (data) { 
							loadProperties(); 
							$('#add_property_value_dialog').dialog('close');
//							alert(data);
					});
			}
		}
	});
	
	function loadProductImages() {
		var url = '<?php echo site_url("admin/products/pictures"); ?>/<?=$product["id"]?>';
		$('#product_pictures_div').load(url);
	}

	function loadReCategories() {
		$.getJSON(
				"<?php echo site_url("admin/products/get_re_categories"); ?>/<?=$product["id"]?>",
				function(data) {
					$('#re_categories_div').empty();
					$.each(data, function(index, item) {
						$('#re_categories_div').append("<div>"+item.name+"<a href='javascript:void(0)' style='float:right' onclick='deleteReCategory("+item.re_id+")'>X</a></div>");
					});
				}
			);
	}

	function loadProperties() {
		$('#product_properties_div').load(
				'<?php echo site_url("admin/products/properties_table"); ?>/<?=$product["id"]?>'
			);
	}

	function deleteReCategory(id) {
		$.getJSON(
				"<?php echo site_url("admin/products/del_re_category"); ?>/"+id,
				function(data) {
					loadReCategories();
				}
			);
	}

	function addReCategory() {
		$.post(
				"<?php echo site_url("admin/products/add_re_category"); ?>/<?=$product["id"]?>/"+$('#re_category').val(),
				function(data) {
					loadReCategories();
				}
			);
	}

	loadReCategories();
	loadProperties();

	<? foreach ($languages_array as $lang): ?>
		CKEDITOR.replace( 'product_desc[<?=$lang["id"]?>]' );
	<?php endforeach; ?>

	function edit_picture_name(id) {
		$('#change_picture_name_id').val(id);
		<? foreach ($languages_array as $lang): ?>
		$('#name\\[<?=$lang["id"]?>\\]').val($('#picture_name_'+id+'_<?=$lang["id"]?>').val());
 		<?php endforeach; ?>
		$('#change_picture_name_panel').dialog('open');
	}
	$('#change_picture_name_panel').dialog({
		autoOpen: false,
		modal:true,
		width: 300,
		buttons: {
			"Salveaza": function() { 
				$(this).dialog('close');
				updatePic($('#change_picture_name_id').val(), 'update_lang', $('#change_picture_name_form').serialize());
			}
		}
	});

	function updatePic(id, action, postdata) {
		var url = "<?php echo site_url("admin/products/updatePic")?>/<?=$product["id"]?>/"+id+"/"+action;
		$.post(
				url,
				postdata,
				function(data){
					loadProductImages();
				}
			);
	}

</script>
