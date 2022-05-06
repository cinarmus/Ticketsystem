<?php
//$user = new User;
$title = Core::$title;
Core::publish($title, "title");

//Startseiten Dashboard:
$menuKey = "home";
require "controller.dashboard.php";    

//Startseite render Zusatzinfo:
if (Core::$user->id==""){
$title = Core::$title;
Core::publish($title, "title");   
}else{
}

Core::setView("home", "view1");
Core::$title = "Home";
