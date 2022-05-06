<?php

if ($_POST["registrieren-ng"] != "1"){
$taskType = "new";
$classSettings =HSMitarbeiter::$settings;
$access = Core::checkAccessGui($classSettings, $taskType);
Core::$title="Neu: TB-Mitarbeiter";
Core::setView("TBMitarbeiter_new", "view1", "new");
Core::setViewScheme("view1", "new", "TBMitarbeiter");
}

if(isset($_GET["chain"])){
    $referrer = $_GET["chain"];
Core::publish($referrer, "referrer");
}
if(isset($_GET["autocomplete"])){
    $autocomplete = 1;
Core::publish($autocomplete, "autocomplete");
}

$TBMitarbeiter=new TBMitarbeiter();
TBMitarbeiter::$activeViewport="new";
TBMitarbeiter::renderScript("new","form_TBMitarbeiter");

if(count($_POST)>0){
$a= $TBMitarbeiter->loadFormData();
if($a===true){
if($TBMitarbeiter->create()!="0"){
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
default:
$ordner="files/";
}
$pfad = $TBMitarbeiter_field["sysParent"] . "_path"; // path wird nirgends ausgelesen sondern jetzt einfach mal so definiert
$filetypes=$parentField["filetypes"];
$TBMitarbeiter->updateFile($filekey, ["pathDB" => $pfad, "path"=>$ordner, "filestypes"=>$filetypes]);
break;
default:
}
}
}
$TBMitarbeiter=new TBMitarbeiter();
if(isset($_POST["back"])){
Core::loadJavascript("includes/js/back.js");
}else{
if ($_POST["registrieren-ng"] != "1"){ 
Core::$view->path["view1"]="views/view.TBMitarbeiter_new.php";
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
Core::publish($TBMitarbeiter, "TBMitarbeiter");
//Enumerationen
$Abteilung = AbteilungT::findAll();
Core::publish($Abteilung, 'Abteilung');
