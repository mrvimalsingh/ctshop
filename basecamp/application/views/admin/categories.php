<fieldset width="100%">
	<link href="<?php echo base_url(); ?>css/jquery.treeview.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="<?=base_url()?>/js/jquery.treeview.js"></script> 
	<legend>Categorii</legend>
	<div style="float:left;width:400px;">
		<form method="post" action="<?php echo site_url("admin/categories/save_order"); ?>">
			
			<?=$category_ul_tree?>
			<input type="submit" value="Salveaza ordine" />
		</form>
		<input type="button" value="Adauga categorie" onclick="window.location.href='<? echo site_url("admin/categories/edit_category") ?>'" />
	</div>
</fieldset>


<script>

	$(".draggable").draggable({ revert: true });

	$(".droppable").droppable({
//		activeClass: 'ui-state-hover',
//		hoverClass: 'ui-state-active',
		drop: function(event, ui) {
			//$(this).addClass('ui-state-highlight').find('p').html('Dropped!');
//			alert('dropped: '+ui.draggable.attr("cat_id")+' into '+$(this).attr("cat_id"));
			update_category_parent(ui.draggable.attr("cat_id"), $(this).attr("cat_id"));
		}
	});

	function update_category_parent(cat, parent) {
		$.post(
				'<?php echo site_url("admin/categories/update_category_parent"); ?>/'+cat+'/'+parent,
				function(data) {
					window.location.reload();
				}
			);
	}

	$("#categories_tree_div").treeview({
		   collapsed: true,
		   animated: "fast",
		   unique: true
	});

	$('#edit_category_dialog').dialog({
		autoOpen: false,
		modal:true,
		width: 300,
		buttons: {
			"Salveaza": function() { 
				document.edit_category_form.submit();
//				$(this).dialog("close"); 
			}
		}
	});

</script>