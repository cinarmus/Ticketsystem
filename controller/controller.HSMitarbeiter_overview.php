<?php
$taskType = "list";
$classSettings =HSMitarbeiter::$settings;
$access = Core::checkAccessGui($classSettings, $taskType);
Core::publish($access, "access");
Core::$title="Übersicht: HS-Mitarbeiter";
Core::setView("HSMitarbeiter_overview", "view1", "list");
Core::setViewScheme("view1", "list", "HSMitarbeiter");
$HSMitarbeiter_list=[];
$HSMitarbeiter=new HSMitarbeiter();
HSMitarbeiter::$activeViewport="list";
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$HSMitarbeiter_list=$HSMitarbeiter->search(filter_input(INPUT_POST, "search"));
}else{
$HSMitarbeiter_list=HSMitarbeiter::findAll();
}
Core::publish($HSMitarbeiter_list, "HSMitarbeiter_list");
Core::publish($HSMitarbeiter, "HSMitarbeiter");
//Enumerationen
