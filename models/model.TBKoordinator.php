<?php
class TBKoordinator extends DB{

//Variablenliste
public $id;
public $c_ts;
public $m_ts;
public static $settings=array();
public $Name_Vorname;
public $Name_Nachname;
public $Adresse_Straße;
public $Adresse_PLZ;
public $Adresse_Ort;
public $_User_uid;
public $ts;

public $dataMapping=array(); // damit ein eigenes statisches Array entsteht. Sonst ist es DB::$dataScheme

public static $dataScheme=array(); // damit ein eigenes statisches Array entsteht. Sonst ist es DB::$dataScheme

//Konstanten
const SQL_INSERT='INSERT INTO TBKoordinator (_User_uid, `Name_Vorname` , `Name_Nachname` , `Adresse_Straße` , `Adresse_PLZ` , `Adresse_Ort` ) VALUES (?, ?, ?, ?, ?, ?)';
const SQL_UPDATE='UPDATE TBKoordinator SET _User_uid=?, `Name_Vorname` =?, `Name_Nachname` =?, `Adresse_Straße` =?, `Adresse_PLZ` =?, `Adresse_Ort` =? where id=?';
const SQL_SELECT_PK='SELECT TBKoordinator.`c_ts` as `c_ts`, TBKoordinator.`m_ts` as `m_ts`, TBKoordinator.`id` as `id`, TBKoordinator._User_uid as _User_uid, `TBKoordinator`.`Name_Vorname` as `Name_Vorname`, `TBKoordinator`.`Name_Nachname` as `Name_Nachname`, `TBKoordinator`.`Adresse_Straße` as `Adresse_Straße`, `TBKoordinator`.`Adresse_PLZ` as `Adresse_PLZ`, `TBKoordinator`.`Adresse_Ort` as `Adresse_Ort` from TBKoordinator where TBKoordinator.`id` = ?';
const SQL_SELECT_ALL='SELECT TBKoordinator.`c_ts` as `c_ts`, TBKoordinator.`m_ts` as `m_ts`, TBKoordinator.`id` as `id`, TBKoordinator._User_uid as _User_uid, `TBKoordinator`.`Name_Vorname` as `Name_Vorname`, `TBKoordinator`.`Name_Nachname` as `Name_Nachname`, `TBKoordinator`.`Adresse_Straße` as `Adresse_Straße`, `TBKoordinator`.`Adresse_PLZ` as `Adresse_PLZ`, `TBKoordinator`.`Adresse_Ort` as `Adresse_Ort` from TBKoordinator';
const SQL_SELECT_IGNORE_DERIVED='SELECT DISTINCT TBKoordinator.`c_ts` as `c_ts`, TBKoordinator.`m_ts` as `m_ts`, TBKoordinator.`id` as `id`, TBKoordinator._User_uid as _User_uid, `TBKoordinator`.`Name_Vorname` as `Name_Vorname`, `TBKoordinator`.`Name_Nachname` as `Name_Nachname`, `TBKoordinator`.`Adresse_Straße` as `Adresse_Straße`, `TBKoordinator`.`Adresse_PLZ` as `Adresse_PLZ`, `TBKoordinator`.`Adresse_Ort` as `Adresse_Ort` from TBKoordinator';
const SQL_DELETE='DELETE FROM TBKoordinator WHERE id=?';
const SQL_PRIMARY='id';

const SQL_SELECT_Ticket_ticket_zuweisen='select TBKoordinator.id as id, TBKoordinator.Name_Vorname as Name_Vorname, TBKoordinator.Name_Nachname as Name_Nachname, TBKoordinator.Adresse_Straße as Adresse_Straße, TBKoordinator.Adresse_PLZ as Adresse_PLZ, TBKoordinator.Adresse_Ort as Adresse_Ort from TBKoordinator where TBKoordinator.id = ?';
const SQL_SELECT_User_uid='select TBKoordinator.id as id, TBKoordinator.Name_Vorname as Name_Vorname, TBKoordinator.Name_Nachname as Name_Nachname, TBKoordinator.Adresse_Straße as Adresse_Straße, TBKoordinator.Adresse_PLZ as Adresse_PLZ, TBKoordinator.Adresse_Ort as Adresse_Ort from TBKoordinator where TBKoordinator._User_uid=?';
}

TBKoordinator::$dataScheme=db::buildScheme("TBKoordinator");
$fp = fopen("models/json/TBKoordinator_complete.json", "w");
fwrite($fp, json_encode(TBKoordinator::$dataScheme,JSON_UNESCAPED_UNICODE));
fclose($fp);
TBKoordinator::$settings=db::loadSettings("TBKoordinator");
$fp = fopen("models/json/TBKoordinator_settings_complete.json", "w");
fwrite($fp, json_encode(TBKoordinator::$settings,JSON_UNESCAPED_UNICODE));
fclose($fp);
