<?php

$deletePaths = [];

if (isset($_GET["id"])) {
require "includes/config.php";
$x =0;
$datenimport_fehler =array();
$anwendung_datenexport = "../Ticketsystem/speicherstände/Ticketsystem";
$anwendung = "../Ticketsystem";

//Gesamt entpacken
$pathGesamt = $anwendung_datenexport . "/" . $_GET["id"];
$zipGesamt = new ZipArchive;
if ($zipGesamt->open($pathGesamt) === true) {
$zipGesamt->extractTo($anwendung_datenexport);
$zipGesamt->close();
} else {
echo "Fehler";
}

$pathFolder = substr($_GET["id"], 0, -4);

//Datenbank-Teil
$path = $anwendung_datenexport."/datenbank.zip";
if(file_exists($path)){
    array_push($deletePaths,$path);
$jsonfiles = array();
$zip = new ZipArchive;
if ($zip->open($path) === TRUE) {
$zip->extractTo($anwendung_datenexport);
$zip->close();
} else {
echo "Fehler";
}
if (is_dir($anwendung_datenexport)) {
// öffnen des Verzeichnisses
if ($handle = opendir($anwendung_datenexport)) {
// einlesen der Verzeichnisses
while (($jsonfile = readdir($handle)) !== false) {
$ext = pathinfo($jsonfile, PATHINFO_EXTENSION);
if ($ext == "json") {
array_push($jsonfiles, $jsonfile);
}
}
closedir($handle);
}
}
$enumerationen=array();
$klassen=array();
$dbh = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);
$sql = "SHOW TABLES";
$tabellen = $dbh->query($sql);
foreach ($tabellen as $tabelle) {
$tabelleName = $tabelle[0];
$sql = "select id,c_ts,m_ts,literal,sort from `" . $tabelleName . "`";
if (!isset($value)){
$sql2 = $sql2 . "null,";
}else {
$sql2 = $sql2 . "'$value',";
}
$sql2 = "SHOW COLUMNS FROM`" . $tabelleName . "`";
$sth = $dbh->prepare($sql);
$sth2 = $dbh->prepare($sql2);
$sth->execute();
$sth2->execute();
//bewirkt, dass nur ein assoziatives Array erzeugt wird und nicht sowohl als auch, was es zum Schluss schwieriger zum Auslesen macht.
$result = $sth->fetchAll(PDO::FETCH_CLASS);
$result2 = $sth2->fetchAll(PDO::FETCH_CLASS);
if(count($result)>0){
array_push($enumerationen,$tabelleName);
}else{ 
foreach($result2 as $klasse){
//$klassen[strtolower($tabelleName)][$klasse->Field]="";
$klassen[$tabelleName][$klasse->Field]="";
}
$sql = "DELETE FROM `" . $tabelleName . "`";
$sth3 = $dbh->prepare($sql);
$sth3->execute();
}
}
foreach ($jsonfiles as $jsonfile) {
$jsoninhalt = file_get_contents("$anwendung_datenexport/$jsonfile");
$zeilen = json_decode($jsoninhalt, true);
$jsonname = pathinfo($jsonfile, PATHINFO_FILENAME);
$ist_enumeration=0;
foreach ($enumerationen as $enumeration) {
if($jsonname==$enumeration){
$ist_enumeration=1;
}
}
//sorgt dafür dass nur Klassen eingefügt werden, Enumerationen etc. befinden sich bereits in der Datenbank
$sql_delete = "DELETE FROM `" . $jsonname . "`";
$sth_delete = $dbh->prepare($sql_delete);
$sth_delete->execute();
foreach ($zeilen as $zeile) {
$sql = "insert ignore into `" . $jsonname . "` (";
$sql1 = null;
$sql2 = null;
foreach ($zeile as $feld => $value) {
if (isset($klassen[$jsonname][$feld]) or $ist_enumeration == 1) {
$sql1 = $sql1 . "`$feld`,";
if (!isset($value)){
$sql2 = $sql2 . "null,";
}else {
$sql2 = $sql2 . "'$value',";
}
}else{
if (isset($datenimport_fehler[$jsonname])) {
foreach ($datenimport_fehler as $item) {
foreach ($item['attribut'] as $msg){
if ($msg == $feld) {
$vorhanden = true;
break;
} else {
$vorhanden = false;
}
}
}
if (!$vorhanden) {
$datenimport_fehler[$jsonname]["klasse"] = $jsonname;
$datenimport_fehler[$jsonname]['attribut'][$x] = $feld;
$x++;
}
}else{
$datenimport_fehler[$jsonname]["klasse"] = $jsonname;
$datenimport_fehler[$jsonname]['attribut'][$x] = $feld;
$x++;
}
}
}
$sql1 = substr($sql1, 0, -1);
$sql2 = substr($sql2, 0, -1);
$sql = $sql . $sql1 . ") values (" . $sql2 . ");";
$import = $dbh->prepare($sql);
$import->execute();
}
unlink($anwendung_datenexport."/".$jsonfile);
}
}
}
foreach ($datenimport_fehler as $fehler){
foreach ($fehler['attribut'] as $msg){
Core::addError("Das Feld ".$msg." in der Klasse ".$fehler['klasse']." ist nicht mehr  vorhanden");
}
}

//Image-Teil
$path1 = $anwendung_datenexport."/images.zip";
if(file_exists($path1)){
    array_push($deletePaths,$path1);
    //alte Dateien löschen
    array_map('unlink', glob("$anwendung/images/*.*"));
    //Speicherstände reinladen
    $zip1= new ZipArchive();
    $zip1->open($path1);
    $zip1->extractTo($anwendung.'/images');
    $zip1->close();
}

//File-Teil
$path2 = $anwendung_datenexport."/files.zip";
if(file_exists($path2)){
    array_push($deletePaths,$path2);
    //alte Dateien löschen
    array_map('unlink', glob("$anwendung/files/*.*"));
    //Speicherstände reinladen
    $zip2= new ZipArchive();
    $zip2->open($path2);
    $zip2->extractTo($anwendung.'/files');
    $zip2->close();
}

//Versionskommentar
$path3 = $anwendung_datenexport . "/versionskommentar.txt";
if(file_exists($path3)){
    unlink($path3);
}

foreach($deletePaths as $path){
$files = glob($path."/*"); // alle Files im Ordner wählen
foreach($files as $file){
  if(is_file($file)) {
    unlink($file); // alle Files löschen
  }
}      
unlink($path);
}


require "controller.speicherstande_overview.php";
