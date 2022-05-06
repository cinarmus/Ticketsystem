<?php
$taskType = "edit";
$classSettings =TBMitarbeiter::$settings;
$access = Core::checkAccessGui($classSettings, $taskType);
Core::$title="Edit: TB-Mitarbeiter";
$id=$_GET["id"];
Core::setView("TBMitarbeiter_edit", "view1", "edit");
Core::setViewScheme("view1", "edit", "TBMitarbeiter");
$TBMitarbeiter=new TBMitarbeiter();
TBMitarbeiter::$activeViewport="edit";
$TBMitarbeiter_list = TBMitarbeiter::findAll();
Core::publish($TBMitarbeiter_list, "TBMitarbeiter_list");
TBMitarbeiter::renderScript("edit","form_TBMitarbeiter");
$TBMitarbeiter->loadDBData($id);
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$a= $TBMitarbeiter->loadFormData();
if($a===true){
if($TBMitarbeiter->update()!="0"){
foreach($_FILES as $filekey => $file){
if($file["name"]!=""){
$TBMitarbeiter_field =TBMitarbeiter::$dataScheme[$filekey];
switch ($TBMitarbeiter_field["type"]){
case "picture":
$TBMitarbeiter->updateFile($filekey);
break;
case "file": // Hier müsste noch zwischen Bildern und  Dokumenten unterschieden werden
$parentField=TBMitarbeiter::$dataScheme[$TBMitarbeiter_field["sysParent"]];
$filetype=$parentField["type"];
switch($filetype){
case "pictureT":
$ordner="images/";
break;
case "fileT":
$ordner="files/";
break;
default:;
$ordner="files/";;
};
$pfad = $TBMitarbeiter_field["sysParent"] . "_path"; // path wird nirgends ausgelesen sondern jetzt einfach mal so definiert
$filetypes=$parentField["filetypes"];
$TBMitarbeiter->updateFile($filekey, ["pathDB" => $pfad, "path"=>$ordner, "filestypes"=>$filetypes]);
break;
default:
}
}
}
core::redirect("TBMitarbeiter_detail&id=$id");
}else{
Core::addError("Der Datenbankeintrag war nicht erfolgreich"); 
}
}else{
Core::addError("Die Eingegebenen Daten waren nicht korrekt");
}
if (isset($_GET['task_source'])) {
if ($_GET['task_source'] == "login" or $_GET['task_source'] == "user_register") {
core::redirect("login");
}
}
}
$_User_uid = User::findAll();
Core::publish($_User_uid, "_User_uid");
Core::publish($TBMitarbeiter, "TBMitarbeiter");
//Enumerationen
$Abteilung = AbteilungT::findAll();
Core::publish($Abteilung, 'Abteilung');
