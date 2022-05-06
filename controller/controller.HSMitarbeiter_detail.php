<?php
$taskType = "detail";
$classSettings =HSMitarbeiter::$settings;
$access = Core::checkAccessGui($classSettings, $taskType);
Core::publish($access, "access");
Core::$title="Detail: HS-Mitarbeiter";
Core::setView("HSMitarbeiter_detail", "view1", "detail");
Core::setViewScheme("view1", "detail", "HSMitarbeiter");
$HSMitarbeiter_list_2 = HSMitarbeiter::findAll();
Core::publish($HSMitarbeiter_list_2, "HSMitarbeiter_list_2");
$HSMitarbeiter_list=[];
$HSMitarbeiter=new HSMitarbeiter();
HSMitarbeiter::$activeViewport="detail";
$HSMitarbeiter->loadDBData($_GET["id"]);
Core::publish($HSMitarbeiter, "HSMitarbeiter");
//Beziehungen:
//Enumerationen
//to: Ticket  _ticket_erstellen:
$Ticket_ticket_erstellen=new Ticket();
$Ticket_ticket_erstellen_list=[];
$Ticket_ticket_erstellen_list = $Ticket_ticket_erstellen->query(Ticket::SQL_SELECT_HSMitarbeiter_b, [$HSMitarbeiter->id]);
Core::publish($Ticket_ticket_erstellen_list, "Ticket_ticket_erstellen_list");
Core::publish($Ticket_ticket_erstellen, "Ticket_ticket_erstellen");
Core::$view->path["view_Ticket_ticket_erstellen"]="views/view.Ticket_ticket_erstellen_detail_overview.php";
//to: User _uid :
$User_uid=new User();
$User_uid_list=[];
$User_uid_list=$User_uid->query(User::SQL_SELECT_HSMitarbeiter_uid, [$HSMitarbeiter ->id]);
Core::publish($User_uid_list, "User_uid_list");
Core::publish($User_uid, "User_uid");
Core::$view->path["view_User_uid"]="views/view.User_uid_detail_overview.php";
