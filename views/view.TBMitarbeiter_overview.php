<?php
$TBMitarbeiter_list=Core::$view->TBMitarbeiter_list;
$TBMitarbeiter=Core::$view->TBMitarbeiter;
$access=Core::import("access");
$Favoriten=new Favoriten();
$icon=$Favoriten->find_task("TBMitarbeiter",$_SESSION['uid']);
if ($icon =="star"){
$hover = "hinzufügen";
}else{
$hover = "entfernen";
}
?>
<div data-role="ui-bar ui-bar-a">
<h1>Übersichtsseite TB-Mitarbeiter

<?php if(Core::$user->Gruppe >0){ ?>
<div class="tooltip_hs">
<a href="?task=favoriten&db_task=TB-Mitarbeiter&icon=<?=$icon?>" class="ui-nodisc-icon ui-alt-icon" data-ajax="false" data-role="button" data-icon="<?=$icon?>" data-iconpos="notext" data-theme="b" data-inline="true"></a>
<span style="font-size: 15px" class="tooltiptext">Favorit <?=$hover?></span>
</div>
<?php } ?>

</h1>
</div>
<form>
<input id="filterTable-input" data-type="search">
</form>
<div class="overflowx">
<table data-role="table" id="tbl_TBMitarbeiter" data-filter="true" data-input="#filterTable-input" class="ui-responsive" data-mode="columntoggle" data-column-btn-theme="b" data-column-btn-text="Spalten" data-column-popup-theme="a">
<thead>
<tr>
<?php $TBMitarbeiter->renderHeader("id", "table"); ?>
<?php $TBMitarbeiter->renderHeader("c_ts", "table"); ?>
<?php $TBMitarbeiter->renderHeader("m_ts", "table"); ?>
<?php $TBMitarbeiter->renderHeader("Abteilung", "table"); ?>
<?php $TBMitarbeiter->renderHeader("Name_Vorname", "table"); ?>
<?php $TBMitarbeiter->renderHeader("Name_Nachname", "table"); ?>
<?php $TBMitarbeiter->renderHeader("Adresse_Straße", "table"); ?>
<?php $TBMitarbeiter->renderHeader("Adresse_PLZ", "table"); ?>
<?php $TBMitarbeiter->renderHeader("Adresse_Ort", "table"); ?>
<?php $TBMitarbeiter->renderHeader("_User_uid", "table"); ?>
<th></th>
</tr>
</thead>
<tbody>
<?php foreach($TBMitarbeiter_list as $klasse){
?>
<tr>
<?php $klasse->render("id"); ?>
<?php $klasse->render("c_ts"); ?>
<?php $klasse->render("m_ts"); ?>
<?php $klasse->render("Abteilung"); ?>
<?php $klasse->render("Name_Vorname"); ?>
<?php $klasse->render("Name_Nachname"); ?>
<?php $klasse->render("Adresse_Straße"); ?>
<?php $klasse->render("Adresse_PLZ"); ?>
<?php $klasse->render("Adresse_Ort"); ?>
<?php $klasse->render("_User_uid"); ?>
<td>
<?php if($access["detail"] == "true"){ ?>
<a href="?task=TBMitarbeiter_detail&id=<?=$klasse->id?>" data-ajax="false" data-role="button"  class="ui-btn ui-icon-eye ui-btn-icon-notext ui-corner-all ui-btn-inline">show</a>
<?php } ?>
<?php if($access["edit"] == "true"){ ?>
<a href="?task=TBMitarbeiter_edit&id=<?=$klasse->id?>&task_source=TBMitarbeiter" data-ajax="false" data-role="button"  class="ui-btn ui-icon-pencil ui-btn-icon-notext ui-corner-all ui-btn-inline">edit</a>
<?php } ?>
<?php if($access["delete"] == "true"){ ?>
<a href="?task=TBMitarbeiter_delete&id=<?=$klasse->id?>" data-ajax="false" data-role="button"  class="ui-btn ui-icon-delete ui-btn-icon-notext ui-corner-all ui-btn-inline" onclick="return confirm("Soll der Datensatz mit der ID: <?=$Klasse->id." wirklich gelöscht werden?"?>")">delete</a>
<?php } ?>
</td>
</tr>
<?php
        }
        ?>
</tbody>
</table>
</div>
<?php if($access["new"] == "true"){ ?>
<a href="?task=TBMitarbeiter_new" class="ui-btn ui-btn-b ui-icon-plus ui-btn-icon-left" data-ajax="false">Neuanlegen</a><br>
<?php } ?>
<br>
