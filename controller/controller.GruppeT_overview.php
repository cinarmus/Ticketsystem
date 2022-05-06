<?php
Core::checkAccessLevel(1);
Core::$title="Übersicht: GruppeT";
Core::setView("GruppeT_overview", "view1", "list");
Core::setViewScheme("view1", "list", "GruppeT");
$GruppeT_list=[];
$GruppeT=new GruppeT();
GruppeT::$activeViewport="list";
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$GruppeT_list=$GruppeT->search(filter_input(INPUT_POST, "search"));
}else{
$GruppeT_list=GruppeT::findAll();
}
Core::publish($GruppeT_list, "GruppeT_list");
Core::publish($GruppeT, "GruppeT");
