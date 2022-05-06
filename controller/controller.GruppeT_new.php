<?php
Core::checkAccessLevel(1);
Core::$title="Neu: GruppeT";
Core::setView("GruppeT_new", "view1", "new");
Core::setViewScheme("view1", "new", "GruppeT");
$GruppeT=new GruppeT();
GruppeT::$activeViewport="new";
$GruppeT_list = GruppeT::findAll();
Core::publish($GruppeT_list, "GruppeT_list");
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$a= $GruppeT->loadFormData();
if($a===true){
if($GruppeT->create()!="0"){
foreach($_FILES as $filekey => $file){
if($file["name"]!=""){
$GruppeT_field =GruppeT::$dataScheme[$filekey];
switch ($GruppeT_field["type"]){
case "picture":
$GruppeT->updateFile($filekey);
break;
case "file": // Hier müsste noch zwischen Bildern und  Dokumenten unterschieden werden
$parentField=GruppeT::$dataScheme[$GruppeT_field["sysParent"]];
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
$pfad = $GruppeT_field["sysParent"] . "_path"; // path wird nirgends ausgelesen sondern jetzt einfach mal so definiert
$filetypes=$parentField["filetypes"];
$GruppeT->updateFile($filekey, ["pathDB" => $pfad, "path"=>$ordner, "filestypes"=>$filetypes]);
break;
default:
}
}
}
$GruppeT=new GruppeT();
Core::$view->path["view1"]="views/view.GruppeT_new.php";
}else{
Core::addError("Der Datenbankeintrag war nicht erfolgreich"); 
}
}else{
Core::addError("Die Eingegebenen Daten waren nicht korrekt");
}
}
Core::publish($GruppeT, "GruppeT");
