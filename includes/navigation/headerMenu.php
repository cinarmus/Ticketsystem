 <div data-role="header" id="header" data-position="fixed" class="ui-header ui-bar-inherit ui-header-fixed slidedown ui-fixed-hidden">
    
  
    <div id="menu">

       	  <a href="#menupanel" data-role="button" data-icon="bars" data-mini="true" data-iconpos="notext" data-inline="true" class="ui-link ui-btn ui-icon-bars ui-btn-icon-notext ui-btn-inline ui-shadow ui-corner-all ui-mini"></a>

          <span id="menuText"><?php 
         echo "".core::$title ;
         if (core::$user->Kennung!=""){
             ?> 
          <?php
         echo " |<small> ".core::$user->Kennung." "."(".core::$user->Gruppe_literal.")</small>";
         }?></span>
    </div>

    <div id="logo" ></div>

     <div id="search">   
   <?php
Menu::showMenu($menu);
?>
      </div>
    
<div id="headerlogo" ></div>  
   
</div>

