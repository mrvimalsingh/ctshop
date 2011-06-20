
<?php 
	$index = 0;
	$last = count($pictures);
?>
<?php foreach($pictures as $k => $picture):?>
	<?php $index++; ?>
	<? foreach ($languages_array as $lang): ?>
	<input type="hidden" id="picture_name_<?=$picture["id"]?>_<?=$lang["id"]?>" value="<?=$picture["lang"][$lang["id"]]["name"]?>" />
	<?php endforeach; ?>
	<div style="float:left;">
		<table>
			<tr>
				<td colspan="2">
					<?=$picture["name"]?>
				</td>
				<td>
					<a href="javascript:void(0)" onclick="edit_picture_name('<?=$picture["id"]?>');">
						<img src="<?=base_url()?>/img/edit.png" border="0" />
					</a>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="width:110px;height:110px;">
					<a href="<?php echo site_url("images/get_image/big")?>/<?=$picture["id"]?>" class="highslide" onclick="return hs.expand(this)">
						<img src="<?php echo site_url("images/get_image/thumbnail")?>/<?=$picture["id"]?>" style="padding:5px;border:#aaa dotted 1px;margin:5px;" />
					</a>
				</td>
			</tr>
			<tr>
				<td>
					<?php if ($index > 1): ?>
					<a href="javascript:void(0)" onclick="updatePic('<?=$picture["id"]?>', 'left');"><img src="<?=base_url()?>/img/arrow_back.png" border="0" /></a>
					<?php endif; ?>
				</td>
				<td><a href="javascript:void(0)" onclick="if (confirm('esti sigur ca vrei sa stergi poza?')) updatePic('<?=$picture["id"]?>', 'del');"><img src="<?=base_url()?>/img/action_delete.png" border="0" /></a></td>
				<td>
					<?php if ($index < $last): ?>
					<a href="javascript:void(0)" onclick="updatePic('<?=$picture["id"]?>', 'right');"><img src="<?=base_url()?>/img/arrow_next.png" border="0" /></a>
					<?php endif; ?>
				</td>
			</tr>
		</table>
	</div>
<?php endforeach; ?>
