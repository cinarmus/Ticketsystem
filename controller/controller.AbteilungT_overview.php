<?php
Core::checkAccessLevel(1);
Core::$title="Übersicht: AbteilungT";
Core::setView("AbteilungT_overview", "view1", "list");
Core::setViewScheme("view1", "list", "AbteilungT");
$AbteilungT_list=[];
$AbteilungT=new AbteilungT();
AbteilungT::$activeViewport="list";
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$AbteilungT_list=$AbteilungT->search(filter_input(INPUT_POST, "search"));
}else{
$AbteilungT_list=AbteilungT::findAll();
}
Core::publish($AbteilungT_list, "AbteilungT_list");
Core::publish($AbteilungT, "AbteilungT");
