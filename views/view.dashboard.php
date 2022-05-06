<?php 
$test="test";
$menu=Core::import("menu");
$class=Core::import("class");
$menuItems=Core::import("menuItems");
$menuLeadingItems=Core::import("menuLeadingItems");
$image=Core::import("image");
?>

<div class="hometitle">
    <?=$image?>
  <span style="font-size: 40px; background-color: #FFFFFF; padding: 0 20px;">
    <?=$menu["heading"];?>
  </span>
</div>
<div>
  <p class="homesubtitle nD"><?=$menu["text"];?></p>  
</div>



<ol class="<?=$class?> articles lI">
<?php
if(array_key_exists(0, $menuLeadingItems)){
  foreach($menuLeadingItems as $key => $item){
    Menu::showMenuItem($item,$key, "dashboardMenu");
  }  
}
?>
</ol>
    

<ol class="<?=$class?> articles fI" style="grid-template-columns:repeat(<?=$menu["columns"];?>,1fr)">
<?php
if(isset($menuItems)){
  foreach($menuItems as $key => $item){
    Menu::showMenuItem($item,$key, "dashboardMenu");
  }  
}
?>
</ol>