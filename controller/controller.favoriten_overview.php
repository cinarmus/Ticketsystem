<?php
$Favoriten=new Favoriten();
$Favoriten_list=[];
$Favoriten_list=Favoriten::findAll(Favoriten::SQL_SELECT_ALL,[$_SESSION['uid']]);
Core::publish($Favoriten_list, "Favoriten_list");
Core::publish($Favoriten, "Favoriten");

Core::$title = "Meine Favoriten";
Core::setView("favoriten", "view1");