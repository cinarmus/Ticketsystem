<?php
class AbteilungT extends DB{
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
const SQL_INSERT='INSERT INTO AbteilungT (literal, sort) VALUES (?, ?)';
const SQL_UPDATE='UPDATE AbteilungT SET literal=?, sort=? WHERE id=?';
const SQL_SELECT_PK='SELECT AbteilungT.* FROM AbteilungT WHERE id=?';
const SQL_SELECT_ALL='SELECT AbteilungT.* FROM AbteilungT';
const SQL_DELETE='DELETE FROM AbteilungT WHERE id=?';
const SQL_PRIMARY='id';
}
AbteilungT::$dataScheme=db::buildScheme("AbteilungT");
$fp = fopen("models/json/AbteilungT_complete.json", "w");
fwrite($fp, json_encode(db::buildScheme("AbteilungT"),JSON_UNESCAPED_UNICODE));
fclose($fp);
AbteilungT::$settings=db::loadSettings("AbteilungT");
$fp = fopen("models/json/AbteilungT_settings_complete.json", "w");
fwrite($fp, json_encode(AbteilungT::$settings,JSON_UNESCAPED_UNICODE));
fclose($fp);
