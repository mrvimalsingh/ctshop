<fieldset>
	<legend>Administrare noutati</legend>
	<table class="mytable" width="100%">
		<thead>
			<tr>
				<th>Limba</th>
				<th>Data adaugarii</th>
				<th>Titlu</th>
				<th>Cuvinte cheie</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<? foreach($news as $k => $n):?>
				<tr>
					<td><?=$n["language_name"]?></td>
					<td><?=$n["date_added"]?></td>
					<td><?=$n["title"]?></td>
					<td><?=$n["keywords"]?></td>
					<td>
						<a href="<?=site_url("admin/news/edit"); ?>/<?=$n["id"]?>"><img src="<?php echo base_url(); ?>img/edit.png" border="0" /></a>
					</td>
				</tr>
			<? endforeach; ?>
		</tbody>
	</table>
	<a href="<?=site_url("admin/news/edit")?>">Adauga noutate</a>
</fieldset>
