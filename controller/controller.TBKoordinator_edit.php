<?php
$taskType = "edit";
$classSettings =TBKoordinator::$settings;
$access = Core::checkAccessGui($classSettings, $taskType);
Core::$title="Edit: TB-Koordinator";
$id=$_GET["id"];
Core::setView("TBKoordinator_edit", "view1", "edit");
Core::setViewScheme("view1", "edit", "TBKoordinator");
$TBKoordinator=new TBKoordinator();
TBKoordinator::$activeViewport="edit";
$TBKoordinator_list = TBKoordinator::findAll();
Core::publish($TBKoordinator_list, "TBKoordinator_list");
TBKoordinator::renderScript("edit","form_TBKoordinator");
$TBKoordinator->loadDBData($id);
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$a= $TBKoordinator->loadFormData();
if($a===true){
if($TBKoordinator->update()!="0"){
foreach($_FILES as $filekey => $file){
if($file["name"]!=""){
$TBKoordinator_field =TBKoordinator::$dataScheme[$filekey];
switch ($TBKoordinator_field["type"]){
case "picture":
$TBKoordinator->updateFile($filekey);
break;
case "file": // Hier müsste noch zwischen Bildern und  Dokumenten unterschieden werden
$parentField=TBKoordinator::$dataScheme[$TBKoordinator_field["sysParent"]];
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
$pfad = $TBKoordinator_field["sysParent"] . "_path"; // path wird nirgends ausgelesen sondern jetzt einfach mal so definiert
$filetypes=$parentField["filetypes"];
$TBKoordinator->updateFile($filekey, ["pathDB" => $pfad, "path"=>$ordner, "filestypes"=>$filetypes]);
break;
default:
}
}
}
core::redirect("TBKoordinator_detail&id=$id");
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
Core::publish($TBKoordinator, "TBKoordinator");
//Enumerationen
