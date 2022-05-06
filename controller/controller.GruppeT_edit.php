<?php
Core::checkAccessLevel(1);
Core::$title="Edit: GruppeT";
$id=$_GET["id"];
Core::setView("GruppeT_edit", "view1", "edit");
Core::setViewScheme("view1", "edit", "GruppeT");
$GruppeT=new GruppeT();
GruppeT::$activeViewport="edit";
$GruppeT_list = GruppeT::findAll();
Core::publish($GruppeT_list, "GruppeT_list");
GruppeT::$activeViewport="edit";
$GruppeT->loadDBData($id);
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$a= $GruppeT->loadFormData();
if($a===true){
if($GruppeT->update()!="0"){
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
default:;
$ordner="files/";;
};
$pfad = $GruppeT_field["sysParent"] . "_path"; // path wird nirgends ausgelesen sondern jetzt einfach mal so definiert
$filetypes=$parentField["filetypes"];
$GruppeT->updateFile($filekey, ["pathDB" => $pfad, "path"=>$ordner, "filestypes"=>$filetypes]);
break;
default:
}
}
}
core::redirect("GruppeT&id=$id");
}else{
Core::addError("Der Datenbankeintrag war nicht erfolgreich"); 
}
}else{
Core::addError("Die Eingegebenen Daten waren nicht korrekt");
}
}
Core::publish($GruppeT, "GruppeT");
