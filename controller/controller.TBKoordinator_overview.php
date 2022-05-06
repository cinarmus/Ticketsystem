<?php
$taskType = "list";
$classSettings =TBKoordinator::$settings;
$access = Core::checkAccessGui($classSettings, $taskType);
Core::publish($access, "access");
Core::$title="Übersicht: TB-Koordinator";
Core::setView("TBKoordinator_overview", "view1", "list");
Core::setViewScheme("view1", "list", "TBKoordinator");
$TBKoordinator_list=[];
$TBKoordinator=new TBKoordinator();
TBKoordinator::$activeViewport="list";
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$TBKoordinator_list=$TBKoordinator->search(filter_input(INPUT_POST, "search"));
}else{
$TBKoordinator_list=TBKoordinator::findAll();
}
Core::publish($TBKoordinator_list, "TBKoordinator_list");
Core::publish($TBKoordinator, "TBKoordinator");
//Enumerationen
