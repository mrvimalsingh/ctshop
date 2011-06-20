<fieldset>
	<legend>Administrare banner</legend>
	<!-- aici vine un tabel cu toate bannerele -->
	<table class="mytable" width="100%">
		<thead>
			<tr>
				<th>Tip banner</th>
				<th>fisier</th>
				<th>link</th>
				<th>denumire</th>
				<th>descriere</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<? foreach($banners as $k => $banner):?>
				<tr>
					<td><?=$banner["banner_type"]?></td>
					<td><?=$banner["file_name"]?></td>
					<td><?=$banner["link"]?></td>
					<td><?=$banner["name"]?></td>
					<td><?=$banner["description"]?></td>
					<td>
						<a href="<?=site_url("admin/banner/delete")?>/<?=$banner["id"]?>" onclick="if (!confirm('Esti sigur ca vrei sa stergi?')) return false;"><img src="<?php echo base_url(); ?>img/action_delete.png" border="0" /></a>
					</td>
				</tr>
			<? endforeach; ?>
		</tbody>
	</table>
</fieldset>

<!-- adaugare de banner -->
<fieldset>
	<legend>Adauga banner</legend>
	<form method="post" enctype="multipart/form-data" action="<?php echo site_url("admin/banner/add_banner"); ?>">
		<table>
			<tr>
				<td><label for="banner_type">Tip banner: </label></td>
				<td>
					<select id="banner_type" name="banner_type">
					<? foreach($banner_sizes as $k => $banner_type):?>
						<option value="<?=$k?>"><?=$banner_type["name"]?> (<?=$banner_type["width"]?>x<?=$banner_type["height"]?>)</option>
					<? endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="banner_group">Grup banner: </label></td>
				<td>
					<select id="banner_group" name="banner_group">
						<option value="homepage">Homepage</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="file">Fisier: </label></td>
				<td><input type="file" name="file" id="file" /></td>
			</tr>
			<tr>
				<td><label for="banner_link">Link: </label></td>
				<td><input type="text" name="banner_link" id="banner_link" /></td>
			</tr>
			<tr>
				<td colspan="2">
					<!-- DENUMIRE SI DESCRIERE -->
					<div id="bannerLanguageTabs">
						<ul>
							<? foreach ($languages_array as $lang): ?>
							<li><a href="#lang_tab_<?=$lang["code"]?>"><?=$lang["name"]?></a></li>
							<?php endforeach; ?>
						</ul>
						<? foreach ($languages_array as $lang): ?>
							<div id="lang_tab_<?=$lang["code"]?>">
								<table>
									<tr>
										<td><label>Denumire: </label></td>
										<td>
											<input type="text" id="name[<?=$lang["id"]?>]" name="name[<?=$lang["id"]?>]" />
										</td>
									</tr>
									<tr>
										<td valign="top"><label>Descriere: </label></td>
										<td>
											<textarea type="text" id="desc[<?=$lang["id"]?>]" name="desc[<?=$lang["id"]?>]" cols="80" rows="10"></textarea>
										</td>
									</tr>
								</table>
							</div>
						<?php endforeach; ?>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="Adauga" />
				</td>
			</tr>
		</table>
	</form>
</fieldset>
<script>
	$('#bannerLanguageTabs').tabs();
</script>