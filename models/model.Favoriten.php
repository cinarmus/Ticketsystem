<?php
class Favoriten extends DB{

//Variablenliste
    public $id;
    public $c_ts;
    public $m_ts;
    public $task;
    public $task_label;
    public $datensatz_id;

    public $dataMapping=array(); // damit ein eigenes statisches Array entsteht. Sonst ist es DB::$dataScheme

    public static $dataScheme=array(); // damit ein eigenes statisches Array entsteht. Sonst ist es DB::$dataScheme

//Konstanten
    const SQL_INSERT='INSERT INTO Favoriten (task,task_label,datensatz_id,User_uid) VALUES (?,?,?,?)';
    const SQL_UPDATE_TASK_LABEL='UPDATE Favoriten SET task_label=? WHERE id=?';
    const SQL_SELECT_PK='SELECT Favoriten.`c_ts` as `c_ts`, Favoriten.`m_ts` as `m_ts`, Favoriten.`id` as `id`,Favoriten.`task` as `task`, Favoriten.`task_label` as `task_label`, Favoriten.`datensatz_id` as `datensatz_id` , Favoriten.`User_uid` as `User_uid` from Favoriten where Favoriten.`id` = ?';
    const SQL_SELECT_TASK='SELECT Favoriten.`c_ts` as `c_ts`, Favoriten.`m_ts` as `m_ts`, Favoriten.`id` as `id`,Favoriten.`task` as `task`, Favoriten.`task_label` as `task_label`,Favoriten.`datensatz_id` as `datensatz_id`,Favoriten.`User_uid` as `User_uid` from Favoriten where Favoriten.`task` = ? AND Favoriten.`User_uid` = ?';
    const SQL_SELECT_ALL='SELECT Favoriten.`c_ts` as `c_ts`, Favoriten.`m_ts` as `m_ts`, Favoriten.`id` as `id`,Favoriten.`task` as `task`, Favoriten.`task_label` as `task_label`,Favoriten.`datensatz_id` as `datensatz_id` ,Favoriten.`User_uid` as `User_uid` from Favoriten WHERE Favoriten.`User_uid` =?';
    const SQL_DELETE='DELETE FROM Favoriten WHERE id=?';
    const SQL_DELETE_TASK='DELETE FROM Favoriten WHERE task=? AND User_uid=?';
    const SQL_PRIMARY='task';
    public function find_task($task,$userid){
        $Favoriten=new Favoriten();
        $result = $Favoriten->query(Favoriten::SQL_SELECT_TASK, [$task,$userid]);
        if (count($result)>0){
            return "delete";
        }else{
            return "star";
        }
    }
    
    public function delete_favoriten($task,$userid){
        $db = Core::$pdo;
        $Favoriten=new Favoriten();
        $stmt = $db->prepare(Favoriten::SQL_DELETE_TASK); // SQL-Anweisung
        $result = $stmt->execute([$task,$userid]);
        if ($result){
            return true;
        } else {
            return false;
        }
    }
    public function update_label($task,$id){
        $db = Core::$pdo;
        $Favoriten=new Favoriten();
        $stmt = $db->prepare(Favoriten::SQL_UPDATE_TASK_LABEL); // SQL-Anweisung
        $result = $stmt->execute([$task,$id]);
        if ($result){
            return true;
        } else {
            return false;
        }
    }
    public function set_label($task){
        $explode = explode("_",$task);
        if (count($explode)==1){
            return ucfirst($explode[0])." Übersicht";
        }elseif(count($explode)==2){
            $viewport = $explode[1];
            switch ($viewport){
                case "new":
                    $add = " anlegen";
                    break;
                case "edit":
                    $add = " ändern";
                    break;
                case "detail":
                    $add = " Detailansicht";
                    break;
            }
            if ($add == ""){
                return ucfirst($task)." Übersicht";
            }else{
                return ucfirst($explode[0]).$add;
            }
        }else{
            $viewport = $explode[count($explode)-1];
            switch ($viewport){
                case "new":
                    $add = " anlegen";
                    break;
                case "edit":
                    $add = " ändern";
                    break;
                case "detail":
                    $add = " Detailansicht";
                    break;
            }
            if ($add == ""){
                return ucfirst($task);
            }else{
                $label="";
                $x=1;
                foreach ($explode as $item){
                    if ($x==1){
                        $label = $item;
                    }elseif(count($explode)>$x) {
                        $label = $label . "_" . $item;
                    }
                    $x++;
                }
                return ucfirst($label).$add;
            }
        }
    }
}

Favoriten::$dataScheme=db::buildScheme("Favoriten");
$fp = fopen("models/json/Favoriten_complete.json", "w");
fwrite($fp, json_encode(Favoriten::$dataScheme,JSON_UNESCAPED_UNICODE));
fclose($fp);
Favoriten::$settings=db::loadSettings("Favoriten");
$fp = fopen("models/json/Favoriten_settings_complete.json", "w");
fwrite($fp, json_encode(Favoriten::$settings,JSON_UNESCAPED_UNICODE));
fclose($fp);
