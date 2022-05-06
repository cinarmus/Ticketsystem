<?php
if($label!="Login" && $label!="login" && $label!="Logout" && $label!="logout"){ ?>

<a href="<?=$url?>" data-role="button" data-icon="<?=$dataIcon?>" data-mini="true" data-iconpos="notext" class="ui-link ui-btn ui-icon-<?=$dataIcon?> ui-btn-icon-notext ui-shadow ui-corner-all ui-mini" data-ajax="false"></a> 

<?php }else{

if($label == "Login"|| $label == "login"){
    if($_SESSION['uid']==""){?> <a href="" data-role="button" id="loginbtn" data-icon="user" data-iconpos="left" class="ui-btn ui-icon-user  ui-btn-icon-left" data-ajax="false" style="border:none">Login</a><?php }
}elseif($label == "Logout" || $label == "logout"){
    if($_SESSION['uid']!=""){?><a href="?task=logout" data-role="button" data-icon="user" data-mini="true" data-iconpos="notext" class="ui-link ui-btn ui-icon-sign-out ui-btn-icon-notext ui-shadow ui-corner-all ui-mini" data-ajax="false" style="float:right;padding-top: 8.750px"></a><?php }
}}?>