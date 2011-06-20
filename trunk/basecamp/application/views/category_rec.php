<li>
<a href="<?=createCategoryLink($category["id"])?>"><?=$category["name"]?></a>
<?php if (count($category["categories"]) > 0): ?>
	<ul>
		<?php foreach ($category["categories"] as $subcat): ?>
			<?=$subcat["template"]?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
</li>