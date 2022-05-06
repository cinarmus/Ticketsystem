<?php
if (isset($_GET["id"])) {

$files = glob("../Ticketsystem/speicherstände/Ticketsystem/".$_GET["id"]."/*"); // alle Files im Ordner wählen
foreach($files as $file){
  if(is_file($file)) {
    unlink($file); // alle Files löschen
  }
}    
    
unlink("../Ticketsystem/speicherstände/Ticketsystem/".$_GET["id"]);
}
require "controller.speicherstande_overview.php";