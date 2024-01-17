<?php 
require '../connect.php';
require _DIR_('library/session/user');

function gameMenu($x) {
    $out = '';
    for($i = 0; $i <= count($x)-1; $i++) {
        $cat = $x[$i];
        $img = 'https://i.pinimg.com/originals/5e/22/86/5e2286e02a8d3a65558ad3adf7534670.jpg';
        if($cat == 'Call of Duty Mobile') $img = 'https://cdn1.codashop.com/S/content/mobile/images/product-tiles/codmobile_tile.jpg';
        if($cat == 'Chess Rush') $img = 'https://cdn1.codashop.com/S/content/mobile/images/product-tiles/chessrush_tile.jpg';
        if($cat == 'Dragon Raja') $img = 'https://cdn1.codashop.com/S/content/mobile/images/product-tiles/dragonraja_tile.png';
        if($cat == 'Free Fire') $img = 'https://cdn1.codashop.com/S/content/mobile/images/product-tiles/freefire_tile.jpg';
        if($cat == 'HAGO') $img = 'https://cdn1.codashop.com/S/content/mobile/images/product-tiles/hago_tile.jpg';
        if($cat == 'Legends of Runeterra') $img = 'https://cdn1.codashop.com/S/content/mobile/images/product-tiles/lor_tile.jpg';
        if($cat == 'LifeAfter') $img = 'https://cdn1.codashop.com/S/content/mobile/images/product-tiles/lifeafter_tile.jpeg';
        if(substr($cat,0,13) == 'Mobile Legend') $img = 'https://cdn1.codashop.com/S/content/mobile/images/product-tiles/mlbb_tile.jpg';
        if($cat == 'UC PUBGM') $img = 'https://cdn1.codashop.com/S/content/mobile/images/product-tiles/pubgm_rps_tile.jpg';
        if($cat == 'PB Zepetto') $img = 'https://cdn1.codashop.com/S/content/mobile/images/product-tiles/PointBlank_ID_tile.jpg';
        if($cat == 'Ragnarok M Eternal Love') $img = 'https://cdn1.codashop.com/S/content/mobile/images/product-tiles/ragnarok_tile.jpg';
        if($cat == 'Speed Drifters') $img = 'https://cdn1.codashop.com/S/content/mobile/images/product-tiles/speed_drifter_tile.jpg';
        if($cat == 'Valorant') $img = 'https://cdn1.codashop.com/S/content/mobile/images/product-tiles/valorant_tile.jpg';
        if($cat == 'World of Dragon Nest') $img = 'https://cdn1.codashop.com/S/content/mobile/images/product-tiles/The_World_Of_Dragon_Nest.jpg';
        if($cat == 'Light of Thel') $img = 'https://cdn1.codashop.com/S/content/mobile/images/product-tiles/LightofThel_tile.png';
        if($cat == 'Netflix Premium') $img = assets('images/game/netflix.jpg');
        $out .= '<a href="javascript:;" onclick="javascript:location.href=\''.base_url('order/game/'.str_replace(' ','-',strtolower($cat))).'\'" class="category__product-container js-link-click"><img data-src="'.$img.'" alt="" class="category__product-image lozad" src="'.$img.'" data-loaded="true"><div class="category__product-title">'.$cat.'</div></a>';
    }
    return $out;
}

if(conf('xtra-fitur',2) <> 'true') exit(redirect(0,base_url()));
require _DIR_('library/layout/header.user');
?>
<style type="text/css">
    .category-container{max-width:760px;margin:2px auto 0}.category__product-row{display:block;max-width:100%;padding:0 5px 15px}.category__title{font-size:20px;font-family:Lato-Bold,sans-serif;padding-left:10px;padding-bottom:10px;text-transform:uppercase;color:#636363}*{box-sizing:border-box}@media only screen and (min-width:768px){.category__product-container{width:20%;padding:12px}}@media only screen and (max-width:768px){.category__product-container{width:25%;padding:12px;width:33.333333%}}.category__product-container{display:inline-block;text-align:center;text-decoration:none;cursor:pointer;padding:5px;vertical-align:top}.category__product-image{display:block;border-radius:15px;margin:auto;max-width:100%}.category__product-title{color:#636363;font-size:13px;padding-top:7px;max-width:128px;margin:auto}
</style>
<div class="category-container">
    <div class="category__product-row">
        <div class="category__title"></div>
        <?php
        $search = $call->query("SELECT * FROM category WHERE `order` = 'game' ORDER BY name ASC");
        while($row = $search->fetch_assoc()) { $x[] = $row['name']; }
        if(isset($x)) if(is_array($x)) print gameMenu($x);
        ?>
    </div>
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
<? require _DIR_('library/layout/footer.user'); ?>