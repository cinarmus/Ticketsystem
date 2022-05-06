<?php
$taskType = "list";
$classSettings =TBMitarbeiter::$settings;
$access = Core::checkAccessGui($classSettings, $taskType);
Core::publish($access, "access");
Core::$title="Übersicht: TB-Mitarbeiter";
Core::setView("TBMitarbeiter_overview", "view1", "list");
Core::setViewScheme("view1", "list", "TBMitarbeiter");
$TBMitarbeiter_list=[];
$TBMitarbeiter=new TBMitarbeiter();
TBMitarbeiter::$activeViewport="list";
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$TBMitarbeiter_list=$TBMitarbeiter->search(filter_input(INPUT_POST, "search"));
}else{
$TBMitarbeiter_list=TBMitarbeiter::findAll();
}
Core::publish($TBMitarbeiter_list, "TBMitarbeiter_list");
Core::publish($TBMitarbeiter, "TBMitarbeiter");
//Enumerationen
$Abteilung = AbteilungT::findAll();
Core::publish($Abteilung, 'Abteilung');
