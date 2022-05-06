<?php
class GruppeT extends DB{
//Variablenliste
public $id;
public $c_ts;
public $m_ts;
public $literal;
public $sort;
public static $settings=array();
public $dataMapping=array(); // damit ein eigenes statisches Array entsteht. Sonst ist es DB::$dataScheme
public static $dataScheme=array(); // damit ein eigenes statisches Array entsteht. Sonst ist es DB::$dataScheme
//Konstanten
const SQL_INSERT='INSERT INTO GruppeT (literal, sort) VALUES (?, ?)';
const SQL_UPDATE='UPDATE GruppeT SET literal=?, sort=? WHERE id=?';
const SQL_SELECT_PK='SELECT GruppeT.* FROM GruppeT WHERE id=?';
const SQL_SELECT_ALL='SELECT GruppeT.* FROM GruppeT';
const SQL_DELETE='DELETE FROM GruppeT WHERE id=?';
const SQL_PRIMARY='id';
}
GruppeT::$dataScheme=db::buildScheme("GruppeT");
$fp = fopen("models/json/GruppeT_complete.json", "w");
fwrite($fp, json_encode(db::buildScheme("GruppeT"),JSON_UNESCAPED_UNICODE));
fclose($fp);
GruppeT::$settings=db::loadSettings("GruppeT");
$fp = fopen("models/json/GruppeT_settings_complete.json", "w");
fwrite($fp, json_encode(GruppeT::$settings,JSON_UNESCAPED_UNICODE));
fclose($fp);
