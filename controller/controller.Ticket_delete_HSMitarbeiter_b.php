<?php
Core::checkAccessLevel(1);
if(isset($_GET["id"])){
$back=$_GET["back"];
$schlüssel=$_GET["id"];
$muss=$_GET["muss"];
if($muss=="true"){
$partner=new Ticket_HSMitarbeiter();
$partnerSQL="Select * from Ticket_HSMitarbeiter where _Ticket_ticket_erstellen=$back";
$count = count($partner->findAll($partnerSQL));
if($count>1){
$do=true;
}else{
$do=false;
}
}else{
$do=true;
}
if($do===true){
$Ticket_HSMitarbeiter=new Ticket_HSMitarbeiter();
$result=$Ticket_HSMitarbeiter->delete($schlüssel);
if($result){
Core::redirect("Ticket_detail&id=$back", ["message"=>"Beziehung wurde erfolgreich entfernt"]);
}else{
Core::redirect("Ticket_detail&id=$back", ["message"=>"Beziehung konnte nicht gelöscht werden"]);
}
}else{
Core::redirect("Ticket_detail&id=$back", ["message"=>"Das letzte Partnerobjekt kann nicht gelöscht werden"]);
}
}else{
Core::addError("Beziehung konnte nicht gelöscht werden");
}
