<?php
class Ticket_HSMitarbeiter extends DB{
//Variablenliste
public $id;
public $c_ts;
public $m_ts;
public $_Ticket_ticket_erstellen;
public $_HSMitarbeiter_b;
public $dataMapping=array(); // damit ein eigenes statisches Array entsteht. Sonst ist es DB::$dataScheme
public static $dataScheme=array(); // damit ein eigenes statisches Array entsteht. Sonst ist es DB::$dataScheme
//Konstanten
const SQL_INSERT='INSERT INTO Ticket_HSMitarbeiter (_Ticket_ticket_erstellen, _HSMitarbeiter_b) VALUES (?, ?)';
const SQL_DELETE='DELETE FROM Ticket_HSMitarbeiter WHERE id=?';
const SQL_PRIMARY='id';
}
