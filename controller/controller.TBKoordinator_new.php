<?php

if ($_POST["registrieren-ng"] != "1"){
$taskType = "new";
$classSettings =HSMitarbeiter::$settings;
$access = Core::checkAccessGui($classSettings, $taskType);
Core::$title="Neu: TB-Koordinator";
Core::setView("TBKoordinator_new", "view1", "new");
Core::setViewScheme("view1", "new", "TBKoordinator");
}

if(isset($_GET["chain"])){
    $referrer = $_GET["chain"];
Core::publish($referrer, "referrer");
}
if(isset($_GET["autocomplete"])){
    $autocomplete = 1;
Core::publish($autocomplete, "autocomplete");
}

$TBKoordinator=new TBKoordinator();
TBKoordinator::$activeViewport="new";
TBKoordinator::renderScript("new","form_TBKoordinator");

if(count($_POST)>0){
$a= $TBKoordinator->loadFormData();
if($a===true){
if($TBKoordinator->create()!="0"){
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
default:
$ordner="files/";
}
$pfad = $TBKoordinator_field["sysParent"] . "_path"; // path wird nirgends ausgelesen sondern jetzt einfach mal so definiert
$filetypes=$parentField["filetypes"];
$TBKoordinator->updateFile($filekey, ["pathDB" => $pfad, "path"=>$ordner, "filestypes"=>$filetypes]);
break;
default:
}
}
}
$TBKoordinator=new TBKoordinator();
if(isset($_POST["back"])){
Core::loadJavascript("includes/js/back.js");
}else{
if ($_POST["registrieren-ng"] != "1"){ 
Core::$view->path["view1"]="views/view.TBKoordinator_new.php";
}else{
   $task_source = $_GET["task_source"];
   $array["register"] = "true";
   Core::redirect ($task_source, $array);
}}
}else{
Core::addError("Der Datenbankeintrag war nicht erfolgreich"); 
}
}else{
Core::addError("Die Eingegebenen Daten waren nicht korrekt");
}
}
$_User_uid = User::findAll(User::SQL_SELECT_IGNORE_DERIVED);
Core::publish($_User_uid, "_User_uid");
Core::publish($TBKoordinator, "TBKoordinator");
//Enumerationen
