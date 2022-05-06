<?php
$taskType = "edit";
$classSettings =HSMitarbeiter::$settings;
$access = Core::checkAccessGui($classSettings, $taskType);
Core::$title="Edit: HS-Mitarbeiter";
$id=$_GET["id"];
Core::setView("HSMitarbeiter_edit", "view1", "edit");
Core::setViewScheme("view1", "edit", "HSMitarbeiter");
$HSMitarbeiter=new HSMitarbeiter();
HSMitarbeiter::$activeViewport="edit";
$HSMitarbeiter_list = HSMitarbeiter::findAll();
Core::publish($HSMitarbeiter_list, "HSMitarbeiter_list");
HSMitarbeiter::renderScript("edit","form_HSMitarbeiter");
$HSMitarbeiter->loadDBData($id);
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$a= $HSMitarbeiter->loadFormData();
if($a===true){
if($HSMitarbeiter->update()!="0"){
foreach($_FILES as $filekey => $file){
if($file["name"]!=""){
$HSMitarbeiter_field =HSMitarbeiter::$dataScheme[$filekey];
switch ($HSMitarbeiter_field["type"]){
case "picture":
$HSMitarbeiter->updateFile($filekey);
break;
case "file": // Hier müsste noch zwischen Bildern und  Dokumenten unterschieden werden
$parentField=HSMitarbeiter::$dataScheme[$HSMitarbeiter_field["sysParent"]];
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
$pfad = $HSMitarbeiter_field["sysParent"] . "_path"; // path wird nirgends ausgelesen sondern jetzt einfach mal so definiert
$filetypes=$parentField["filetypes"];
$HSMitarbeiter->updateFile($filekey, ["pathDB" => $pfad, "path"=>$ordner, "filestypes"=>$filetypes]);
break;
default:
}
}
}
core::redirect("HSMitarbeiter_detail&id=$id");
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
Core::publish($HSMitarbeiter, "HSMitarbeiter");
//Enumerationen
