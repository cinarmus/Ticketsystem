<?php
$taskType = "detail";
$classSettings =TBMitarbeiter::$settings;
$access = Core::checkAccessGui($classSettings, $taskType);
Core::publish($access, "access");
Core::$title="Detail: TB-Mitarbeiter";
Core::setView("TBMitarbeiter_detail", "view1", "detail");
Core::setViewScheme("view1", "detail", "TBMitarbeiter");
$TBMitarbeiter_list_2 = TBMitarbeiter::findAll();
Core::publish($TBMitarbeiter_list_2, "TBMitarbeiter_list_2");
$TBMitarbeiter_list=[];
$TBMitarbeiter=new TBMitarbeiter();
TBMitarbeiter::$activeViewport="detail";
$TBMitarbeiter->loadDBData($_GET["id"]);
Core::publish($TBMitarbeiter, "TBMitarbeiter");
//Beziehungen:
//Enumerationen
$Abteilung = AbteilungT::findAll();
Core::publish($Abteilung, 'Abteilung');
//to: Ticket  _zuteilen:
$Ticket_zuteilen=new Ticket();
$Ticket_zuteilen_list=[];
$Ticket_zuteilen_list = $Ticket_zuteilen->query(Ticket::SQL_SELECT_TBMitarbeiter, [$TBMitarbeiter->id]);
Core::publish($Ticket_zuteilen_list, "Ticket_zuteilen_list");
Core::publish($Ticket_zuteilen, "Ticket_zuteilen");
Core::$view->path["view_Ticket_zuteilen"]="views/view.Ticket_zuteilen_detail_overview.php";
//to: User _uid :
$User_uid=new User();
$User_uid_list=[];
$User_uid_list=$User_uid->query(User::SQL_SELECT_TBMitarbeiter_uid, [$TBMitarbeiter ->id]);
Core::publish($User_uid_list, "User_uid_list");
Core::publish($User_uid, "User_uid");
Core::$view->path["view_User_uid"]="views/view.User_uid_detail_overview.php";
