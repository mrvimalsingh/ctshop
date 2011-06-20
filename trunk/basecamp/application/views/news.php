<h2>Noutati</h2>
<? foreach($news as $k => $n):?>
	<div class="news_div">
		<span class="news_title"><?=$n["title"]?> (<?=$n["date_added"]?>)</span>
		<div class="news_content">
			<?=$n["content"]?>
			<a href="<?=site_url("news/show/".$n["id"]."/".url_title($n["title"]))?>">citeste toata stirea</a>
		</div>
	</div>
<? endforeach; ?>