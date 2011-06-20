<script type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script> 
<fieldset>
	<legend>Adaugare/Editare noutate</legend>
	<form method="post" action="<?=site_url("admin/news/save")?>">	
		<input type="hidden" name="news_id" value="<?=$news["id"]?>" />
		<table>
			<tr>
				<td><label for="news_title">Titlu: </label></td>
				<td><input type="text" name="news_title" id="news_title" value="<?=form_prep($news["title"])?>" /></td>
			</tr>
			<tr>
				<td><label for="news_lang">Limba: </label></td>
				<td>
					<select id="news_lang" name="news_lang">
						<? foreach ($languages_array as $lang): ?>
							<option value="<?=$lang["id"]?>" <?=set_select('news_lang', $lang["id"], $news["lang_id"] == $lang["id"])?>><?=$lang["name"]?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="news_keywords">Cuvinte cheie: </label></td>
				<td><input type="text" name="news_keywords" id="news_keywords" value="<?=form_prep($news["keywords"])?>" /></td>
			</tr>
			<tr>
				<td valign="top"><label for="news_content">Continut: </label></td>
				<td>
					<textarea name="news_content" id="news_content" cols="80" rows="10" width="100%"><?=form_prep($news["content"])?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="salveaza" /></td>
			</tr>
		</table>
	</form>
</fieldset>
<script>
	CKEDITOR.replace( 'news_content' );
</script>