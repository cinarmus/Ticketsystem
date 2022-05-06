<?php
$TBMitarbeiter = Core::$view->TBMitarbeiter;
$TBMitarbeiter_list = Core::$view->TBMitarbeiter_list ;
if (isset($_GET['task_source'])){
$task_source = $_GET['task_source'];
}else{
$task_source = "TBMitarbeiter";
}
if ($_GET['task'] == "user_edit"){
$task_source = "user_edit";
}
if ($task_source!="user_edit"){
$Favoriten=new Favoriten();
$icon=$Favoriten->find_task("TBMitarbeiter_edit",$_SESSION['uid']);
if ($icon =="star"){
$hover = "hinzufügen";
}else{
$hover = "entfernen";
}
?>
<a href="?task=<?=$task_source?>&id=<?=$TBMitarbeiter->id?>" data-ajax="false" class="ui-btn ui-icon-back ui-btn-icon-notext ui-corner-all" align="right" style="display:inline-block;">No text</a>
<div class="tooltip_hs" style="margin-left:20px;position:absolute">
<a href="?task=favoriten&db_task=TB-Mitarbeiter_edit&icon=<?=$icon?>&id=<?=$TBMitarbeiter->id?>" class="ui-nodisc-icon ui-alt-icon" data-ajax="false" data-role="button" data-icon="<?=$icon?>" data-iconpos="notext" data-theme="b" data-inline="true" ></a>
<span style="font-size: 15px" class="tooltiptext">Favorit <?=$hover?></span>
</div>
<?php
}
?>
<form id="form_TBMitarbeiter" method="post" action="?task=TBMitarbeiter_edit&id=<?=$TBMitarbeiter->id?>&task_source=<?=$task_source?>" data-ajax="false" enctype="<?=$TBMitarbeiter::$enctype?>">
<div class="ui-field-contain">
<?php
$TBMitarbeiter->renderLabel("id");
$TBMitarbeiter->render("id");
$TBMitarbeiter->renderLabel("c_ts");
$TBMitarbeiter->render("c_ts");
$TBMitarbeiter->renderLabel("m_ts");
$TBMitarbeiter->render("m_ts");
$TBMitarbeiter->renderLabel("Abteilung");
$TBMitarbeiter->render("Abteilung");
$TBMitarbeiter->renderLabel("Name_Vorname");
$TBMitarbeiter->render("Name_Vorname");
$TBMitarbeiter->renderLabel("Name_Nachname");
$TBMitarbeiter->render("Name_Nachname");
$TBMitarbeiter->renderLabel("Adresse_Straße");
$TBMitarbeiter->render("Adresse_Straße");
$TBMitarbeiter->renderLabel("Adresse_PLZ");
$TBMitarbeiter->render("Adresse_PLZ");
$TBMitarbeiter->renderLabel("Adresse_Ort");
$TBMitarbeiter->render("Adresse_Ort");
$TBMitarbeiter->renderLabel("_User_uid");
$TBMitarbeiter->render("_User_uid");
?>
<button type="submit" name="update" id="update" value="1" style="width:100%">update</button>
</div>
</form>
