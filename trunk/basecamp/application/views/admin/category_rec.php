<li style="clear:both;" class="draggable droppable" cat_id="<?=$category["id"]?>">
<input type="text" name="order[<?=$category["id"]?>]" value="<?=$category["order"]?>" size="2" style="width:20;float:right;" />
<a href="<?=site_url("admin/categories/edit_category")?>/<?=$category["id"]?>" style="float:right;">
	<img src="<?=base_url()?>img/edit.png" />
</a>
<?=$category["name"]?>
<?php if (count($category["categories"]) > 0): ?>
	<ul>
		<?php foreach ($category["categories"] as $subcat): ?>
			<?=$subcat["template"]?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
</li>