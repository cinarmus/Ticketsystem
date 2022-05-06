<?php $toggler=Core::import("toggler"); ?>

<div class="upperwrap <?=$toggler?>">
<div class="wrapper">
<div class="left">
    <img src="images/register.png" id="loginimg">
</div>
    
<div class="right">
<div class="ui-body ui-body-a" data-role="none">
<div data-role="tabs" id="tabs" data-theme="a">
    
<div data-role="navbar" data-theme="a">
<ul data-role="none">
<li class="login-form"><a href="#1" data-ajax="false" data-role="none">Login</a></li>
<li class="register-form"><a href="#2" data-ajax="false" data-role="none">Registrieren</a></li>
</ul>
</div>
    
<div id="1" class="ui-body-d ui-content" data-role="none">
<div id="view_Login">
<?php
Core::$view->render("view_login");
?>
</div>
</div>
    
<div id="2" class="ui-body-d ui-content" data-role="none">
<div id="view_Register">
<?php
Core::$view->render("view_user");
?>
</div>
</div>
    
</div>
</div>   

</div>  
</div>     
</div>