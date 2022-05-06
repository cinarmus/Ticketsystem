<?php
$case = $menu;
if($case=="panelMenu"){ ?>
<button class="dropdown" data-icon="carat-d" data-mini="true"><?=$label?></button>
<div class="dropdown-container">
<?php }elseif($case=="headerMenu"){ ?>
<a data-role="button" class="ui-btn ui-shadow ui-corner-all dropdown-btn ui-icon-carat-d ui-btn-icon-left dropdown" data-icon="carat-d" data-ajax="false" style="color:white"><?=$label?></a>
<div class="dropdown-content">    

<?php
}

$menuKey = $link;
$dropdownItems = [];
$userCode = Core::$user->Gruppe;

foreach(Menu::$item as $item){
    if(isset($item['dropdownElement'])){
    $userItem = $item['dropdownElement']['group']['G'.$userCode];
    $generalItem = $item['dropdownElement']['group']['general'];
    $ddI = [];       
        
    if($userItem['display'] != "false"){       
       $keys = [];
       $keys = array_keys($generalItem);        
       foreach($keys as $index){
           if($userItem[$index] != ""){
               $ddI[$index] = $userItem[$index];
           }else{
               $ddI[$index] = $generalItem[$index];
           }
        }
        if($ddI["menu"]==$menuKey){
         if($ddI['linkFunction']=="task"){
            $ddI['url'] = '?task='.$ddI['link'].'"';
         }elseif($ddI['linkFunction']=="URL"){
            $ddI['url'] = $ddI['link']; 
         }
         array_push($dropdownItems,$ddI);
}}}}

foreach($dropdownItems as $item){
if($case=="panelMenu"){ ?>
<a href="<?=$item['url']?>" data-role="button" data-mini="true" data-icon="<?=$item['icon']?>"><?=$item['label']?></a>  
<?php }elseif($case=="headerMenu"){ ?>
<a href="<?=$item['url']?>" data-role="button" data-mini="true" data-icon="<?=$item['icon']?>" class="ui-link ui-btn ui-icon-<?=$item['icon']?> ui-btn-icon-left ui-shadow ui-corner-all ui-mini" style="position:absolute;top:40px;"><?=$item['label']?></a>
<?php }} ?>

</div>