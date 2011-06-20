<fieldset>
	<legend>Modifica comanda</legend>
	<form method="post" action="<?=site_url("admin/orders/save_order")?>/<?=$order["id"]?>">
		<table class="mytable">
			<tbody>
				<tr>
					<th><label>Cod: </label></th>
					<td><?=$order["order_nr"]?></td>
					<th><label>Data: </label></th>
					<td><?=$order["date_added"]?></td>
					<th><label>Client: </label></th>
					<td><?=$order["client_name"]?></td>
					<th><label>Status: </label></th>
					<td>
						<?php echo form_dropdown('order_status', $status_options, $order["status"], 'id="order_status"');?>
					</td>
				</tr>
				<tr>
					<td colspan="4">Observatii client: </td>
					<td colspan="4">Observatii: </td>
				</tr>
				<tr>
					<td colspan="4"><textarea style="width:100%" rows="5" name="client_obs"><?=$order["client_obs"]?></textarea></td>
					<td colspan="4"><textarea style="width:100%" rows="5" name="order_obs"><?=$order["obs"]?></textarea></td>
				</tr>
			</tbody>
		</table>
		<h2>Produse</h2>
		<table class="mytable">
			<thead>
				<tr>
					<th>Cod</th>
					<th>Denumire</th>
					<th>Cantitate</th>
					<th>Pret</th>
					<th>Subtotal</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($order_products as $prod): ?>
					<tr>
						<td><?=$prod["code"]?></td>
						<td><?=$prod["name"]?></td>
						<td><?=$prod["quantity"]?></td>
						<td><?=$prod["price"]?></td>
						<td><?=$prod["subtotal"]?></td>
					</tr>
				<?php endforeach; ?>
				<tr>
					<td>Transport</td>
					<td>	
						<select id="order_transport" name="order_transport" onchange="calculateTotalWithTransport()">
							<?php foreach ($transport_types as $k => $transport): ?>
								<option value="<?=$transport["id"]?>" price="<?=$transport["price"]?>" <?php if ($transport["id"] == $order["transport_type"]) echo 'selected="selected"';?>><?=$transport["name"]?> (<?=$transport["price"]?> RON)</option>
							<?php endforeach; ?>
						</select>
					</td>
					<td>-</td>
					<td><?=$order["transport_price"]?></td>
					<td><?=$order["transport_price"]?></td>
				</tr>
				<tr>
					<td>Plata</td>
					<td>
						<select id="order_payment" name="order_payment" onchange="calculateTotalWithTransport()">
							<?php foreach ($payment_types as $k => $payment): ?>
								<option value="<?=$payment["id"]?>" price="<?=$payment["price"]?>" <?php if ($payment["id"] == $order["pay_type"]) echo 'selected="selected"';?>><?=$payment["name"]?> (<?=$payment["price"]?> RON)</option>
							<?php endforeach; ?>
						</select>
					</td>
					<td>-</td>
					<td><?=$order["pay_type_price"]?></td>
					<td><?=$order["pay_type_price"]?></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4" style="text-align:right">Total:</td>
					<td><?=$order["total"]?></td>
				</tr>
			</tfoot>
		</table>
		<input type="submit" value="salveaza" />
	</form>
</fieldset>