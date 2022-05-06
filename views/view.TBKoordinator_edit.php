<?php
$TBKoordinator = Core::$view->TBKoordinator;
$TBKoordinator_list = Core::$view->TBKoordinator_list ;
if (isset($_GET['task_source'])){
$task_source = $_GET['task_source'];
}else{
$task_source = "TBKoordinator";
}
if ($_GET['task'] == "user_edit"){
$task_source = "user_edit";
}
if ($task_source!="user_edit"){
$Favoriten=new Favoriten();
$icon=$Favoriten->find_task("TBKoordinator_edit",$_SESSION['uid']);
if ($icon =="star"){
$hover = "hinzufügen";
}else{
$hover = "entfernen";
}
?>
<a href="?task=<?=$task_source?>&id=<?=$TBKoordinator->id?>" data-ajax="false" class="ui-btn ui-icon-back ui-btn-icon-notext ui-corner-all" align="right" style="display:inline-block;">No text</a>
<div class="tooltip_hs" style="margin-left:20px;position:absolute">
<a href="?task=favoriten&db_task=TB-Koordinator_edit&icon=<?=$icon?>&id=<?=$TBKoordinator->id?>" class="ui-nodisc-icon ui-alt-icon" data-ajax="false" data-role="button" data-icon="<?=$icon?>" data-iconpos="notext" data-theme="b" data-inline="true" ></a>
<span style="font-size: 15px" class="tooltiptext">Favorit <?=$hover?></span>
</div>
<?php
}
?>
<form id="form_TBKoordinator" method="post" action="?task=TBKoordinator_edit&id=<?=$TBKoordinator->id?>&task_source=<?=$task_source?>" data-ajax="false" enctype="<?=$TBKoordinator::$enctype?>">
<div class="ui-field-contain">
<?php
$TBKoordinator->renderLabel("id");
$TBKoordinator->render("id");
$TBKoordinator->renderLabel("c_ts");
$TBKoordinator->render("c_ts");
$TBKoordinator->renderLabel("m_ts");
$TBKoordinator->render("m_ts");
$TBKoordinator->renderLabel("Name_Vorname");
$TBKoordinator->render("Name_Vorname");
$TBKoordinator->renderLabel("Name_Nachname");
$TBKoordinator->render("Name_Nachname");
$TBKoordinator->renderLabel("Adresse_Straße");
$TBKoordinator->render("Adresse_Straße");
$TBKoordinator->renderLabel("Adresse_PLZ");
$TBKoordinator->render("Adresse_PLZ");
$TBKoordinator->renderLabel("Adresse_Ort");
$TBKoordinator->render("Adresse_Ort");
$TBKoordinator->renderLabel("_User_uid");
$TBKoordinator->render("_User_uid");
?>
<button type="submit" name="update" id="update" value="1" style="width:100%">update</button>
</div>
</form>
