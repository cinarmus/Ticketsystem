<?php
class KategorieT extends DB{
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
const SQL_INSERT='INSERT INTO KategorieT (literal, sort) VALUES (?, ?)';
const SQL_UPDATE='UPDATE KategorieT SET literal=?, sort=? WHERE id=?';
const SQL_SELECT_PK='SELECT KategorieT.* FROM KategorieT WHERE id=?';
const SQL_SELECT_ALL='SELECT KategorieT.* FROM KategorieT';
const SQL_DELETE='DELETE FROM KategorieT WHERE id=?';
const SQL_PRIMARY='id';
}
KategorieT::$dataScheme=db::buildScheme("KategorieT");
$fp = fopen("models/json/KategorieT_complete.json", "w");
fwrite($fp, json_encode(db::buildScheme("KategorieT"),JSON_UNESCAPED_UNICODE));
fclose($fp);
KategorieT::$settings=db::loadSettings("KategorieT");
$fp = fopen("models/json/KategorieT_settings_complete.json", "w");
fwrite($fp, json_encode(KategorieT::$settings,JSON_UNESCAPED_UNICODE));
fclose($fp);
