<?php
Core::checkAccessLevel(1);
Core::$title="Neu: PrioritätT";
Core::setView("PrioritätT_new", "view1", "new");
Core::setViewScheme("view1", "new", "PrioritätT");
$PrioritätT=new PrioritätT();
PrioritätT::$activeViewport="new";
$PrioritätT_list = PrioritätT::findAll();
Core::publish($PrioritätT_list, "PrioritätT_list");
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$a= $PrioritätT->loadFormData();
if($a===true){
if($PrioritätT->create()!="0"){
foreach($_FILES as $filekey => $file){
if($file["name"]!=""){
$PrioritätT_field =PrioritätT::$dataScheme[$filekey];
switch ($PrioritätT_field["type"]){
case "picture":
$PrioritätT->updateFile($filekey);
break;
case "file": // Hier müsste noch zwischen Bildern und  Dokumenten unterschieden werden
$parentField=PrioritätT::$dataScheme[$PrioritätT_field["sysParent"]];
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
$pfad = $PrioritätT_field["sysParent"] . "_path"; // path wird nirgends ausgelesen sondern jetzt einfach mal so definiert
$filetypes=$parentField["filetypes"];
$PrioritätT->updateFile($filekey, ["pathDB" => $pfad, "path"=>$ordner, "filestypes"=>$filetypes]);
break;
default:
}
}
}
$PrioritätT=new PrioritätT();
Core::$view->path["view1"]="views/view.PrioritätT_new.php";
}else{
Core::addError("Der Datenbankeintrag war nicht erfolgreich"); 
}
}else{
Core::addError("Die Eingegebenen Daten waren nicht korrekt");
}
}
Core::publish($PrioritätT, "PrioritätT");
