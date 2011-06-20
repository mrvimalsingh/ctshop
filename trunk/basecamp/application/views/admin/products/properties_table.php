<table class="mytable" width="100%">
	<thead>
		<tr>
			<th>Tip</th>
			<th>UM</th>
			<th>Denumire</th>
			<th>Valoare</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($properties as $k2 => $prop):?>
			<tr>
				<td><?=lang("admin_product_properties_type_".$prop["type"])?></td>
				<td><?=$prop["um"]?></td>
				<td><?=$prop["name"]?></td>
				<td>
					<!-- DACA AVEM O SINGURA VALOARE O AFISAM DIRECT -->
					<? if (isset($prop["value"])): ?>
					<?=getPropertyDisplayValue($prop, $prop["value"]); ?>
					<!-- DACA AVEM MAI MULTE VALORI FACEM UN COMBO SI EDITAM CARE-I SELECTAT -->
					<? elseif (isset($prop["values"])): ?>
					<select name="property_value_select[<?=$prop["property_id"]?>]" id="property_value_select[<?=$prop["property_id"]?>]">
						<? foreach($prop["values"] as $k => $prop_val):?>
							<option value="<?=$prop_val["id"]?>"><?=getPropertyDisplayValue($prop, $prop_val); ?></option>
						<? endforeach; ?>
					</select>
					<!-- DACA NU ESTE SETATA VALOARE AFISAM N/A -->
					<? else: ?>
					N/A
					<? endif; ?>
				</td>
				<td>
					<a href="javascript:void(0);" onclick="edit_property_value('<?=$prop["type"]?>', <?=$prop["property_id"]?>, 0)">
						<img src="<?php echo base_url(); ?>img/action_add.png" border="0" />
					</a>
				</td>
				<td>
					<? if (isset($prop["value"]) || isset($prop["values"])): ?>
					<a href="javascript:void(0);" onclick="edit_property_value('<?=$prop["type"]?>', <?=$prop["property_id"]?>, <?=((isset($prop["value"]))?$prop["value"]["id"]:"0")?>)">
						<img src="<?php echo base_url(); ?>img/edit.png" border="0" />
					</a>
					<? endif; ?>
				</td>
				<td>
					<? if (isset($prop["value"]) || isset($prop["values"])): ?>
					<a href="javascript:void(0);" onclick="delete_property_value(<?=$prop["property_id"]?>, <?=((isset($prop["value"]))?$prop["value"]["id"]:"0")?>)">
						<img src="<?php echo base_url(); ?>img/action_delete.png" border="0" />
					</a>
					<? endif; ?>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
