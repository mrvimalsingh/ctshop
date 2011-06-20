<div id="banner_div"></div>
<script>
	function loadNextBanner() {
		$.ajax({
			  url: '<?php echo site_url("banners/next/homepage"); ?>',
			  success: function(data) {
			    $('#banner_div').hide().html(data).fadeIn("slow");
			  }
			});
	}
	loadNextBanner();
	setInterval ('loadNextBanner()', 10000);
</script> 
<img src="<?php echo base_url(); ?>img/banner1.jpg" style="float: left;  margin: 10px 0px 6px 0px;"/>
<img src="<?php echo base_url(); ?>img/banner2.jpg" style="float: left;  margin: 10px 0px 5px 0px;"/>
<!-- bagam bannerele -->
<div class="homePg">
	<div style="float: left; width: 220px; margin-right: 10px;">
		<!-- ultima stire -->
		<div class="news_div">
			<? if (isset($news)): ?>
				<div class="news_title"><?=$news["title"]?> <span style="font-size: 11px; color: #ba5586;">(<?=$news["date_added"]?>)</span></div>
				<div class="news_content">
					<?=$news["content"]?>
					<a href="<?=site_url("news/show/".$news["id"]."/".url_title($news["title"]))?>">citeste toata stirea</a>
				</div>
			<? endif; ?>
		</div>
	</div>
	<div style="float: left;">
		<!-- produse recomandate -->
		<!-- <div class="titlePg"><span class="text">Produse recomandate</span></div> -->
		<div style="clear:both"></div>
		<? if (isset($featured_prods)) foreach($featured_prods as $k => $product):?>
			<?=getProductTemplate(0, $product)?>
		<? endforeach; ?>
	</div>
</div>
<div style="clear:both"></div>
