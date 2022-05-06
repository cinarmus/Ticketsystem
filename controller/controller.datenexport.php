<?php

require "includes/config.php";
$dest = "../Ticketsystem/speicherstände/Ticketsystem";


//löscht alle existenten Export-Jsons 
array_map("unlink", glob("$dest/*.json"));
if(isset($_POST["file_name"])){
if($_POST["file_name"]==""){
$zipname= "Stand";
}else{
$zipname= $_POST["file_name"];
}
}
$date = new DateTime();
$timestamp= $date->getTimestamp();
$datum = date("d.m.Y_H-i-s", $timestamp);
$zipname_gesamt=$zipname."_".$datum.".zip";


if($_POST['Datenbank'] == "1"){
try {
//man braucht eine direkte Verbindung
$dbh = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);
$sql = "SHOW TABLES";
$tabellen = $dbh->query($sql);
foreach ($tabellen as $tabelle) {
$tabelleName = $tabelle[0];
$sql = "select * from `" . $tabelleName . "`";
$sth = $dbh->prepare($sql);
$sth->execute();
//bewirkt, dass nur ein assoziatives Array erzeugt wird und nicht sowohl als auch, was es zum Schluss schwieriger zum Auslesen macht.
$result = $sth->fetchAll(PDO::FETCH_CLASS);
$jsonresult = json_encode($result,JSON_UNESCAPED_UNICODE);
$handle = fopen("$dest/$tabelleName" . ".json", "w");
fwrite($handle, $jsonresult);
fclose($handle);
}
} catch (PDOException $e) {
echo "Da die Datenbank bisher nicht existiert hat, konnten keine Daten exportiert werden.";
}
$zip = new ZipArchive();
$ret = $zip->open($dest.'/datenbank.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
if ($ret !== TRUE) {
printf("Failed with code %d", $ret);
} else {
$directory = realpath("../Ticketsystem/speicherstände/Ticketsystem");
$options = array("remove_path" => $directory);
$zip->addPattern("/\.(?:json)$/", $directory, $options);
$zip->close();
}
//löscht alle existenten Export-Jsons 
array_map("unlink", glob("../Ticketsystem/speicherstände/Ticketsystem/*.json"));
}

//Bilder-Teil Export
if($_POST['Bilder'] == "1"){
try{
            $images_directory="../Ticketsystem/images";
            $rootPathImages = realpath($images_directory);

            // Archiv-Objekt initialisieren
            $zip1 = new ZipArchive();
            $zip1->open($dest.'/images.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

            // Rekursiver Verzeichnis-Iterator
            /** @var SplFileInfo[] $files */
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($rootPathImages),
                RecursiveIteratorIterator::LEAVES_ONLY
                );

            foreach ($files as $name => $file){
                // Verzeichnisse überspringen 
                if (!$file->isDir()){
                // Realen und relativen Pfad für die aktuelle Datei ermitteln
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPathImages) + 1);

                // Fügt die aktuelle Datei hinzu
                $zip1->addFile($filePath, $relativePath);
                }
             }
            // Speichert die Zip nach dem schließen
            $zip1->close();
        } catch (Exception $ex) {
        }
}

//File-Teil Export
if($_POST['Dateien'] == "1"){
try{
            $files_directory="../Ticketsystem/files";
            $rootPathFiles = realpath($files_directory);
            
            $zip2 = new ZipArchive();
            $zip2->open($dest.'/files.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

            // Rekursiver Verzeichnis-Iterator
            /** @var SplFileInfo[] $files */
            $files = new RecursiveIteratorIterator(
              new RecursiveDirectoryIterator($rootPathFiles),
               RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file){
            // Verzeichnisse überspringen 
             if (!$file->isDir()){
              // Realen und relativen Pfad für die aktuelle Datei ermitteln
              $filePath = $file->getRealPath();
              $relativePath = substr($filePath, strlen($rootPathFiles) + 1);

              // Fügt die aktuelle Datei hinzu
               $zip2->addFile($filePath, $relativePath);
              }
             }

            // Speichert die Zip nach dem schließen
            $zip2->close();
            
        } catch (Exception $ex) {
        }
}

if($_POST['Versionskommentar'] != ""){
$txtFile = fopen("$dest/versionskommentar.txt", "w");
$txt = $_POST['Versionskommentar'];
fwrite($txtFile, $txt);
fclose($txtFile);
}

$zipGesamt = new ZipArchive();
$zipGesamt->open($dest.'/'.$zipname_gesamt, ZipArchive::CREATE | ZipArchive::OVERWRITE);
$zipGesamt->addFile($dest.'/datenbank.zip', "datenbank.zip");
$zipGesamt->addFile($dest.'/images.zip', "images.zip");
$zipGesamt->addFile($dest.'/files.zip', "files.zip");
$zipGesamt->addFile("$dest/versionskommentar.txt", "versionskommentar.txt");
$zipGesamt->close();

array_map("unlink", glob($dest.'/datenbank.zip'));
array_map("unlink", glob($dest.'/images.zip'));
array_map("unlink", glob($dest.'/files.zip'));
array_map("unlink", glob("$dest/versionskommentar.txt"));

require "controller.speicherstande_overview.php";
