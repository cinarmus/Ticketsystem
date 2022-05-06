<?php
Core::checkAccessLevel(1);
Core::$title="Neu: StatusT";
Core::setView("StatusT_new", "view1", "new");
Core::setViewScheme("view1", "new", "StatusT");
$StatusT=new StatusT();
StatusT::$activeViewport="new";
$StatusT_list = StatusT::findAll();
Core::publish($StatusT_list, "StatusT_list");
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$a= $StatusT->loadFormData();
if($a===true){
if($StatusT->create()!="0"){
foreach($_FILES as $filekey => $file){
if($file["name"]!=""){
$StatusT_field =StatusT::$dataScheme[$filekey];
switch ($StatusT_field["type"]){
case "picture":
$StatusT->updateFile($filekey);
break;
case "file": // Hier müsste noch zwischen Bildern und  Dokumenten unterschieden werden
$parentField=StatusT::$dataScheme[$StatusT_field["sysParent"]];
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
$pfad = $StatusT_field["sysParent"] . "_path"; // path wird nirgends ausgelesen sondern jetzt einfach mal so definiert
$filetypes=$parentField["filetypes"];
$StatusT->updateFile($filekey, ["pathDB" => $pfad, "path"=>$ordner, "filestypes"=>$filetypes]);
break;
default:
}
}
}
$StatusT=new StatusT();
Core::$view->path["view1"]="views/view.StatusT_new.php";
}else{
Core::addError("Der Datenbankeintrag war nicht erfolgreich"); 
}
}else{
Core::addError("Die Eingegebenen Daten waren nicht korrekt");
}
}
Core::publish($StatusT, "StatusT");
