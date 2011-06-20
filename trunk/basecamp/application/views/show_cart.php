<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/


?>
<h1>Cosul meu de cumparaturi</h1>

<? if (count($this->cart->contents()) > 0): ?>
	<form method="post" action="<?=site_url("myCart/update")?>">
		<table cellpadding="6" cellspacing="1" class="mytable" style="width:100%" border="0">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Produs</th>
			  	<th width="150">Cantitate</th>
			 	<th style="text-align:right">Pret</th>
			  	<th style="text-align:right">Subtotal</th>
			  	<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php $i = 1; ?>
		
		<?php foreach($this->cart->contents() as $items): ?>
		
			<?php echo form_hidden('cart['.$i.']'.'[rowid]', $items['rowid']); ?>
			
			<tr<?php if ($i % 2 == 0) echo " class='odd'"; ?>>
				<td class="imgTable">
					<?
						if ($this->cart->has_options($items['rowid']) == TRUE) {
							$options = $this->cart->product_options($items['rowid']);
						} 
					?>
					
					<? if (!isset($options["image_id"]) || $options["image_id"] == 0): ?>
						<img src="<?=base_url()?>img/fara-poza-shop-small.jpg" border="0" />
					<?php else: ?>
						<a href="<?php echo site_url("images/get_image/big")?>/<?=$options["image_id"]?>" id="mainImage" class="highslide" onclick="return hs.expand(this)">
							<img src="<?php echo site_url("images/get_image/thumbnail")?>/<?=$options["image_id"]?>" border="0" />
						</a>
					<?php endif; ?>
				</td>
				<td>
				<strong><?php echo $items['name']; ?></strong>
					<?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
							
						<p>
							<?php foreach ($options as $option_name => $option_value): ?>
								<? if ($option_name != "image_id"): ?>
								<?php echo $option_name; ?>: <?php echo $option_value; ?><br />
								<? endif; ?>
							<?php endforeach; ?>
						</p>
						
					<?php endif; ?>
			  	</td>
			  	<td><?php echo form_input(array('name' => 'cart['.$i.']'.'[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?></td>
			  	<td style="text-align:right"><?php echo $this->cart->format_number($items['price']); ?></td>
			  	<td style="text-align:right"><?php echo $this->cart->format_number($items['subtotal']); ?> RON</td>
			  	<td><a href="<?=site_url("myCart/remove")?>/<?=$items["rowid"]?>"><img src="<?=base_url()?>img/action_delete.png" /></a></td>
			</tr>
		<?php $i++; ?>
		
		<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
			  <td colspan="3">incl.19% TVA, excl. Transport & Procesare plata</td>
			  <td style="text-align:right"><strong>Total</strong></td>
			  <td style="text-align:right;color:red;font-weight:bold;"><?php echo $this->cart->format_number($this->cart->total()); ?> RON</td>
			  <td>&nbsp;</td>
			</tr>
		</tfoot>
		</table>
		<?php echo form_submit('', 'Recalculeaza'); ?>
	</form>
	<?php if ($error): ?>
	<strong style="color:red"><?=$error?></strong>
	<?php endif; ?>
	<div style="float:left;width:430px">
		<form method="post" action="<?=site_url("orders/add_order")?>" onsubmit="if (!validate()) return false;">
			<table class="mytable" width="100%">
				<?php if (!$client["id"]): ?>
					<tr>
						<th colspan="2"><strong>Creaza cont nou: </strong></th>
					</tr>
					<tr>
						<td><label for="order_new_email">Email: </label></td>
						<td><input type="text" name="order_new_email" id="order_new_email" value="" style="width:30%" /></td>
					</tr>
					<tr>
						<td><label for="order_new_password">Parola: </label></td>
						<td><input type="password" name="order_new_password" id="order_new_password" value="" style="width:30%" /></td>
					</tr>
				<?php endif; ?>
			</table>
			<!-- datele despre transport si plata -->
			<h1>Transport &amp; Plata</h1>
			<table class="mytable" width="100%">
				<tbody>
					<tr>
						<td width="200px;"><label for="order_transport">Tip Trasport:</label></td>
						<td>
							<select id="order_transport" name="order_transport" onchange="calculateTotalWithTransport()">
								<option value="0" price="0"> - alege tip transport - </option>
								<?php foreach ($transport_types as $k => $transport): ?>
									<option value="<?=$transport["id"]?>" price="<?=$transport["price"]?>"><?=$transport["name"]?> (<?=$transport["price"]?> RON)</option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width="200px;"><label for="order_payment">Tip Plata:</label></td>
						<td>
							<select id="order_payment" name="order_payment" onchange="calculateTotalWithTransport()">
								<option value="0" price="0"> - alege tip plata - </option>
								<?php foreach ($payment_types as $k => $payment): ?>
									<option value="<?=$payment["id"]?>" price="<?=$payment["price"]?>"><?=$payment["name"]?> (<?=$payment["price"]?> RON)</option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td style="text-align:right"><strong>Total cu transport: </strong></td>
				  		<td style="text-align:right;color:red;font-weight:bold;"><span id="total_cu_transport"></span> RON</td>
					</tr>
				</tbody>
			</table>
			
			<!-- date despre client -->
			<h1>Date client</h1>
			<table class="mytable" style="width:100%">
				<tbody>
					<tr>
						<td width="200px;"><label for="order_client_type">Tip Client:</label></td>
						<td>
							<select id="order_client_type" name="order_client_type" onchange="selectClientType()">
								<option value="person" <? if ($client["type"] == 'person') echo "selected='selected'" ?>>Persoana fizica</option>
								<option value="company" <? if ($client["type"] == 'company') echo "selected='selected'" ?>>Companie</option>
							</select>
						</td>
					</tr>
					<tr id="order_company_name_row">
						<td><label for="order_company_name">Denumire Companie: </label></td>
						<td><input type="text" name="order_company_name" id="order_company_name" value="<?=form_prep($client["company_name"])?>" style="width:30%" /></td>
					</tr>
					<tr id="order_fiscal_code_row">
						<td><label for="order_fiscal_code">Cod Fiscal: </label></td>
						<td><input type="text" name="order_fiscal_code" id="order_fiscal_code" value="<?=form_prep($client["fiscal_code"])?>" style="width:30%" /></td>
					</tr>
					<tr id="order_nr_ord_reg_com_row">
						<td><label for="order_nr_ord_reg_com">Nr ord. reg. Com.: </label></td>
						<td><input type="text" name="order_nr_ord_reg_com" id="order_nr_ord_reg_com" value="<?=form_prep($client["nr_ord_reg_com"])?>" style="width:30%" /></td>
					</tr>
					<tr id="order_person_name_row">
						<td><label for="order_person_name">Nume, Prenume: </label></td>
						<td><input type="text" name="order_person_name" id="order_person_name" value="<?=form_prep($client["person_name"])?>"  style="width:30%"/></td>
					</tr>
					<tr id="order_cnp_row">
						<td><label for="order_cnp">CNP: </label></td>
						<td><input type="text" name="order_cnp" id="order_cnp" value="<?=form_prep($client["cnp"])?>" style="width:30%" /></td>
					</tr>
					<tr>
						<td><label for="order_phone">Telefon: </label></td>
						<td><input type="text" name="order_phone" id="order_phone" value="<?=form_prep($client["phone"])?>" style="width:30%" /></td>
					</tr>
					<tr>
						<td><label for="order_address">Adresa: </label></td>
						<td><input type="text" name="order_address" id="order_address" value="<?=form_prep($client["address"])?>" style="width:30%" /></td>
					</tr>
					<tr>
						<td><label for="order_town">Localitate: </label></td>
						<td><input type="text" name="order_town" id="order_town" value="<?=form_prep($client["town"])?>" style="width:30%" /></td>
					</tr>
					<tr>
						<td><label for="order_zip">Cod Postal: </label></td>
						<td><input type="text" name="order_zip" id="order_zip" value="<?=form_prep($client["zip"])?>" style="width:30%" /></td>
					</tr>
					<tr>
						<td><label for="order_county">Judet: </label></td>
						<td>
							<select name="order_county" id="order_county">
								<option value="0"> - alege judet - </option>
								<?php foreach ($counties as $k => $county): ?>
									<option value="<?=$county["id"]?>" <? if ($client["county"] == $county["id"]) echo "selected='selected'" ?>><?=$county["name"]?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for="order_obs">Observatii: </label></td>
						<td><textarea name="order_obs" id="order_obs" style="width:100%" rows="5"></textarea></td>
					</tr>
				</tbody>
			</table>
			<input type="submit" value="Comanda" />
		</form>
	</div>
	
	<div style="float:left;width:430px;margin-left:20px;">
		<?php if (!$client["id"]): ?>
		<form method="post" action="<?=site_url("client/login/true")?>">
			<table class="mytable" width="100%">
				<tbody>
					<tr>
						<th colspan="2"><strong>Autentificare</strong></th>
					</tr>
					<tr>
						<td><label for="email">Email: </label></td>
						<td><input type="text" name="email" id="email" value="" style="width:30%" /></td>
					</tr>
					<tr>
						<td><label for="password">Parola: </label></td>
						<td><input type="password" name="password" id="password" value="" style="width:30%" /></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Login" /></td>
					</tr>
				</tbody>
			</table>
		</form>
		<?php endif; ?>
	</div>
	
	<script>
	
		var valiation_messages = {
					'order_transport': 'Trebuie sa alegeti o modalitate de transport!',
					'order_payment': 'Trebuie sa alegeti o modalitate de plata!',
					'order_company_name': 'Trebuie sa completati denumirea firmei!',
					'order_fiscal_code': 'Trebuie sa completati codul fiscal!',
					'order_nr_ord_reg_com': 'Trebuie sa completati numarul de ordine in registrul comertlui!',
					'order_person_name': 'Trebuie sa completati numele!',
					'order_cnp': 'Trebuie sa completati cnp-ul!',
					'order_phone': 'Trebuie sa completati numarul de telefon!',
					'order_address': 'Trebuie sa completati adresa!',
					'order_town': 'Trebuie sa completati orasul!',
					'order_county': 'Trebuie sa alegeti un judet!',
					'order_new_email': 'Pentru a va face cont este necesar o adresa de mail!',
					'order_new_password': 'Trebuie sa alegeti o parola!'
				};
	
		function validate() {
	
			if (!validate_field('order_transport', 0)) return false;
			if (!validate_field('order_payment', 0)) return false;
	
			if ($('#order_client_type').val() == "company") {
				if (!validate_field('order_company_name', "")) return false;
				if (!validate_field('order_fiscal_code', "")) return false;
				if (!validate_field('order_nr_ord_reg_com', "")) return false;
			} else if ($('#order_client_type').val() == "person") {
				if (!validate_field('order_person_name', "")) return false;
				if (!validate_field('order_cnp', "")) return false;
			}
	
			if (!validate_field('order_phone', "")) return false;
			if (!validate_field('order_address', "")) return false;
			if (!validate_field('order_town', "")) return false;
			
			if (!validate_field('order_county', 0)) return false;
	
			<?php if (!$client["id"]): ?>
			if (!validate_field('order_new_email', "")) return false;
			if (!validate_field('order_new_password', "")) return false;
			<?php endif; ?>
			
			return true;
		}
	
		function validate_field(field_id, wrong_value) {
			if ($('#'+field_id).val() == wrong_value) {
				$('#'+field_id).focus();
				alert(valiation_messages[field_id]);
				return false;
			}
			return true;
		}
	
		function validation_failed() {
			alert('trebuie completate toate campurile');
			return false;
		}
	
		function selectClientType() {
			if ($('#order_client_type').val() == "person") {
				$('#order_company_name_row').hide();
				$('#order_fiscal_code_row').hide();
				$('#order_nr_ord_reg_com_row').hide();
				$('#order_person_name_row').show();
				$('#order_cnp_row').show();
			} else {
				$('#order_company_name_row').show();
				$('#order_fiscal_code_row').show();
				$('#order_nr_ord_reg_com_row').show();
				$('#order_person_name_row').hide();
				$('#order_cnp_row').hide();
			}
		}
	
		selectClientType();
	
		function calculateTotalWithTransport() {
			// total_cu_transport
			var transport_price = $('#order_transport option:selected').attr("price");
			var payment_price = $('#order_payment option:selected').attr("price");
			var total = parseFloat(<?=$this->cart->total()?>)+parseFloat(transport_price)+parseFloat(payment_price);
			$('#total_cu_transport').html(total.toFixed(2));
		}
	
		calculateTotalWithTransport();
			
	</script>
<? else: ?>
	<strong style="color:purple">Nu aveti nici un produs in cos...</strong>
<? endif; ?>