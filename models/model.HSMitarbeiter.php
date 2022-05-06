<?php
class HSMitarbeiter extends DB{

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
const SQL_INSERT='INSERT INTO HSMitarbeiter (_User_uid, `Name_Vorname` , `Name_Nachname` , `Adresse_Straße` , `Adresse_PLZ` , `Adresse_Ort` ) VALUES (?, ?, ?, ?, ?, ?)';
const SQL_UPDATE='UPDATE HSMitarbeiter SET _User_uid=?, `Name_Vorname` =?, `Name_Nachname` =?, `Adresse_Straße` =?, `Adresse_PLZ` =?, `Adresse_Ort` =? where id=?';
const SQL_SELECT_PK='SELECT HSMitarbeiter.`c_ts` as `c_ts`, HSMitarbeiter.`m_ts` as `m_ts`, HSMitarbeiter.`id` as `id`, HSMitarbeiter._User_uid as _User_uid, `HSMitarbeiter`.`Name_Vorname` as `Name_Vorname`, `HSMitarbeiter`.`Name_Nachname` as `Name_Nachname`, `HSMitarbeiter`.`Adresse_Straße` as `Adresse_Straße`, `HSMitarbeiter`.`Adresse_PLZ` as `Adresse_PLZ`, `HSMitarbeiter`.`Adresse_Ort` as `Adresse_Ort` from HSMitarbeiter where HSMitarbeiter.`id` = ?';
const SQL_SELECT_ALL='SELECT HSMitarbeiter.`c_ts` as `c_ts`, HSMitarbeiter.`m_ts` as `m_ts`, HSMitarbeiter.`id` as `id`, HSMitarbeiter._User_uid as _User_uid, `HSMitarbeiter`.`Name_Vorname` as `Name_Vorname`, `HSMitarbeiter`.`Name_Nachname` as `Name_Nachname`, `HSMitarbeiter`.`Adresse_Straße` as `Adresse_Straße`, `HSMitarbeiter`.`Adresse_PLZ` as `Adresse_PLZ`, `HSMitarbeiter`.`Adresse_Ort` as `Adresse_Ort` from HSMitarbeiter';
const SQL_SELECT_IGNORE_DERIVED='SELECT DISTINCT HSMitarbeiter.`c_ts` as `c_ts`, HSMitarbeiter.`m_ts` as `m_ts`, HSMitarbeiter.`id` as `id`, HSMitarbeiter._User_uid as _User_uid, `HSMitarbeiter`.`Name_Vorname` as `Name_Vorname`, `HSMitarbeiter`.`Name_Nachname` as `Name_Nachname`, `HSMitarbeiter`.`Adresse_Straße` as `Adresse_Straße`, `HSMitarbeiter`.`Adresse_PLZ` as `Adresse_PLZ`, `HSMitarbeiter`.`Adresse_Ort` as `Adresse_Ort` from HSMitarbeiter';
const SQL_DELETE='DELETE FROM HSMitarbeiter WHERE id=?';
const SQL_PRIMARY='id';

const SQL_SELECT_Ticket_ticket_erstellen = 'select HSMitarbeiter.id as id, Ticket_HSMitarbeiter.id as zwkls_id, HSMitarbeiter.Name_Vorname as Name_Vorname, HSMitarbeiter.Name_Nachname as Name_Nachname, HSMitarbeiter.Adresse_Straße as Adresse_Straße, HSMitarbeiter.Adresse_PLZ as Adresse_PLZ, HSMitarbeiter.Adresse_Ort as Adresse_Ort from HSMitarbeiter inner join Ticket_HSMitarbeiter on HSMitarbeiter.id = Ticket_HSMitarbeiter._HSMitarbeiter_b   where Ticket_HSMitarbeiter._Ticket_ticket_erstellen = ?';
const SQL_SELECT_User_uid='select HSMitarbeiter.id as id, HSMitarbeiter.Name_Vorname as Name_Vorname, HSMitarbeiter.Name_Nachname as Name_Nachname, HSMitarbeiter.Adresse_Straße as Adresse_Straße, HSMitarbeiter.Adresse_PLZ as Adresse_PLZ, HSMitarbeiter.Adresse_Ort as Adresse_Ort from HSMitarbeiter where HSMitarbeiter._User_uid=?';
}

HSMitarbeiter::$dataScheme=db::buildScheme("HSMitarbeiter");
$fp = fopen("models/json/HSMitarbeiter_complete.json", "w");
fwrite($fp, json_encode(HSMitarbeiter::$dataScheme,JSON_UNESCAPED_UNICODE));
fclose($fp);
HSMitarbeiter::$settings=db::loadSettings("HSMitarbeiter");
$fp = fopen("models/json/HSMitarbeiter_settings_complete.json", "w");
fwrite($fp, json_encode(HSMitarbeiter::$settings,JSON_UNESCAPED_UNICODE));
fclose($fp);
