my wishlist

<? if (isset($wishList)) : ?>
    <? foreach ($wishList as $k => $wl) : ?>
        <?=getProductTemplate(0, $wl["product"])?>
    <? endforeach; ?>
<? endif; ?>