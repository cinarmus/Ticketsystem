<?php
Core::checkAccessLevel(1);
Core::$title="Übersicht: StatusT";
Core::setView("StatusT_overview", "view1", "list");
Core::setViewScheme("view1", "list", "StatusT");
$StatusT_list=[];
$StatusT=new StatusT();
StatusT::$activeViewport="list";
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$StatusT_list=$StatusT->search(filter_input(INPUT_POST, "search"));
}else{
$StatusT_list=StatusT::findAll();
}
Core::publish($StatusT_list, "StatusT_list");
Core::publish($StatusT, "StatusT");
