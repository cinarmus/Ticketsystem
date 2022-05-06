<?php
Core::checkAccessLevel(1);
Core::$title="Neu: AbteilungT";
Core::setView("AbteilungT_new", "view1", "new");
Core::setViewScheme("view1", "new", "AbteilungT");
$AbteilungT=new AbteilungT();
AbteilungT::$activeViewport="new";
$AbteilungT_list = AbteilungT::findAll();
Core::publish($AbteilungT_list, "AbteilungT_list");
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$a= $AbteilungT->loadFormData();
if($a===true){
if($AbteilungT->create()!="0"){
foreach($_FILES as $filekey => $file){
if($file["name"]!=""){
$AbteilungT_field =AbteilungT::$dataScheme[$filekey];
switch ($AbteilungT_field["type"]){
case "picture":
$AbteilungT->updateFile($filekey);
break;
case "file": // Hier müsste noch zwischen Bildern und  Dokumenten unterschieden werden
$parentField=AbteilungT::$dataScheme[$AbteilungT_field["sysParent"]];
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
$pfad = $AbteilungT_field["sysParent"] . "_path"; // path wird nirgends ausgelesen sondern jetzt einfach mal so definiert
$filetypes=$parentField["filetypes"];
$AbteilungT->updateFile($filekey, ["pathDB" => $pfad, "path"=>$ordner, "filestypes"=>$filetypes]);
break;
default:
}
}
}
$AbteilungT=new AbteilungT();
Core::$view->path["view1"]="views/view.AbteilungT_new.php";
}else{
Core::addError("Der Datenbankeintrag war nicht erfolgreich"); 
}
}else{
Core::addError("Die Eingegebenen Daten waren nicht korrekt");
}
}
Core::publish($AbteilungT, "AbteilungT");
