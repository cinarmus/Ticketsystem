<?php
class Ticket extends DB{

//Variablenliste
public $id;
public $c_ts;
public $m_ts;
public static $settings=array();
public static $access = true;
public $datum;
public $Bemerkung;
public $Frist;
public $Status;
public $Kategorie;
public $Priorität;
public $Anhang;
public $_TBKoordinator;
public $_TBMitarbeiter;
public $ts;

public $dataMapping=array(); // damit ein eigenes statisches Array entsteht. Sonst ist es DB::$dataScheme

public static $dataScheme=array(); // damit ein eigenes statisches Array entsteht. Sonst ist es DB::$dataScheme

//Konstanten
const SQL_INSERT='INSERT INTO Ticket (_TBKoordinator, _TBMitarbeiter, `datum` , `Bemerkung` , `Frist` , `Status` , `Kategorie` , `Priorität` , `Anhang` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
const SQL_UPDATE='UPDATE Ticket SET _TBKoordinator=?, _TBMitarbeiter=?, `datum` =?, `Bemerkung` =?, `Frist` =?, `Status` =?, `Kategorie` =?, `Priorität` =?, `Anhang` =? where id=?';
const SQL_SELECT_PK='SELECT Ticket.`c_ts` as `c_ts`, Ticket.`m_ts` as `m_ts`, Ticket.`id` as `id`, Ticket._TBKoordinator as _TBKoordinator, Ticket._TBMitarbeiter as _TBMitarbeiter, `Ticket`.`datum` as `datum`, `Ticket`.`Bemerkung` as `Bemerkung`, `Ticket`.`Frist` as `Frist`, `StatusT0`.`literal` as `Status_literal`, `Ticket`.`Status` as `Status`, `KategorieT1`.`literal` as `Kategorie_literal`, `Ticket`.`Kategorie` as `Kategorie`, `PrioritätT2`.`literal` as `Priorität_literal`, `Ticket`.`Priorität` as `Priorität`, `Ticket`.`Anhang` as `Anhang` from Ticket left join `StatusT` as StatusT0 on `Ticket`.`Status` = `StatusT0`.`id`  left join `KategorieT` as KategorieT1 on `Ticket`.`Kategorie` = `KategorieT1`.`id`  left join `PrioritätT` as PrioritätT2 on `Ticket`.`Priorität` = `PrioritätT2`.`id`  where Ticket.`id` = ?';
const SQL_SELECT_ALL='SELECT Ticket.`c_ts` as `c_ts`, Ticket.`m_ts` as `m_ts`, Ticket.`id` as `id`, Ticket._TBKoordinator as _TBKoordinator, Ticket._TBMitarbeiter as _TBMitarbeiter, `Ticket`.`datum` as `datum`, `Ticket`.`Bemerkung` as `Bemerkung`, `Ticket`.`Frist` as `Frist`, `StatusT0`.`literal` as `Status_literal`, `Ticket`.`Status` as `Status`, `KategorieT1`.`literal` as `Kategorie_literal`, `Ticket`.`Kategorie` as `Kategorie`, `PrioritätT2`.`literal` as `Priorität_literal`, `Ticket`.`Priorität` as `Priorität`, `Ticket`.`Anhang` as `Anhang` from Ticket left join `StatusT` as StatusT0 on `Ticket`.`Status` = `StatusT0`.`id`  left join `KategorieT` as KategorieT1 on `Ticket`.`Kategorie` = `KategorieT1`.`id`  left join `PrioritätT` as PrioritätT2 on `Ticket`.`Priorität` = `PrioritätT2`.`id` ';
const SQL_SELECT_IGNORE_DERIVED='SELECT DISTINCT Ticket.`c_ts` as `c_ts`, Ticket.`m_ts` as `m_ts`, Ticket.`id` as `id`, Ticket._TBKoordinator as _TBKoordinator, Ticket._TBMitarbeiter as _TBMitarbeiter, `Ticket`.`datum` as `datum`, `Ticket`.`Bemerkung` as `Bemerkung`, `Ticket`.`Frist` as `Frist`, `StatusT0`.`literal` as `Status_literal`, `Ticket`.`Status` as `Status`, `KategorieT1`.`literal` as `Kategorie_literal`, `Ticket`.`Kategorie` as `Kategorie`, `PrioritätT2`.`literal` as `Priorität_literal`, `Ticket`.`Priorität` as `Priorität`, `Ticket`.`Anhang` as `Anhang` from Ticket left join `StatusT` as StatusT0 on `Ticket`.`Status` = `StatusT0`.`id`  left join `KategorieT` as KategorieT1 on `Ticket`.`Kategorie` = `KategorieT1`.`id`  left join `PrioritätT` as PrioritätT2 on `Ticket`.`Priorität` = `PrioritätT2`.`id` ';
const SQL_DELETE='DELETE FROM Ticket WHERE id=?';
const SQL_PRIMARY='id';

const SQL_SELECT_TBKoordinator='select Ticket.id as id, Ticket.datum as datum, Ticket.Bemerkung as Bemerkung, Ticket.Frist as Frist, `StatusT0`.`literal` as `Status_literal`, `Ticket`.`Status` as `Status`, `KategorieT1`.`literal` as `Kategorie_literal`, `Ticket`.`Kategorie` as `Kategorie`, `PrioritätT2`.`literal` as `Priorität_literal`, `Ticket`.`Priorität` as `Priorität`, Ticket.Anhang as Anhang from Ticket left join `StatusT` as StatusT0 on `Ticket`.`Status` = `StatusT0`.`id`  left join `KategorieT` as KategorieT1 on `Ticket`.`Kategorie` = `KategorieT1`.`id`  left join `PrioritätT` as PrioritätT2 on `Ticket`.`Priorität` = `PrioritätT2`.`id`  where Ticket._TBKoordinator = ?';
const SQL_SELECT_TBMitarbeiter='select Ticket.id as id, Ticket.datum as datum, Ticket.Bemerkung as Bemerkung, Ticket.Frist as Frist, `StatusT0`.`literal` as `Status_literal`, `Ticket`.`Status` as `Status`, `KategorieT1`.`literal` as `Kategorie_literal`, `Ticket`.`Kategorie` as `Kategorie`, `PrioritätT2`.`literal` as `Priorität_literal`, `Ticket`.`Priorität` as `Priorität`, Ticket.Anhang as Anhang from Ticket left join `StatusT` as StatusT0 on `Ticket`.`Status` = `StatusT0`.`id`  left join `KategorieT` as KategorieT1 on `Ticket`.`Kategorie` = `KategorieT1`.`id`  left join `PrioritätT` as PrioritätT2 on `Ticket`.`Priorität` = `PrioritätT2`.`id`  where Ticket._TBMitarbeiter = ?';
const SQL_SELECT_HSMitarbeiter_b = 'select Ticket.id as id, Ticket_HSMitarbeiter.id as zwkls_id, Ticket.datum as datum, Ticket.Bemerkung as Bemerkung, Ticket.Frist as Frist, `StatusT0`.`literal` as `Status_literal`, `Ticket`.`Status` as `Status`, `KategorieT1`.`literal` as `Kategorie_literal`, `Ticket`.`Kategorie` as `Kategorie`, `PrioritätT2`.`literal` as `Priorität_literal`, `Ticket`.`Priorität` as `Priorität`, Ticket.Anhang as Anhang from Ticket inner join Ticket_HSMitarbeiter on Ticket.id = Ticket_HSMitarbeiter._Ticket_ticket_erstellen  left join `StatusT` as StatusT0 on `Ticket`.`Status` = `StatusT0`.`id`  left join `KategorieT` as KategorieT1 on `Ticket`.`Kategorie` = `KategorieT1`.`id`  left join `PrioritätT` as PrioritätT2 on `Ticket`.`Priorität` = `PrioritätT2`.`id`   where Ticket_HSMitarbeiter._HSMitarbeiter_b = ?';
}

Ticket::$dataScheme=db::buildScheme("Ticket");
$fp = fopen("models/json/Ticket_complete.json", "w");
fwrite($fp, json_encode(Ticket::$dataScheme,JSON_UNESCAPED_UNICODE));
fclose($fp);
Ticket::$settings=db::loadSettings("Ticket");
$fp = fopen("models/json/Ticket_settings_complete.json", "w");
fwrite($fp, json_encode(Ticket::$settings,JSON_UNESCAPED_UNICODE));
fclose($fp);
