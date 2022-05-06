<?php
Core::checkAccessLevel(1);
$id = $_GET["id"];
$_id=$_POST["_id"];
$Ticket_zuteilen_list = [];
Core::setView("TBMitarbeiter_handle_Ticket_zuteilen", "view1", "list");
Core::setViewScheme("view1", "list", "Ticket_zuteilen");
Ticket::$activeViewport="detail";
$Ticket_zuteilen_list = Ticket::findAll();
Core::publish($Ticket_zuteilen_list, "Ticket_zuteilen_list");
Core::publish($id, "id");
$Ticket = new Ticket();
Core::publish($Ticket, "Ticket");
if (isset($_id)) {
Ticket::$activeViewport="detail";
$Ticket->loadDBData($_id);
$Ticket->_TBMitarbeiter=$id;
$a=$Ticket->update();
if($a==true){
core::addMessage("Die Beziehung wurde erfolgreich gespeichert");
}else{
core::addError("Die Beziehung konnte leider nicht gespeichert werden");
}
}
