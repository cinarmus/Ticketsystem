<?php
//Lädt Speicherstand-Upload in Speicherstand Ordner
    $tmp_name = $_FILES["speicherstand"]["tmp_name"];
    // basename() kann Directory-Traversal-Angriffe verhindern;
    $name = basename($_FILES["speicherstand"]["name"]);
    move_uploaded_file($tmp_name, "../Ticketsystem/speicherstände/Ticketsystem/$name");
    $speicherstandUploadPfad = "../Ticketsystem/speicherstände/Ticketsystem/$name";

if(isset($_POST['speicherstandImport'])){
    $speicherstandImport = true;
}  

//Speicherstand direkt Importieren   
if($speicherstandImport === true){
$options["id"] = $name;
Core::redirect("datenimport", $options);
}else{
    require "controller.speicherstande_overview.php";
}