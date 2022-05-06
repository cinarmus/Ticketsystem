<?php
$HSMitarbeiter = Core::$view->HSMitarbeiter;
$HSMitarbeiter_list = Core::$view->HSMitarbeiter_list ;
if (isset($_GET['task_source'])){
$task_source = $_GET['task_source'];
}else{
$task_source = "HSMitarbeiter";
}
if ($_GET['task'] == "user_edit"){
$task_source = "user_edit";
}
if ($task_source!="user_edit"){
$Favoriten=new Favoriten();
$icon=$Favoriten->find_task("HSMitarbeiter_edit",$_SESSION['uid']);
if ($icon =="star"){
$hover = "hinzufügen";
}else{
$hover = "entfernen";
}
?>
<a href="?task=<?=$task_source?>&id=<?=$HSMitarbeiter->id?>" data-ajax="false" class="ui-btn ui-icon-back ui-btn-icon-notext ui-corner-all" align="right" style="display:inline-block;">No text</a>
<div class="tooltip_hs" style="margin-left:20px;position:absolute">
<a href="?task=favoriten&db_task=HS-Mitarbeiter_edit&icon=<?=$icon?>&id=<?=$HSMitarbeiter->id?>" class="ui-nodisc-icon ui-alt-icon" data-ajax="false" data-role="button" data-icon="<?=$icon?>" data-iconpos="notext" data-theme="b" data-inline="true" ></a>
<span style="font-size: 15px" class="tooltiptext">Favorit <?=$hover?></span>
</div>
<?php
}
?>
<form id="form_HSMitarbeiter" method="post" action="?task=HSMitarbeiter_edit&id=<?=$HSMitarbeiter->id?>&task_source=<?=$task_source?>" data-ajax="false" enctype="<?=$HSMitarbeiter::$enctype?>">
<div class="ui-field-contain">
<?php
$HSMitarbeiter->renderLabel("id");
$HSMitarbeiter->render("id");
$HSMitarbeiter->renderLabel("c_ts");
$HSMitarbeiter->render("c_ts");
$HSMitarbeiter->renderLabel("m_ts");
$HSMitarbeiter->render("m_ts");
$HSMitarbeiter->renderLabel("Name_Vorname");
$HSMitarbeiter->render("Name_Vorname");
$HSMitarbeiter->renderLabel("Name_Nachname");
$HSMitarbeiter->render("Name_Nachname");
$HSMitarbeiter->renderLabel("Adresse_Straße");
$HSMitarbeiter->render("Adresse_Straße");
$HSMitarbeiter->renderLabel("Adresse_PLZ");
$HSMitarbeiter->render("Adresse_PLZ");
$HSMitarbeiter->renderLabel("Adresse_Ort");
$HSMitarbeiter->render("Adresse_Ort");
$HSMitarbeiter->renderLabel("_User_uid");
$HSMitarbeiter->render("_User_uid");
?>
<button type="submit" name="update" id="update" value="1" style="width:100%">update</button>
</div>
</form>
