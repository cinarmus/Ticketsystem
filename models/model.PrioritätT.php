<?php
class PrioritätT extends DB{
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
const SQL_INSERT='INSERT INTO PrioritätT (literal, sort) VALUES (?, ?)';
const SQL_UPDATE='UPDATE PrioritätT SET literal=?, sort=? WHERE id=?';
const SQL_SELECT_PK='SELECT PrioritätT.* FROM PrioritätT WHERE id=?';
const SQL_SELECT_ALL='SELECT PrioritätT.* FROM PrioritätT';
const SQL_DELETE='DELETE FROM PrioritätT WHERE id=?';
const SQL_PRIMARY='id';
}
PrioritätT::$dataScheme=db::buildScheme("PrioritätT");
$fp = fopen("models/json/PrioritätT_complete.json", "w");
fwrite($fp, json_encode(db::buildScheme("PrioritätT"),JSON_UNESCAPED_UNICODE));
fclose($fp);
PrioritätT::$settings=db::loadSettings("PrioritätT");
$fp = fopen("models/json/PrioritätT_settings_complete.json", "w");
fwrite($fp, json_encode(PrioritätT::$settings,JSON_UNESCAPED_UNICODE));
fclose($fp);
