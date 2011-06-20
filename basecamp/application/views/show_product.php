<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/


?>
<script type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script>
<script src='<?=base_url()?>js/jquery.rating.js' type="text/javascript" language="javascript"></script>
<link href='<?=base_url()?>css/jquery.rating.css' type="text/css" rel="stylesheet" />
<div style="float: left;width:200px;">
    Produse similare
    <? if (isset($similar_prods)) foreach($similar_prods as $k => $product) :?>
    <?=getProductTemplate($category_id, $product)?>
    <? endforeach; ?>
</div>
<div class="content_n">
    <img src="<?php echo base_url(); ?>img/transport.jpg" style="float: left; margin: 0px 15px 5px 0px;"/>
    <img src="<?php echo base_url(); ?>img/cadouri.jpg" style="float: left; margin: 0px 15px 5px 0px;"/>
    <img src="<?php echo base_url(); ?>img/bijuterii-argint.jpg" style="float: left; margin: 0px 0px 5px 0px;"/>
    <div class="headerNavigation"><a href="#">Home</a> &raquo; <a href="#">nume categorie</a> &raquo; <?=$product_model["name"]?><br/></div>
    <div class="titleProd"><h1><?=$product_model["name"]?></h1></div>
    <div class="linksProd">
        <a href="ymsgr:im?+&msg=<?=createProductLink($category_id, $product_model["id"])?>">Trimite unui prieten</a>
        <!--  | <a href="#">Compara cu alte produse</a> | <a href="#">Opinia cumparatorilor <img src="<?php echo base_url(); ?>img/stelute.gif"/><span style="font-size: 10px;">(4 review-uri)</span></a> -->
    </div>
    <!-- <a href="<?=site_url("myCart/add")?>/<?=$product_model["id"]?>" style="float:right"><img src="<?=base_url()?>img/comanda.png" /></a>  -->
    <!-- POZA -->
    <div class="prod_picture">
        <? if (!isset($product_model["main_picture"]["id"]) || $product_model["main_picture"]["id"] == 0) : ?>
        <img src="<?=base_url()?>img/farapozaMare.jpg" style="padding:5px;border:#aaa dotted 1px;margin:5px;float:left;" />
        <?php else: ?>
        <a href="<?php echo site_url("images/get_image/big")?>/<?=$product_model["main_picture"]["id"]?>" id="mainImage" class="highslide" onclick="return hs.expand(this)">
            <img src="<?php echo site_url("images/get_image/medium")?>/<?=$product_model["main_picture"]["id"]?>" style="padding:5px;border:#aaa dotted 1px;margin:5px;" />
        </a>
        <?php endif; ?>
        <? if (isset($product_model["pictures"])) : ?>
        <div class="hidden-container">
            <? foreach($product_model["pictures"] as $k => $image):?>
            <a href="<?php echo site_url("images/get_image/big")?>/<?=$image["id"]?>" class="highslide" onclick="return hs.expand(this, { thumbnailId: 'mainImage' })">
                <img src="<?php echo site_url("images/get_image/medium")?>/<?=$image["id"]?>" style="padding:5px;border:#aaa dotted 1px;margin:5px;" />
            </a>
            <? endforeach; ?>
        </div>
        <? endif; ?>
    </div>
    <div class="prodDetailsTop">
		<span id="details"><?=number_format($product_model["discount_price"], 2, ".", "")?> RON
		<!-- select><option>RON</option><option>EUR</option><option>USD</option></select> -->, pret cu TVA</span>
    </div>
    <div class="prodDetailsCenter">
        <div class="details">
            <? if ($product_model["use_discount"]) : ?>
            <span style="color: #200f07; font-weight: bold;text-decoration:line-through;"><?=number_format($product_model["price"], 2, ".", "")?> RON</span>, <span style="color: #497c00; font-weight: bold; font-size: 16px;">-<?=$product_model["discount_value"]?>% REDUCERE</span> <br/><br/>
            <? endif; ?>
            <label>COD:</label> <?=$product_model["code"]?><br/>
            <? if ($product_model["in_stock"] == 'y') : ?>
            <label>Disponibilitate:</label>
            <? if ($product_model["in_stock"] == "y") : ?>
                <strong style="color:#007d00">in stoc</strong>
                <? else: ?>
                <strong style="color:red">nu este pe stoc</strong>
                <? endif; ?>
            <?php endif; ?>	<br/>
            <span class="shortDesc"><?=$product_model["short_desc"]?></span><br/><br/><br/><br/>
            <form name="cart_add_form" method="post" action="<?=site_url("myCart/add")?>/<?=$product_model["id"]?>">
                <input id="cart_add_count" name="cart_add_count" type="text" value="1" style="margin-top: 3px; text-align: right;"/>
                <?php if ($client_id > 0) : ?>
                <a href="<?=site_url("wishlist/add")?>/<?=$product_model["id"]?>" style="float:right; font-size: 10px; color: #4b3a1f; text-decoration: none; font-weight: bold; margin-top: 5px;">&#171; Adauga la wishlist</a>
                <? endif; ?>
                <a href="javascript:void(0)" onclick="document.cart_add_form.submit()" style="float:right; margin-right: 10px;"><img src="<?=base_url()?>img/cart.gif" /></a>
            </form>
        </div>
    </div>
    <div class="prodDetailsBottom">
        <!-- prodBottom -->
    </div>
    <div style="clear:both"></div>
    <h2>Detalii despre <?=$product_model["name"]?></h2>
    <div class="categ_description">
        <?=nl2br($product_model["description"])?>
    </div>
    <h2>Opinia cumparatorilor</h2>
    <? if ($reviews): ?>
    <div class="categ_description">
        <?php foreach ($reviews as $review): ?>
        <input class="star" type="radio" name="review_rating_ro[<?=$review["id"]?>]" value="1" <? if ($review["rating"] == 1) echo " checked=\"checked\""; ?> disabled="disabled"/>
        <input class="star" type="radio" name="review_rating_ro[<?=$review["id"]?>]" value="2" <? if ($review["rating"] == 2) echo " checked=\"checked\""; ?> disabled="disabled"/>
        <input class="star" type="radio" name="review_rating_ro[<?=$review["id"]?>]" value="3" <? if ($review["rating"] == 3) echo " checked=\"checked\""; ?> disabled="disabled"/>
        <input class="star" type="radio" name="review_rating_ro[<?=$review["id"]?>]" value="4" <? if ($review["rating"] == 4) echo " checked=\"checked\""; ?> disabled="disabled"/>
        <input class="star" type="radio" name="review_rating_ro[<?=$review["id"]?>]" value="5" <? if ($review["rating"] == 5) echo " checked=\"checked\""; ?> disabled="disabled"/>
        <?=$review["client_name"]?> a scris in data de <?=$review["date_added"]?>
        <?=nl2br($review["description"])?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($client_id > 0) : ?>
    <h2>Opinia ta:</h2>
    <form action="<?=site_url("products/add_review/".$product_model["id"])?>" method="post">
        <div class="categ_description">
            <input class="star" type="radio" name="review_rating" value="1" title="Worst"/>
            <input class="star" type="radio" name="review_rating" value="2" title="Bad"/>
            <input class="star" type="radio" name="review_rating" value="3" title="OK"/>
            <input class="star" type="radio" name="review_rating" value="4" title="Good"/>
            <input class="star" type="radio" name="review_rating" value="5" title="Best"/><br />
            <textarea rows="10" cols="40" name="review_desc"></textarea>
            <input type="submit" value="Trimite" />
        </div>
    </form>
    <? else : ?>
         <div class="categ_description">Inregistreaza-te pentru a trimite opinia ta!</div>
    <?php endif; ?>

    <div class="productBottomLink">
        <a href="<?=base_url()?>/contact">Mai multe detalii despre produs? Contacteaza-ne!</a>
        <!-- <a href="#">Opinia ta despre produs</a> -->
    </div>
</div>
<script>
    hs.graphicsDir = '<?php echo base_url(); ?>css/graphics/';
    hs.align = 'center';
    hs.transitions = ['expand', 'crossfade'];
    hs.outlineType = 'rounded-white';
    hs.fadeInOut = true;
    hs.numberPosition = 'caption';
    hs.dimmingOpacity = 0.75;
    if (hs.addSlideshow) hs.addSlideshow({
        //slideshowGroup: 'group1',
        interval: 5000,
        repeat: false,
        useControls: true,
        fixedControls: 'fit',
        overlayOptions: {
            opacity: .75,
            position: 'bottom center',
            hideOnMouseOut: true
        }
    });
    CKEDITOR.replace( 'review_desc' );
</script>