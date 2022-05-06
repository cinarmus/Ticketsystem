<?php
if($label!="Login" && $label!="login" && $label!="Logout" && $label!="logout"){ ?>

<a href="<?=$url?>" data-role="button" data-icon="<?=$dataIcon?>" data-mini="true" data-iconpos="notext" class="ui-link ui-btn ui-icon-<?=$dataIcon?> ui-btn-icon-notext ui-shadow ui-corner-all ui-mini" data-ajax="false"></a> 

<?php }else{

if($label == "Login"|| $label == "login"){
    if($_SESSION['uid']==""){?> <a href="?task=login" data-role="button" data-icon="user" data-mini="true" data-iconpos="notext" class="ui-link ui-btn ui-icon-user ui-btn-icon-notext ui-shadow ui-corner-all ui-mini" data-ajax="false"></a><?php }
}elseif($label == "Logout" || $label == "logout"){
    if($_SESSION['uid']!=""){?><a href="?task=logout" data-role="button" data-icon="user" data-mini="true" data-iconpos="notext" class="ui-link ui-btn ui-icon-sign-out ui-btn-icon-notext ui-shadow ui-corner-all ui-mini" data-ajax="false"></a><?php }
}}?>