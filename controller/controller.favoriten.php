<?php
Core::checkAccessLevel(1);
if (isset($_GET['task'])) {
    $task = $_GET['db_task'];
    $icon = $_GET['icon'];
    $Favoriten= new Favoriten();
    if ($icon == "star") {
        if (isset($_GET['id'])){
            $Favoriten->datensatz_id = $_GET['id'];
        }else{
            $Favoriten->datensatz_id = NULL;
        }
        $Favoriten->User_uid = $_SESSION['uid'];
        $Favoriten->task = $task;
        $Favoriten->task_label =$Favoriten->set_label($task);
        $result=$Favoriten->create();
    }elseif($icon == "delete"){
        $result=$Favoriten->delete_favoriten($task,$_SESSION['uid']);
    }
    if (isset($_GET['id'])){
        $option['id']=$_GET['id'];
    }else{
        $option=array();
    }
    Core::redirect($task,$option);
}