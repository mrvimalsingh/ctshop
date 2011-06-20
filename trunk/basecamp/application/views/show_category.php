<div class="content_n">
	<img src="<?php echo base_url(); ?>img/transport.jpg" style="float: left; margin: 0px 15px 5px 0px;"/>
	<img src="<?php echo base_url(); ?>img/cadouri.jpg" style="float: left; margin: 0px 15px 5px 0px;"/>
	<img src="<?php echo base_url(); ?>img/bijuterii-argint.jpg" style="float: left; margin: 0px 0px 5px 0px;"/>
	<div style="clear:both;"><!-- clear --></div>
	<!-- BREADCRUmBS un pic mai incolo... -->
<!--	<div class="headerNavigation"><a href="#">Home</a> &raquo; <a href="#"><?=$category["name"]?></a><br/></div>-->
	<div class="categ_description"><?=$category["description"]?></div>
	<!-- SUBCATEGORII -->
	<? foreach ($category["subcats"] as $k => $subcat): ?>
		<div class="categInfo">
			<h1><a href="<?=createCategoryLink($subcat["id"])?>"><?=$subcat["name"]?> (<?=$subcat["products_count"]?>)</a></h1>
			<a href="<?=createCategoryLink($subcat["id"])?>">
				<? if (!$subcat["img"]): ?>
					<img src="<?=base_url()?>img/faraPoza100.png" class="categImg"/>
				<?php else: ?>
						<img src="<?php echo site_url("images/get_category_image")?>/<?=$subcat["id"]?>" class="categImg"/>
				<?php endif; ?>
			</a>
			<div class="shortdesc">
				<?=$subcat["short_desc"]?>
			</div>
			<div class="links">
				<a href="#">&raquo; <b style="font-size: 10px; color: #b50faf;">Lichidare stoc</b></a> 
				<a href="#">&raquo; Promotii</a> 
				<a href="#">&raquo; In stoc</a> 
			</div>
		</div>
	<? endforeach; ?>
	<div style="clear:both"></div>
	<!-- PRODUSE -->
	<form method="post" action="<?=site_url("products/set_products_per_page")?>" name="products_per_page_form" id="products_per_page_form">
		<div class="prodDisplay">
			<div class="prodNr">
				<?=$products_count?> produse (din <?=$total_products?>)
					<?=form_dropdown('products_per_page', $products_per_page_select, $products_per_page, 'onchange="document.products_per_page_form.submit()"');?>
				   pe pagina
			</div>
			<div class="prodView">
				<?=$pagination_links?>
				<!-- <img src="<?php echo base_url(); ?>img/social.png"/> --> 
			</div>
		</div>
	</form>
	<? foreach ($category["products"] as $k => $prod): ?>
		<?=getProductTemplate($category["id"], $prod)?>
	<? endforeach; ?>
	<div style="clear:both"></div>
</div>
<div class="categories_left">
	<span class="categories_left_header">Sorteaza dupa:</span>
	<div class="categories_left_line">
		<form method="post" name="product_sort_form" id="product_sort_form" action="<?=site_url("products/change_sort_column")?>">
			<?=form_dropdown('sorting', $sort_column_values, $sort_column, 'onchange="document.product_sort_form.submit()"');?>
		</form>
	</div>
	<!-- asta apare daca sunt ceva filtre active -->
	<div class="active_filters_panel">
		<span class="categories_left_header">Filtre active:</span>
		<? foreach($active_filters as $k => $filter):?>
			<div>
				<?=$filter["text"]?>
				<div style="float:right">
					<a href="<?=site_url("products/delete_filter/".$k)?>">
						<img src="<?php echo base_url(); ?>img/action_delete.png" border="0" />
					</a>
				</div>
			</div>
		<? endforeach; ?>
	</div>
	<form method="post" action="<?=site_url("products/apply_filters")?>">
		<span class="categories_left_header">Pret:</span>
		<div class="categories_left_line">
			<label for="from_price">
				De la: 
				<input type="text" name="from_price" id="from_price" value="<?=getFilterValue("from_price", $active_filters)?>" />
			</label>
		</div>
		<div class="categories_left_line">
			<label for="to_price">
				Pana la: 
				<input type="text" name="to_price" id="to_price" value="<?=getFilterValue("to_price", $active_filters)?>" />
			</label>
		</div>
		<span class="categories_left_header">Filtrari:</span>
		<div class="categories_left_line">
			<label for="in_stock">
				<?=form_checkbox('in_stock', 'on', getFilterValue("in_stock", $active_filters), 'id="in_stock"')?>
				Produse pe stoc
			</label>
		</div>
		<div class="categories_left_line">
			<label for="special_offer">
				<?=form_checkbox('special_offer', 'on', getFilterValue("special_offer", $active_filters), 'id="special_offer"')?>
				Promotii
			</label>
		</div>
		<div class="categories_left_line">
			<label for="producer">
				Producator
				<?=form_dropdown('producer', $producers_dropdown, getFilterValue("producer", $active_filters), 'id="producer"');?>
			</label>
		</div>
		<div class="categories_left_line">
			<label for="search_string">
				Cauta in denumire/descriere: 
				<input type="text" name="search_string" id="search_string" value="<?=getFilterValue("search_string", $active_filters)?>" />
			</label>
		</div>
		<!-- AICI VIN SI RESTU CAND OR FI -->
		<input type="submit" value="Aplica filtre" />
	</form>
</div>