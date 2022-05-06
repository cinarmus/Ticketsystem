<?php
Core::checkAccessLevel(1);
Core::$title="Übersicht: PrioritätT";
Core::setView("PrioritätT_overview", "view1", "list");
Core::setViewScheme("view1", "list", "PrioritätT");
$PrioritätT_list=[];
$PrioritätT=new PrioritätT();
PrioritätT::$activeViewport="list";
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$PrioritätT_list=$PrioritätT->search(filter_input(INPUT_POST, "search"));
}else{
$PrioritätT_list=PrioritätT::findAll();
}
Core::publish($PrioritätT_list, "PrioritätT_list");
Core::publish($PrioritätT, "PrioritätT");
