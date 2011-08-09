<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <TITLE>Admin SHOP</TITLE>
    <link href="<?php echo base_url(); ?>css/admin.css" type="text/css" rel="stylesheet" />
    <link type="text/css" href="<?php echo base_url(); ?>css/cupertino/jquery-ui-1.8.1.custom.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jquery.autocomplete.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/highslide.css" />
    <!--[if lt IE 7]>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/highslide-ie6.css" />
    <![endif]-->
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.4.2.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery-ui-1.8.1.custom.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.autocomplete.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jsonrpc.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/utilities.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?=base_url()?>/js/highslide.js"></script>
    <script>
        baseUri = '<?=base_url();?>';
        //<![CDATA[
        hs.registerOverlay({
            html: '<div class="closebutton" onclick="return hs.close(this)" title="Close"></div>',
            position: 'top right',
            fade: 2 // fading the semi-transparent overlay looks bad in IE
        });

        hs.graphicsDir = '<?php echo base_url(); ?>css/highslide/';
        hs.wrapperClassName = 'borderless';
        //]]>
    </script>
</head>
<body>
<CENTER>
    <TABLE width="100%" valign="top" cellspacing="1">
        <TBODY><TR>
            <TD width="200">
                <img src="<?php echo base_url(); ?>img/logo-small.png" />
            </TD>
            <TD>
                <div style="margin-left: 10px;" class="infoUser">
                    <B><?=lang('admin_user')?>: </B> | Jewerly Shop |
                    <A href="<?php echo site_url("admin/user/logout"); ?>" onclick="return confirm('Intr-adevar logout?');">Logout</A>
                </div>
            </TD>
        </TR>
        <TR>
            <TD valign="top" width="200" style="padding-top: 40px;">
                <UL class="fancy_menu" style="list-style-type: none;">
                    <LI><A href="<?php echo site_url("admin/reports"); ?>"><span class="ui-icon ui-icon-document" style="float:left"></span>Rapoarte</A></LI>
                    <LI><A href="<?php echo site_url("admin/productReviews"); ?>"><span class="ui-icon ui-icon-comment" style="float:left"></span>Administrare reviews</A></LI>
                    <LI><A href="<?php echo site_url("admin/news"); ?>"><span class="ui-icon ui-icon-document-b" style="float:left"></span>Administrare noutati</A></LI>
                    <LI><A href="<?php echo site_url("admin/categories_new"); ?>"><span class="ui-icon ui-icon-folder-open" style="float:left"></span>Administrare categorii</A></LI>
                    <LI><A href="<?php echo site_url("admin/products"); ?>"><span class="ui-icon ui-icon-tag" style="float:left"></span>Administrare produse</A></LI>
                    <LI><A href="<?php echo site_url("admin/products_new"); ?>"><span class="ui-icon ui-icon-tag" style="float:left"></span>Administrare produse NEW</A></LI>
                    <LI><A href="<?php echo site_url("admin/productProperties"); ?>"><span class="ui-icon ui-icon-gear" style="float:left"></span>Prioprietati produse</A></LI>
                    <LI><A href="<?php echo site_url("admin/producers"); ?>"><span class="ui-icon ui-icon-person" style="float:left"></span>Producatori</A></LI>
                    <LI><A href="<?php echo site_url("admin/orders"); ?>"><span class="ui-icon ui-icon-transferthick-e-w" style="float:left"></span>Administrare comenzi</A></LI>
                    <LI><A href="<?php echo site_url("admin/ptSettings"); ?>"><span class="ui-icon ui-icon-calculator" style="float:left"></span>Setari plata &amp; transport</A></LI>
                    <LI><A href="<?php echo site_url("admin/languages"); ?>"><span class="ui-icon ui-icon-flag" style="float:left"></span>Setari limbi</A></LI>
                    <LI><A href="<?php echo site_url("admin/firm"); ?>"><span class="ui-icon ui-icon-suitcase" style="float:left"></span>Detalii firma</A></LI>
                    <LI><A href="<?php echo site_url("admin/users"); ?>"><span class="ui-icon ui-icon-person" style="float:left"></span>Administrare utilizatori</A></LI>
                    <LI><A href="<?php echo site_url("admin/clients"); ?>"><span class="ui-icon ui-icon-cart" style="float:left"></span>Administrare clienti</A></LI>
                    <LI><A href="<?php echo site_url("admin/banner"); ?>"><span class="ui-icon ui-icon-image" style="float:left"></span>Administrare banner</A></LI>
                </UL>
            </TD>
            <TD valign="top" style="padding-top: 40px;">
            <?=$content?>
            </TD>
        </TR>
        <tr>
            <td colspan="2" align="center">
                <img src="<?=base_url()?>img/advertise_leaderboard.png" />
            </td>
        </tr>
        </TBODY></TABLE>
</CENTER>
</body>
</html>
<script>
    applyJqueryStyle();
</script>