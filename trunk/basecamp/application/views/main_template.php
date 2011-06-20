<html>
<head>
    <title>CT - SHOP</title>
    <link href="<?php echo base_url(); ?>css/main.css" type="text/css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/table.css" type="text/css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>css/superfish.css" type="text/css" rel="stylesheet">

    <link type="text/css" href="<?php echo base_url(); ?>css/cupertino/jquery-ui-1.8.1.custom.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/highslide.css" />
    <!--[if lt IE 7]>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/highslide-ie6.css" />
    <![endif]-->
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.4.2.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery-ui-1.8.1.custom.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/highslide-with-gallery.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.hoverIntent.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/superfish.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/supersubs.js"></script>
    <script>
        //<![CDATA[
        hs.registerOverlay({
            html: '<div class="closebutton" onclick="return hs.close(this)" title="Close"></div>',
            position: 'top right',
            fade: 2 // fading the semi-transparent overlay looks bad in IE
        });

        hs.graphicsDir = '<?php echo base_url(); ?>css/graphics/';
        hs.wrapperClassName = 'borderless';
        //]]>
    </script>
</head>
<body>
<div align="center" class="wrapper">
    <div class="topContent" align="left">
        <a href="<?=site_url("home")?>"><img src="<?php echo base_url(); ?>img/logo2.png" style="float:left; margin-left: 15px; margin-top: 18px; margin-bottom: 8px;" border="0"/></a>
        <div style="float:right;margin-right:20px;" class="top_menu_item">
            <ul style="float: right; margin-top: 30px;" class="secondLine">
                <li><a href="<?=site_url("home")?>"><?=lang("main_template_home");?></a></li>
                <li><img src="<?php echo base_url(); ?>img/top-line.gif" border="0" style="margin: 0px 10px;"/></li>
                <?php if ($client_id > 0): ?>
                <li><a href="<?=site_url("wishlist")?>"><?=lang("main_template_wishlist");?></a></li>
                <li><img src="<?php echo base_url(); ?>img/top-line.gif" border="0" style="margin: 0px 10px;"/></li>
                <li><a href="<?=site_url("client/logout")?>"><?=lang("main_template_logout");?></a></li>
                <?php else: ?>
                <li><a href="<?=site_url("client/login")?>"><?=lang("main_template_login");?></a></li>
                <?php endif; ?>
                <li><img src="<?php echo base_url(); ?>img/top-line.gif" border="0" style="margin: 0px 10px;"/></li>
                <li><a href="#"><strong><?=lang("main_template_sales");?></strong></a></li>  <? // TODO M1 this link must be solved ?>
                <li><img src="<?php echo base_url(); ?>img/top-line.gif" border="0" style="margin: 0px 10px;"/></li>
                <li><a href="<?=site_url("contact");?>"><?=lang("main_template_contact");?></a></li>
            </ul>
        </div>
    </div>
    <div style="clear: both;"><!-- clear --></div>
    <div class="topLinks"><!-- sds --></div>
    <div class="continut">
        <div class="top_menu_item">
            <ul>
                <li style="font-weight: bold;"><a href="<?=site_url("cart")?>"><?=lang("main_template_my_cart");?></a> ( <?=$cart_products_count?> produse, <?=$cart_products_total?> RON )</li>
                <li><img src="<?php echo base_url(); ?>img/top-line.gif" border="0" style="margin: 0px 10px;"/></li>
                <li style="font-weight: bold;"><a href="<?=site_url("client/my_account")?>"><?=lang("main_template_preferences");?></a></li>
                <?php if ($client_id > 0): ?>
                    <li><img src="<?php echo base_url(); ?>img/top-line.gif" border="0" style="margin: 0px 10px;"/></li>
                    <li><a href="<?=site_url("wishlist")?>"><?=lang("main_template_wishlist");?></a></li>
                <?php endif; ?>
                <li><img src="<?php echo base_url(); ?>img/top-line.gif" border="0" style="margin: 0px 10px;"/></li>
                <li>
                    <? foreach ($languages_array as $lang): ?>
                    <a href="<?=site_url("main/change_lang/".$lang["id"])?>"><?=$lang["code"]?></a>
                    <?php endforeach; ?>
                </li>
            </ul>
        </div>
        <div class="page" align="left">
            <div class="header">
                <div class="header_content">
                    <div style="float:left;margin-left:0px; margin-top: 15px;">
                        <?=$category_ul_tree?>
                    </div>
                </div>
            </div>
            <div class="content_div">
                <?=$content?>
            </div>
            <div style="clear:both;"></div>
            <div class="bottom">
                <ul>
                    <li><a href="<?=site_url("home")?>"><?=lang("main_template_home");?></a></li>
                    <li><a href="<?=site_url("news")?>"><?=lang("main_template_news");?></a></li>
                    <li><a href="<?=site_url("sales")?>"><?=lang("main_template_sales");?></a></li>  <? // TODO M1 this link must be solved ?>
                    <li><a href="#"><?=lang("main_template_transport_info");?></a></li>  <? // TODO M1 this link must be solved ?>
                    <li><a href="<?=site_url("how_to_pay")?>"><?=lang("main_template_payment_info");?></a></li>
                    <li><a href="<?=site_url("terms")?>"><?=lang("main_template_t_and_c");?></a></li>
                    <li><a href="<?=site_url("contact")?>"><?=lang("main_template_contact");?></a></li>
                    <li><a href="#"><?=lang("main_template_sitemap");?></a></li>      <? // TODO M1 this link must be solved ?>
                </ul>
                <div class="copyright">Copyright &#169; 2010 <strong>CTshop - <i>Innovative Shopping</i></strong>. All rights reserved.</div>
            </div>
        </div>
    </div>

</div>
</body>
<script>
    $(document).ready(function(){
        $("#categories_tree_div").supersubs({
            minWidth:    12,   // minimum width of sub-menus in em units 
            maxWidth:    100,   // maximum width of sub-menus in em units 
            extraWidth:  1     // extra width can ensure lines don't sometimes turn over 
            // due to slight rounding differences and font-family
        }).superfish({
                         animation: {height:'show'},   // slide-down effect without fade-in
                         delay:     1200               // 1.2 second delay on mouseout
                     });
    });
</script>
</html>