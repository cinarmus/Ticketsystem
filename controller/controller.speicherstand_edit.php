<?php
Core::checkAccessLevel(1);
if (isset($_GET["id"]) && isset($_POST["file_name_edit"])) {
$zip_name = $_GET["id"];
$zip_name_neu = $_POST["file_name_edit"];
$zip = new ZipArchive;
$path = "../Ticketsystem/speicherstände/Ticketsystem/";
$res = $zip->open($path.$zip_name);
if ($res === TRUE && $zip_name_neu !="") {
$zip->close();
$date = new DateTime();
$timestamp= $date->getTimestamp();
$datum = date("d.m.Y_H-i-s", $timestamp);
$zip_name_neu=$zip_name_neu."_".$datum.".zip";
rename($path.$zip_name,$path.$zip_name_neu.".zip");
} else {
Core::addError("Der Datenexport konnte nicht umbenannt werden");
}
}
require "controller.speicherstande_overview.php";
