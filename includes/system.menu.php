<?php
/*  @var $help HelperClass */

/**
 * EnthÃ¤lt alle Kontrollelemente
 * @version 1.0 
 * @author Markus Nippa<markus.nippa@hs-pforzheim.de.com>
 */
class Menu {
    
   public static $menu; 
   public static function loadMenu($path="models/json/Menu.json"){
   self::$menu = json_decode(file_get_contents($path), true);
   }
   
   public static $item; 
   public static function loadMenuItem($path="models/json/MenuItem.json"){
   self::$item = json_decode(file_get_contents($path), true);
   }
   
public static function showModule($menu=""){
       switch($menu):
           case "panelMenu":
               $panel = self::$menu["panelMenu"];
               $heading = $panel["heading"];
               $text = $panel["text"];
               $theme = $panel["theme"];
               $position = $panel["panelPosition"];
               $display = $panel["display"];
               $appearance = $panel["appearance"];
               break;
           case "footerMenu":
               $footer = self::$menu["footerMenu"];
               $theme = $footer["theme"];
               $text = $footer["text"];
               $textLink = $footer["textLink"];
               $textLinkFunction = $footer["textLinkFunction"];
               $iconPosition = $footer["iconPosition"];
               $display = $footer["display"];
               $fixed = $footer["fixedFooter"];
               break;
           case "headerMenu":
               $header = self::$menu["headerMenu"];
               $theme = $header["theme"];
               $text = $header["text"];
               $textLink = $header["textLink"];
               $textLinkFunction = $header["textLinkFunction"];
               $type = $header["type"];
               $display = $header["display"];
               break;
           default:  
       endswitch;
    require("includes/navigation/".$menu.".php");
}
   
  Public static function showMenu($menu="panelMenu"){  //hier könnte also noch sortiert werden
       foreach (self::$item as $key => $item){
           $short = substr($menu,0,-4);
           if(isset($item[$short."Element"])){
               $case = $item[$short."Element"];
               self::showMenuItem($case, $key, $menu);
}}}
   
   public static function showMenuItem($menuItem=array(),$key, $menu="panelMenu"){
     
     if($menu == "dashboardMenu" || $menu == "footerMenu"){
      $renderAs= $menuItem["renderAs"];
      $label=$menuItem["label"];
      $class=$menuItem["class"];
      $dataIcon= $menuItem["icon"]  ;
      $image= $menuItem["image"]  ;
      $description= $menuItem["description"];
      $theme= $menuItem["theme"];
      $link= $menuItem["link"];
         switch($menuItem["linkFunction"]){
           case "task":
              $url="?task=".$link;
               break;
                case "URL":
                   $url=$link;
               break;
           case "dashboard":
               $url ="?task=dashboard&menu=".$link;
               break;
           default: $url="?task=".$link;
       }
        include("includes/navigation/". $renderAs.".php");
     }else{
       

     $userCode = Core::$user->Gruppe;
     $userItem = $menuItem['group']['G'.$userCode];
     $generalItem = $menuItem['group']['general'];
     unset($menuItem['group']);
     
     if($userItem['display'] != "false"){
         
         $keys = [];
         $keys = array_keys($generalItem);
         
         foreach($keys as $index){
           if($userItem[$index] != ""){
               $menuItem[$index] = $userItem[$index];
           }else{
               $menuItem[$index] = $generalItem[$index];
           }
         }
      //Abfragen der generellen Klasseneinstellungen und ggf. ersetzen, falls spezifische ManuItem Einstellungen leer sind   
         $setName = $menuItem['link'];
         $arr = explode("_", $setName, 2);
         $setName = $arr[0];
         if(strpos($setName, "user") !== false){
             $setName = "User";
         }
         if(class_exists(ucfirst($setName))){
         $set = $setName::$settings;
         if($menuItem['icon'] == "" || $menuItem['icon'] == "bars"){
             if($set['general']['icon'] != ""){
             $menuItem['icon'] = $set['general']['icon'];
         }}
         if($menuItem['label'] == ""){
             if($set['general']['label'] != ""){
             $menuItem['label'] = $set['general']['label'];
         }}
         }   
      $renderAs= $menuItem["renderAs"];
      $label=$menuItem["label"];
      $class=$menuItem["class"];
      $dataIcon= $menuItem["icon"]  ;
      $image= $menuItem["image"]  ;
      $description= $menuItem["description"];
      $theme= $menuItem["theme"];
      $link= $menuItem["link"];
         switch($menuItem["linkFunction"]){
           case "task":
              $url="?task=".$link;
               break;
                case "URL":
                   $url=$link;
               break;
           case "dashboard":
               $url ="?task=dashboard&menu=".$link;
               break;
           default: $url="?task=".$link;
       }
       include("includes/navigation/". $renderAs.".php");
     }     
   }
}


}

Menu::loadMenu();
Menu::loadMenuItem();