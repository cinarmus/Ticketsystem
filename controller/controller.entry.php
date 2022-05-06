<?php
//Login  :
require "controller.login.php";

//Register :
require "controller.user_register.php";
//Aus dem else-Teil einzelnen Controllern rausgenommen und hier übergreifend eingefügt
if (isset($_POST)) {
$gruppe = new gruppet;
$gruppenliste = $gruppe->findAll();
Core::publish($user, "user");
Core::publish($gruppenliste, "Gruppe");
}

//Prüft, ob man von einer Nutzerregistrierung kommt,
//falls ja muss man sich noch einloggen und der Container wird angezeigt - ansonsten wird der Container nicht angezeigt
if(isset($_GET["register"])){
    $toggler = "";
}else{
    $toggler = "toggler";
}

Core::publish($toggler, "toggler");
Core::setView("entry", "view_entry");