<?php
$taskType = "detail";
$classSettings =TBKoordinator::$settings;
$access = Core::checkAccessGui($classSettings, $taskType);
Core::publish($access, "access");
Core::$title="Detail: TB-Koordinator";
Core::setView("TBKoordinator_detail", "view1", "detail");
Core::setViewScheme("view1", "detail", "TBKoordinator");
$TBKoordinator_list_2 = TBKoordinator::findAll();
Core::publish($TBKoordinator_list_2, "TBKoordinator_list_2");
$TBKoordinator_list=[];
$TBKoordinator=new TBKoordinator();
TBKoordinator::$activeViewport="detail";
$TBKoordinator->loadDBData($_GET["id"]);
Core::publish($TBKoordinator, "TBKoordinator");
//Beziehungen:
//Enumerationen
//to: Ticket  _ticket_zuweisen:
$Ticket_ticket_zuweisen=new Ticket();
$Ticket_ticket_zuweisen_list=[];
$Ticket_ticket_zuweisen_list = $Ticket_ticket_zuweisen->query(Ticket::SQL_SELECT_TBKoordinator, [$TBKoordinator->id]);
Core::publish($Ticket_ticket_zuweisen_list, "Ticket_ticket_zuweisen_list");
Core::publish($Ticket_ticket_zuweisen, "Ticket_ticket_zuweisen");
Core::$view->path["view_Ticket_ticket_zuweisen"]="views/view.Ticket_ticket_zuweisen_detail_overview.php";
//to: User _uid :
$User_uid=new User();
$User_uid_list=[];
$User_uid_list=$User_uid->query(User::SQL_SELECT_TBKoordinator_uid, [$TBKoordinator ->id]);
Core::publish($User_uid_list, "User_uid_list");
Core::publish($User_uid, "User_uid");
Core::$view->path["view_User_uid"]="views/view.User_uid_detail_overview.php";
