<?php
Core::checkAccessLevel(1);
Core::$title = "Speicherstände";
Core::setView("speicherstande_overview", "view1", "list");
$x = 0;
$file_array = [];
//Das auszulesende Verzeichnis
$dir ="../Ticketsystem/speicherstände/Ticketsystem" ;
//Wenn das Verzeichnis existiert...
if (is_dir($dir)) {
//...öffne das Verzeichnis
$handle = opendir($dir);
//Wenn das Verzeichnis geöffnet werden konnte...
if (is_resource($handle)) {
//...lese die enthaltenen Dateien aus,...
while ($file = readdir($handle)) {
//...prüfe ob es Directory-Verweise sind...
$path = $dir . "/" . $file;
$tmp = explode(".", $path);
$endung = array_pop($tmp);
$filename = str_replace("." . $endung, "", $file);
$time = strrchr($filename, "_");
$name_datum[2] = str_replace("_", "", $time);
$filename = str_replace("$time", "", $filename);
$date = strrchr($filename, "_");
$name_datum[1] = str_replace("_", "", $date);
$v = "_" . $name_datum[1] . "_" . $name_datum[2] . ".zip";
$name_datum[0] = str_replace($v, "", $file);
$name_datum[2] = str_replace("-", ":", $name_datum[2]);
$name_datum[3] = $file;
if ($file != "." && $file != ".." && $endung == "zip") {
//...und schreibe sie in das Ziel-Array
$file_array[$x]["name"] = $name_datum[0];
$file_array[$x]["date"] = $name_datum[1] . " um " . $name_datum[2];
$file_array[$x]["whole_name"]=$name_datum[3];
$file_array[$x]["datetime"]=strtotime($name_datum[1])+strtotime($name_datum[2]);
$file_array[$x]["versionComment"] = unzip($path, $dir);
$x = $x + 1;
}
}
} else {
echo "Das Öffnen des Verzeichnisses ist fehlgeschlagen";
}
} else {
echo "Das Verzeichnis existiert nicht";
}
$file_array2=array();
$x=0;
$y=0;
foreach($file_array as $array){
foreach($array as $zeile){
$file_array2[$file_array[$x]["datetime"]][$y]= $zeile;
$y=$y+1;
}
$x=$x+1;
$y=0;
}
$x=1;
krsort($file_array2);
Core::publish($file_array2, "file_array");
Core::publish($angebot, "angebot");


function unzip($path, $dir) {
$zip = new ZipArchive;
$res = $zip->open($path);
if ($res === TRUE) {
  $zip->extractTo($dir);
  $zip->close();
  $textDir = strval($dir."/versionskommentar.txt");
  if(file_exists($textDir)){
  $text = file_get_contents($textDir);   
  unlink($dir."/versionskommentar.txt");
  }else{
      $text = "Es wurde kein Versionskommentar hinterlegt.";
  }
    unlink($dir."/datenbank.zip");
    unlink($dir."/files.zip");
    unlink($dir."/images.zip");    
}else{
}
    return $text;
}