<?php
Core::checkAccessLevel(1);
$HSMitarbeiter_id=$_GET['id'];
$Ticket_list=[];
$Ticket=new Ticket();
Ticket::$activeViewport="detail";
$Ticket_list=Ticket::findAll();
Core::publish($Ticket, "Ticket");
Core::publish($HSMitarbeiter_id, "HSMitarbeiter_id");
Core::publish($Ticket_list, "Ticket_list");
$Ticket_HSMitarbeiter=new Ticket_HSMitarbeiter();
if(count($_POST)>2){
$a= $Ticket_HSMitarbeiter->loadFormData();
if($a===true){
if($Ticket_HSMitarbeiter->create()!="0"){
}else{
Core::addError("Der Datenbankeintrag war nicht erfolgreich");
}
}else{
Core::addError("Die Eingegebenen Daten waren nicht korrekt");
}
}
Core::setView("HSMitarbeiter_handle_Ticket_ticket_erstellen", "view1", "list");
