<?php
class StatusT extends DB{
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
const SQL_INSERT='INSERT INTO StatusT (literal, sort) VALUES (?, ?)';
const SQL_UPDATE='UPDATE StatusT SET literal=?, sort=? WHERE id=?';
const SQL_SELECT_PK='SELECT StatusT.* FROM StatusT WHERE id=?';
const SQL_SELECT_ALL='SELECT StatusT.* FROM StatusT';
const SQL_DELETE='DELETE FROM StatusT WHERE id=?';
const SQL_PRIMARY='id';
}
StatusT::$dataScheme=db::buildScheme("StatusT");
$fp = fopen("models/json/StatusT_complete.json", "w");
fwrite($fp, json_encode(db::buildScheme("StatusT"),JSON_UNESCAPED_UNICODE));
fclose($fp);
StatusT::$settings=db::loadSettings("StatusT");
$fp = fopen("models/json/StatusT_settings_complete.json", "w");
fwrite($fp, json_encode(StatusT::$settings,JSON_UNESCAPED_UNICODE));
fclose($fp);
