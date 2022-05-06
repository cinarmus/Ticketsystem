<?php
if(!isset($menuKey)){
$menuKey= filter_input(INPUT_GET, "menu");

if($menuKey == "home"){
    require "controller.home.php";
}
}

$userCode = Core::$user->Gruppe;
$menu = [];


$allMenu=[];
$allMenu= Menu::$item;


foreach ($allMenu as $item){
    foreach($item as $itemElement){
        $userItem=[];
        $generalItem=[];
    $userItem = $itemElement['group']['G'.$userCode];
    $generalItem = $itemElement['group']['general']; 
    if($userItem['display'] != "false" || $generalItem["link"] == "home"){       
         $keys = [];
         $keys = array_keys($generalItem);        
         foreach($keys as $index){
           if($userItem[$index] != ""){
               $menuItem[$index] = $userItem[$index];
           }else{
               $menuItem[$index] = $generalItem[$index];
           }
         }
            if($menuItem['link']==$menuKey){
            $menu = $menuItem;
            }
            $menuItem = [];
      }
}
}

if($menuKey != "home"){
Core::$title=$menu['label'];    
}

if($menu["columns"] == ""){
    $menu["columns"] = 2;
}

if($menu["image"] != ""){
  $image = '<div class="imgheader">
<img src="images/'.$menu["image"].'" style="width:100%"></div>';
}

$menuItems=Array();
$menuLeadingItems=Array();
foreach(Menu::$item as $item){
    if(isset($item['dashboardElement'])){  
    $userItem = $item['dashboardElement']['group']['G'.$userCode];
    $generalItem = $item['dashboardElement']['group']['general'];
    $dE = [];
     
     if($userItem['display'] != "false"){       
         $keys = [];
         $keys = array_keys($generalItem);        
         foreach($keys as $index){
           if($userItem[$index] != ""){
               $dE[$index] = $userItem[$index];
           }else{
               $dE[$index] = $generalItem[$index];
           }
         }
         //Abfragen der generellen Klasseneinstellungen und ggf. ersetzen, falls spezifische ManuItem Einstellungen leer sind
         $setName = $dE['link'];
         $arr = explode("_", $setName, 2);
         $setName = $arr[0];
         if(strpos($setName, "user") !== false){
             $setName = "User";
         }
         if(class_exists($setName)){
         $set = $setName::$settings;
         if($dE['image'] == "" || $dE['image'] == "placeholder.png"){
             if($set['general']['image'] != ""){
             $dE['image'] = $set['general']['image'];
         }}
         if($dE['label'] == ""){
             if($set['general']['label'] != ""){
             $dE['label'] = $set['general']['label'];
         }}
         if($dE['description'] == ""){
             $dE['description'] = $set['general']['description'];
         }}
         
         if($dE["menu"]==$menuKey){
            if($dE["leadingItem"]===true || $dE["leadingItem"]=="true"){
            $dE["renderAs"]="dashboardItem";
             array_push($menuLeadingItems,$dE);
         }else{
            $dE["renderAs"]="dashboardItem";
            array_push($menuItems,$dE);
            }
         }
     }
    }
}

Core::publish($class, "class");
Core::publish($menu, "menu");
Core::publish($menuItems, "menuItems");
Core::publish($menuLeadingItems, "menuLeadingItems");
Core::publish($image, "image");


if($menuKey != "home"){
Core::setView("dashboard", "view1", "detail");
}
