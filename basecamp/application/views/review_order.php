<!-- continutul cosului -->
<h1>Produse</h1>
<table cellpadding="6" cellspacing="1" class="mytable" style="width:100%" border="0">
<thead>
	<tr>
	  	<th>&nbsp;</th>
		<th>Produs</th>
	  	<th width="150">Cantitate</th>
	 	<th style="text-align:right">Pret</th>
	  	<th style="text-align:right">Subtotal</th>
	</tr>
</thead>
<tbody>
<?php $i = 1; ?>

<?php foreach($this->cart->contents() as $items): ?>

	<tr<?php if ($i % 2 == 0) echo " class='odd'"; ?>>
	  <td class="imgTable">
	  	<?
			if ($this->cart->has_options($items['rowid']) == TRUE) {
				$options = $this->cart->product_options($items['rowid']);
			} 
		?>
		
		<? if (!isset($options["image_id"]) || $options["image_id"] == 0): ?>
			<img src="<?=base_url()?>img/fara-poza-shop-small.jpg" border="0" />
		<?php else: ?>
			<a href="<?php echo site_url("images/get_image/big")?>/<?=$options["image_id"]?>" id="mainImage" class="highslide" onclick="return hs.expand(this)">
				<img src="<?php echo site_url("images/get_image/thumbnail")?>/<?=$options["image_id"]?>" border="0" />
			</a>
		<?php endif; ?>
	  </td>
	  <td>
		<?php echo $items['name']; ?>
					
			<?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
					
				<p>
					<?php foreach ($options as $option_name => $option_value): ?>
						<? if ($option_name != "image_id"): ?>
						<?php echo $option_name; ?>: <?php echo $option_value; ?><br />
						<? endif; ?>
					<?php endforeach; ?>
				</p>
				
			<?php endif; ?>
				
	  </td>
	  <td><?=$items['qty']?></td>
	  <td style="text-align:right"><?php echo $this->cart->format_number($items['price']); ?></td>
	  <td style="text-align:right"><?php echo $this->cart->format_number($items['subtotal']); ?> RON</td>
	</tr>

<?php $i++; ?>

<?php endforeach; ?>
</tbody>
<tfoot>
	<tr>
	  <td colspan="3"> </td>
	  <td style="text-align:right"><strong>Total</strong></td>
	  <td style="text-align:right;color:red;font-weight:bold;"><?php echo $this->cart->format_number($this->cart->total()); ?> RON</td>
	</tr>
</tfoot>
</table>
