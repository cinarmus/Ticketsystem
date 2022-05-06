<?php
Core::checkAccessLevel(1);
$id = $_GET["id"];
$_id=$_POST["_id"];
$Ticket_ticket_zuweisen_list = [];
Core::setView("TBKoordinator_handle_Ticket_ticket_zuweisen", "view1", "list");
Core::setViewScheme("view1", "list", "Ticket_ticket_zuweisen");
Ticket::$activeViewport="detail";
$Ticket_ticket_zuweisen_list = Ticket::findAll();
Core::publish($Ticket_ticket_zuweisen_list, "Ticket_ticket_zuweisen_list");
Core::publish($id, "id");
$Ticket = new Ticket();
Core::publish($Ticket, "Ticket");
if (isset($_id)) {
Ticket::$activeViewport="detail";
$Ticket->loadDBData($_id);
$Ticket->_TBKoordinator=$id;
$a=$Ticket->update();
if($a==true){
core::addMessage("Die Beziehung wurde erfolgreich gespeichert");
}else{
core::addError("Die Beziehung konnte leider nicht gespeichert werden");
}
}
