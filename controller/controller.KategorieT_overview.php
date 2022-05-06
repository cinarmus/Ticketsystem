<?php
Core::checkAccessLevel(1);
Core::$title="Übersicht: KategorieT";
Core::setView("KategorieT_overview", "view1", "list");
Core::setViewScheme("view1", "list", "KategorieT");
$KategorieT_list=[];
$KategorieT=new KategorieT();
KategorieT::$activeViewport="list";
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$KategorieT_list=$KategorieT->search(filter_input(INPUT_POST, "search"));
}else{
$KategorieT_list=KategorieT::findAll();
}
Core::publish($KategorieT_list, "KategorieT_list");
Core::publish($KategorieT, "KategorieT");
