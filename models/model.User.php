<?php
class User extends DB{

//Variablenliste
public $id;
public $c_ts;
public $m_ts;
public static $settings=array();
public $Passwort;
public $Gruppe;
public $Kennung;
public $roleid;
public $ts;

public $dataMapping=array(); // damit ein eigenes statisches Array entsteht. Sonst ist es DB::$dataScheme

public static $dataScheme=array(); // damit ein eigenes statisches Array entsteht. Sonst ist es DB::$dataScheme

//Konstanten
const SQL_SELECT_PK='SELECT User.`c_ts` as `c_ts`, User.`m_ts` as `m_ts`, User.`id` as `id`, `User`.`Passwort` as `Passwort`, `GruppeT0`.`literal` as `Gruppe_literal`, `User`.`Gruppe` as `Gruppe`, `User`.`Kennung` as `Kennung`, `User`.`roleid` as `roleid` from User left join `GruppeT` as GruppeT0 on `User`.`Gruppe` = `GruppeT0`.`id`  where User.`id` = ?';
const SQL_SELECT_ALL='SELECT User.`c_ts` as `c_ts`, User.`m_ts` as `m_ts`, User.`id` as `id`, `User`.`Passwort` as `Passwort`, `GruppeT0`.`literal` as `Gruppe_literal`, `User`.`Gruppe` as `Gruppe`, `User`.`Kennung` as `Kennung`, `User`.`roleid` as `roleid` from User left join `GruppeT` as GruppeT0 on `User`.`Gruppe` = `GruppeT0`.`id` ';
const SQL_SELECT_IGNORE_DERIVED='SELECT DISTINCT User.`c_ts` as `c_ts`, User.`m_ts` as `m_ts`, User.`id` as `id`, `User`.`Passwort` as `Passwort`, `GruppeT0`.`literal` as `Gruppe_literal`, `User`.`Gruppe` as `Gruppe`, `User`.`Kennung` as `Kennung`, `User`.`roleid` as `roleid` from User left join `GruppeT` as GruppeT0 on `User`.`Gruppe` = `GruppeT0`.`id` ';
const SQL_DELETE='DELETE FROM User WHERE id=?';
const SQL_PRIMARY='id';

const SQL_SELECT_TBKoordinator_uid='select User.id as id, User.Passwort as Passwort, `GruppeT0`.`literal` as `Gruppe_literal`, `User`.`Gruppe` as `Gruppe`, User.Kennung as Kennung, User.roleid as roleid from User left join `GruppeT` as GruppeT0 on `User`.`Gruppe` = `GruppeT0`.`id`  where `User`.`id` = (select _User_uid from TBKoordinator where id=?)';
const SQL_SELECT_TBMitarbeiter_uid='select User.id as id, User.Passwort as Passwort, `GruppeT0`.`literal` as `Gruppe_literal`, `User`.`Gruppe` as `Gruppe`, User.Kennung as Kennung, User.roleid as roleid from User left join `GruppeT` as GruppeT0 on `User`.`Gruppe` = `GruppeT0`.`id`  where `User`.`id` = (select _User_uid from TBMitarbeiter where id=?)';
const SQL_SELECT_HSMitarbeiter_uid='select User.id as id, User.Passwort as Passwort, `GruppeT0`.`literal` as `Gruppe_literal`, `User`.`Gruppe` as `Gruppe`, User.Kennung as Kennung, User.roleid as roleid from User left join `GruppeT` as GruppeT0 on `User`.`Gruppe` = `GruppeT0`.`id`  where `User`.`id` = (select _User_uid from HSMitarbeiter where id=?)';

const SQL_INSERT='INSERT INTO User (`Passwort` , `Gruppe` , `Kennung` , `roleid` ) VALUES (md5(?),?,?,?)';
const SQL_UPDATE_PASSWORD='UPDATE User SET Passwort=md5(?) Where id=?';
const SQL_LOGIN="SELECT * FROM User WHERE Kennung=? AND Passwort=md5(?)";
public function login(){
    // Prüfung, ob Kennung bereits vorhanden 
    
    $param=[$this->Kennung1,$this->Passwort1];
    $result=$this->query(self::SQL_LOGIN, $param);
    if($result){
        $this->import($result);
        Core::$user=$this;
        $_SESSION['uid']=$this->id;
        return true;
    }else{
        Core::addError("Fehler bei Anmeldung");
        return false;
        
    }   
}

public function checkProfile() {
        $gruppe = new GruppeT();
        $gruppe->loadDBData($this->Gruppe);
        if (class_exists($gruppe->literal) && $gruppe->literal!="user" && $gruppe->literal!="User") {
            $profil = $gruppe->literal;
            $SQL = "SELECT * FROM User INNER JOIN $profil ON $profil._User_uid=User.id WHERE User.id=?";
            $result = $this->query($SQL, [$this->id]);
            if (count($result) > 0) {
                return $result[0]->id;
            } else {
                return false;
            }
        } else {
            return -1; // Es gibt keine eigene Userklasse hierfür, daher keine separaten Profildaten
        }
}

public  function logout(){
	$_SESSION['uid']="";
	$_SESSION['fullName']="";
        session_destroy();
    
        foreach ($this as $key => $value) {
            $this->$key = null;  //set to null instead of unsetting
        }      
}
public function updatePassword(){
    if($this->Passwort!=""){
        $this->query(self::SQL_UPDATE_PASSWORD,[$this->Passwort,$this->id]);
        return true;
    }else{
        return false;
    }
}

public function alreadyUser(){
      $SQL="SELECT * FROM User WHERE Kennung=?";
    $result=$this->query($SQL,[$this->Kennung]);
    if(count($result)>0){
        Core::addError("Dieses Konto existiert bereits");
        return true;
    }else{
        return false;
    }
}
 public function enumerationen(){
$enumerationen = array();
$Abteilung = AbteilungT::findAll();
$enumerationen["Abteilung"] = $Abteilung;
return $enumerationen;
}
}

User::$dataScheme=db::buildScheme("User");
$fp = fopen("models/json/User_complete.json", "w");
fwrite($fp, json_encode(User::$dataScheme,JSON_UNESCAPED_UNICODE));
fclose($fp);
User::$settings=db::loadSettings("User");
$fp = fopen("models/json/User_settings_complete.json", "w");
fwrite($fp, json_encode(User::$settings,JSON_UNESCAPED_UNICODE));
fclose($fp);
