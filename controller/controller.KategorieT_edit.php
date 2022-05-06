<?php
Core::checkAccessLevel(1);
Core::$title="Edit: KategorieT";
$id=$_GET["id"];
Core::setView("KategorieT_edit", "view1", "edit");
Core::setViewScheme("view1", "edit", "KategorieT");
$KategorieT=new KategorieT();
KategorieT::$activeViewport="edit";
$KategorieT_list = KategorieT::findAll();
Core::publish($KategorieT_list, "KategorieT_list");
KategorieT::$activeViewport="edit";
$KategorieT->loadDBData($id);
if(count($_POST)>0 && $_GET["task"]!="favoriten" && $_POST["registrieren-ng"] != "1" && $_POST["registrieren"] != "1"){
$a= $KategorieT->loadFormData();
if($a===true){
if($KategorieT->update()!="0"){
foreach($_FILES as $filekey => $file){
if($file["name"]!=""){
$KategorieT_field =KategorieT::$dataScheme[$filekey];
switch ($KategorieT_field["type"]){
case "picture":
$KategorieT->updateFile($filekey);
break;
case "file": // Hier müsste noch zwischen Bildern und  Dokumenten unterschieden werden
$parentField=KategorieT::$dataScheme[$KategorieT_field["sysParent"]];
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
$pfad = $KategorieT_field["sysParent"] . "_path"; // path wird nirgends ausgelesen sondern jetzt einfach mal so definiert
$filetypes=$parentField["filetypes"];
$KategorieT->updateFile($filekey, ["pathDB" => $pfad, "path"=>$ordner, "filestypes"=>$filetypes]);
break;
default:
}
}
}
core::redirect("KategorieT&id=$id");
}else{
Core::addError("Der Datenbankeintrag war nicht erfolgreich"); 
}
}else{
Core::addError("Die Eingegebenen Daten waren nicht korrekt");
}
}
Core::publish($KategorieT, "KategorieT");
