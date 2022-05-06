<?php
Core::checkAccessLevel(1);
Core::$title="Edit: PrioritätT";
$id=$_GET["id"];
Core::setView("PrioritätT_edit", "view1", "edit");
Core::setViewScheme("view1", "edit", "PrioritätT");
$PrioritätT=new PrioritätT();
PrioritätT::$activeViewport="edit";
$PrioritätT_list = PrioritätT::findAll();
Core::publish($PrioritätT_list, "PrioritätT_list");
PrioritätT::$activeViewport="edit";
$PrioritätT->loadDBData($id);
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$a= $PrioritätT->loadFormData();
if($a===true){
if($PrioritätT->update()!="0"){
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
default:;
$ordner="files/";;
};
$pfad = $PrioritätT_field["sysParent"] . "_path"; // path wird nirgends ausgelesen sondern jetzt einfach mal so definiert
$filetypes=$parentField["filetypes"];
$PrioritätT->updateFile($filekey, ["pathDB" => $pfad, "path"=>$ordner, "filestypes"=>$filetypes]);
break;
default:
}
}
}
core::redirect("PrioritätT&id=$id");
}else{
Core::addError("Der Datenbankeintrag war nicht erfolgreich"); 
}
}else{
Core::addError("Die Eingegebenen Daten waren nicht korrekt");
}
}
Core::publish($PrioritätT, "PrioritätT");
