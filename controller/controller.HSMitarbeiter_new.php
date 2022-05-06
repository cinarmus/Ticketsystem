<?php

if ($_POST["registrieren-ng"] != "1"){
$taskType = "new";
$classSettings =HSMitarbeiter::$settings;
$access = Core::checkAccessGui($classSettings, $taskType);
Core::$title="Neu: HS-Mitarbeiter";
Core::setView("HSMitarbeiter_new", "view1", "new");
Core::setViewScheme("view1", "new", "HSMitarbeiter");
}

if(isset($_GET["chain"])){
    $referrer = $_GET["chain"];
Core::publish($referrer, "referrer");
}
if(isset($_GET["autocomplete"])){
    $autocomplete = 1;
Core::publish($autocomplete, "autocomplete");
}

$HSMitarbeiter=new HSMitarbeiter();
HSMitarbeiter::$activeViewport="new";
HSMitarbeiter::renderScript("new","form_HSMitarbeiter");

if(count($_POST)>0){
$a= $HSMitarbeiter->loadFormData();
if($a===true){
if($HSMitarbeiter->create()!="0"){
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
default:
$ordner="files/";
}
$pfad = $HSMitarbeiter_field["sysParent"] . "_path"; // path wird nirgends ausgelesen sondern jetzt einfach mal so definiert
$filetypes=$parentField["filetypes"];
$HSMitarbeiter->updateFile($filekey, ["pathDB" => $pfad, "path"=>$ordner, "filestypes"=>$filetypes]);
break;
default:
}
}
}
$HSMitarbeiter=new HSMitarbeiter();
if(isset($_POST["back"])){
Core::loadJavascript("includes/js/back.js");
}else{
if ($_POST["registrieren-ng"] != "1"){ 
Core::$view->path["view1"]="views/view.HSMitarbeiter_new.php";
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
Core::publish($HSMitarbeiter, "HSMitarbeiter");
//Enumerationen
