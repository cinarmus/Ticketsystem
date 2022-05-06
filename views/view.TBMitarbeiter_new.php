<?php
$referrer=Core::import("referrer");
$autocomplete=Core::import("autocomplete");

$Favoriten=new Favoriten();
$icon=$Favoriten->find_task("TBMitarbeiter_new",$_SESSION['uid']);
if ($icon =="star"){
$hover = "hinzufügen";
}else{
$hover = "entfernen";
}

$TBMitarbeiter = Core::$view->TBMitarbeiter;

if($_POST["registrieren"] != "1"){
$task_source = "TBMitarbeiter_new";
$task = "TBMitarbeiter";
}else{
$task_source = $_GET['task'];
}

if(!isset($referrer) && $_POST["registrieren"] != "1"){ ?>

<a href="?task=<?=$task?>" class="ui-btn ui-icon-back ui-btn-icon-notext ui-corner-all" align="right" style="display:inline-block;" data-ajax=false>No text</a>
<div class="tooltip_hs" style="margin-left:20px;position:absolute">
<a href="?task=favoriten&db_task=TB-Mitarbeiter_new&icon=<?=$icon?>" class="ui-nodisc-icon ui-alt-icon" data-ajax="false" data-role="button" data-icon="<?=$icon?>" data-iconpos="notext" data-theme="b" data-inline="true" ></a>
<span style="font-size: 15px" class="tooltiptext">Favorit <?=$hover?></span>
</div>

<?php } ?>


<form id="form_TBMitarbeiter" method="post" action="?task=TBMitarbeiter_new&task_source=<?=$task_source?>" data-ajax="false" <?php if(isset($autocomplete)){ ?> autocomplete="on" <?php } ?> enctype="<?=$TBMitarbeiter::$enctype?>">

<?php if($_POST["registrieren"] == "1"){ ?>
<h3 class="groupheading">Sie müssen erst noch Ihre Profildaten pflegen, bevor Sie sich anmelden können</h3>
<?php } ?>

<div class="ui-field-contain">
<?php
$TBMitarbeiter = Core::$view->TBMitarbeiter;
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

if(!isset($referrer)){
   if ($_POST["registrieren"] == "1"){ ?>
   <button type="submit" onclick="BezHinweis()" name="registrieren-ng" id="registrieren-ng" value="1" style="width:100%">speichern</button>
   <?php }else{ ?>
   <button type="submit" onclick="BezHinweis()" name="update" id="update" value="1" style="width:100%">speichern</button>
   <?php }
}else{ ?>
<div id="action" style="text-align:center">
<a type="button" name="back" id="cancel" data-ajax="false" href="?task=<?=$referrer?>" class=" ui-btn ui-shadow ui-corner-all ui-btn-inline ui-icon-delete ui-btn-icon-left" style="width:18%;margin:30px;20px;" data-ajax=false>abbrechen</a>
<button type="submit" name="back" id="back" data-ajax="false" value="<?=$referrer?>" class=" ui-btn ui-shadow ui-corner-all ui-btn-inline ui-icon-check ui-btn-icon-left" style="width:25%;margin:30px;20px;" data-ajax=false>speichern</button>
</div>
<?php } ?>

</div>
</form>
<script>
</script>
