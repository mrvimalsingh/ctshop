<!-- IMAGE SELECTION DIALOG STUFF -->
<div id="image_select_dialog">
    <iframe id="image_upload_iframe" style="border:0px;" frameborder="0" width="100%" height="100px"></iframe>
    <div id="image_select_dialog_images"></div>
</div>
<script>

    function imageUploaded(imageCategory, hash) {
        //loadImagesForImageSelectDialog(imageCategory);
        $('#image_select_dialog').dialog('close');
        selectImage(imageCategory, hash);
    }

    $('#image_select_dialog').dialog({ title: 'Select an image from below or upload one if you want:', height: 530, width: 600, autoOpen:false });

    function startSelectImage(imageCategory) {
        $('#image_select_dialog').dialog('open');
        loadImagesForImageSelectDialog(imageCategory);
    }
    function loadImagesForImageSelectDialog(imageCategory) {
        $('#image_upload_iframe').attr('src', '<?=site_url('images/image_upload_form')?>/'+imageCategory);
        // load all images
        $('#image_select_dialog_images').empty();
        makeJsonRpcCall('general', 'getImages', {"imageCategory": imageCategory}, function (data) {
            if (data.error != null) {
                alert(data.error.message);
            } else {
                var images = data.result;
                $(images).each(function (index, item) {
                    $('#image_select_dialog_images').prepend('<a href="javascript:void(0);" onClick="selectImage(\''+imageCategory+'\', \''+item+'\');" style="margin:5px;float:left;"><img src="<?=base_url()?>/images/get_image_improved/'+imageCategory+'/c100/'+item+'" style="border: 0;" /></a>');
                });
            }
        });
    }
</script>