<?php
$taskType = "delete";
$classSettings =HSMitarbeiter::$settings;
Core::checkAccessGui($classSettings, $taskType);
if(isset($_GET['id'])){
$result=HSMitarbeiter::delete(filter_input(INPUT_GET, "id"));
if($result){
Core::redirect("HSMitarbeiter", ["message"=>"Löschvorgang erfolgreich"]);
}else{
Core::addError("Der Datensatz konnte nicht gelöscht werden");
}
}else{
Core::addError("Der Datensatz konnte nicht gelöscht werden");
}
