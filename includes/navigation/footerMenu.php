<div data-role="footer" id="footer" data-position="<?php if($fixed == "true"){echo("fixed");}?>" data-tap-toggle="false">
    
    
<?php if($text!=""){?>
<h4 style="text-align:center;color:white">
<?php if($textLink!=""){?><a href="<?=$textLink?>" id="footerLink"><?=$text?></a><?php }?>
<?php if($textLink==""){?><?=$text?><?php }?>
</h4>
<?php }?>
  
<?php
$userCode = Core::$user->Gruppe;
$buttonItems=Array();
$iconItems=Array();
$menu = "footerMenu";
foreach(Menu::$item as $item){
    if(isset($item['footerElement'])){  
    $userItem = $item['footerElement']['group']['G'.$userCode];
    $generalItem = $item['footerElement']['group']['general'];
    $fE = [];
     
     if($userItem['display'] != "false"){       
         $keys = [];
         $keys = array_keys($generalItem);        
         foreach($keys as $index){
           if($userItem[$index] != ""){
               $fE[$index] = $userItem[$index];
           }else{
               $fE[$index] = $generalItem[$index];
           }
         }
        if($fE["renderAs"] == "footerIcon"){
          array_push($iconItems,$fE);
         } elseif ($fE["renderAs"] == "footerButton") {
            array_push($buttonItems,$fE);
            }
     }
    }
}

if(!empty($buttonItems)){ ?>
<div data-role="navbar" data-iconpos="<?=$iconPosition?>" data-display="<?=$display?>" style="padding-bottom:15px;text-align:center">
<ul>
<?php foreach($buttonItems as $item){
    $key = $item['label'];
    $menu = "footerMenu";
Menu::showMenuItem($item, $key, $menu); }?>        
</ul>
</div>
<?php }
if(!empty($iconItems)){
    foreach($iconItems as $item){
    $key = $item['label'];
    $menu = "footerMenu";
    Menu::showMenuItem($item, $key, $menu);
    }
}
?>
    
</div>