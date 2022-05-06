<?php
class TBMitarbeiter extends DB{

//Variablenliste
public $id;
public $c_ts;
public $m_ts;
public static $settings=array();
public $Abteilung;
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
const SQL_INSERT='INSERT INTO TBMitarbeiter (_User_uid, `Abteilung` , `Name_Vorname` , `Name_Nachname` , `Adresse_Straße` , `Adresse_PLZ` , `Adresse_Ort` ) VALUES (?, ?, ?, ?, ?, ?, ?)';
const SQL_UPDATE='UPDATE TBMitarbeiter SET _User_uid=?, `Abteilung` =?, `Name_Vorname` =?, `Name_Nachname` =?, `Adresse_Straße` =?, `Adresse_PLZ` =?, `Adresse_Ort` =? where id=?';
const SQL_SELECT_PK='SELECT TBMitarbeiter.`c_ts` as `c_ts`, TBMitarbeiter.`m_ts` as `m_ts`, TBMitarbeiter.`id` as `id`, TBMitarbeiter._User_uid as _User_uid, `AbteilungT0`.`literal` as `Abteilung_literal`, `TBMitarbeiter`.`Abteilung` as `Abteilung`, `TBMitarbeiter`.`Name_Vorname` as `Name_Vorname`, `TBMitarbeiter`.`Name_Nachname` as `Name_Nachname`, `TBMitarbeiter`.`Adresse_Straße` as `Adresse_Straße`, `TBMitarbeiter`.`Adresse_PLZ` as `Adresse_PLZ`, `TBMitarbeiter`.`Adresse_Ort` as `Adresse_Ort` from TBMitarbeiter left join `AbteilungT` as AbteilungT0 on `TBMitarbeiter`.`Abteilung` = `AbteilungT0`.`id`  where TBMitarbeiter.`id` = ?';
const SQL_SELECT_ALL='SELECT TBMitarbeiter.`c_ts` as `c_ts`, TBMitarbeiter.`m_ts` as `m_ts`, TBMitarbeiter.`id` as `id`, TBMitarbeiter._User_uid as _User_uid, `AbteilungT0`.`literal` as `Abteilung_literal`, `TBMitarbeiter`.`Abteilung` as `Abteilung`, `TBMitarbeiter`.`Name_Vorname` as `Name_Vorname`, `TBMitarbeiter`.`Name_Nachname` as `Name_Nachname`, `TBMitarbeiter`.`Adresse_Straße` as `Adresse_Straße`, `TBMitarbeiter`.`Adresse_PLZ` as `Adresse_PLZ`, `TBMitarbeiter`.`Adresse_Ort` as `Adresse_Ort` from TBMitarbeiter left join `AbteilungT` as AbteilungT0 on `TBMitarbeiter`.`Abteilung` = `AbteilungT0`.`id` ';
const SQL_SELECT_IGNORE_DERIVED='SELECT DISTINCT TBMitarbeiter.`c_ts` as `c_ts`, TBMitarbeiter.`m_ts` as `m_ts`, TBMitarbeiter.`id` as `id`, TBMitarbeiter._User_uid as _User_uid, `AbteilungT0`.`literal` as `Abteilung_literal`, `TBMitarbeiter`.`Abteilung` as `Abteilung`, `TBMitarbeiter`.`Name_Vorname` as `Name_Vorname`, `TBMitarbeiter`.`Name_Nachname` as `Name_Nachname`, `TBMitarbeiter`.`Adresse_Straße` as `Adresse_Straße`, `TBMitarbeiter`.`Adresse_PLZ` as `Adresse_PLZ`, `TBMitarbeiter`.`Adresse_Ort` as `Adresse_Ort` from TBMitarbeiter left join `AbteilungT` as AbteilungT0 on `TBMitarbeiter`.`Abteilung` = `AbteilungT0`.`id` ';
const SQL_DELETE='DELETE FROM TBMitarbeiter WHERE id=?';
const SQL_PRIMARY='id';

const SQL_SELECT_Ticket_zuteilen='select TBMitarbeiter.id as id, `AbteilungT0`.`literal` as `Abteilung_literal`, `TBMitarbeiter`.`Abteilung` as `Abteilung`, TBMitarbeiter.Name_Vorname as Name_Vorname, TBMitarbeiter.Name_Nachname as Name_Nachname, TBMitarbeiter.Adresse_Straße as Adresse_Straße, TBMitarbeiter.Adresse_PLZ as Adresse_PLZ, TBMitarbeiter.Adresse_Ort as Adresse_Ort from TBMitarbeiter left join `AbteilungT` as AbteilungT0 on `TBMitarbeiter`.`Abteilung` = `AbteilungT0`.`id`  where TBMitarbeiter.id = ?';
const SQL_SELECT_User_uid='select TBMitarbeiter.id as id, `AbteilungT0`.`literal` as `Abteilung_literal`, `TBMitarbeiter`.`Abteilung` as `Abteilung`, TBMitarbeiter.Name_Vorname as Name_Vorname, TBMitarbeiter.Name_Nachname as Name_Nachname, TBMitarbeiter.Adresse_Straße as Adresse_Straße, TBMitarbeiter.Adresse_PLZ as Adresse_PLZ, TBMitarbeiter.Adresse_Ort as Adresse_Ort from TBMitarbeiter left join `AbteilungT` as AbteilungT0 on `TBMitarbeiter`.`Abteilung` = `AbteilungT0`.`id`  where TBMitarbeiter._User_uid=?';
}

TBMitarbeiter::$dataScheme=db::buildScheme("TBMitarbeiter");
$fp = fopen("models/json/TBMitarbeiter_complete.json", "w");
fwrite($fp, json_encode(TBMitarbeiter::$dataScheme,JSON_UNESCAPED_UNICODE));
fclose($fp);
TBMitarbeiter::$settings=db::loadSettings("TBMitarbeiter");
$fp = fopen("models/json/TBMitarbeiter_settings_complete.json", "w");
fwrite($fp, json_encode(TBMitarbeiter::$settings,JSON_UNESCAPED_UNICODE));
fclose($fp);
