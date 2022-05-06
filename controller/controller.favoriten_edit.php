<?php
Core::checkAccessLevel(1);
$result = false;
if (isset($_POST)){
    $name = $_POST['name_edit'];
    if ($name != "") {
        $Favoriten = new Favoriten();
        $result = $Favoriten->update_label($name, $_GET['id']);
    }
}
if ($result===true){
    Core::redirect("home",["message"=>"Favorit erfolgreich umbenannt"]);
}else{
    Core::redirect("home",["message"=>"Es ist ein Fehler beim Speichern aufgetreten"]);
}
