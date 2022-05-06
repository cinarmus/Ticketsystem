<?php
$referrer=Core::import("referrer");
$autocomplete=Core::import("autocomplete");

$Favoriten=new Favoriten();
$icon=$Favoriten->find_task("HSMitarbeiter_new",$_SESSION['uid']);
if ($icon =="star"){
$hover = "hinzufügen";
}else{
$hover = "entfernen";
}

$HSMitarbeiter = Core::$view->HSMitarbeiter;

if($_POST["registrieren"] != "1"){
$task_source = "HSMitarbeiter_new";
$task = "HSMitarbeiter";
}else{
$task_source = $_GET['task'];
}

if(!isset($referrer) && $_POST["registrieren"] != "1"){ ?>

<a href="?task=<?=$task?>" class="ui-btn ui-icon-back ui-btn-icon-notext ui-corner-all" align="right" style="display:inline-block;" data-ajax=false>No text</a>
<div class="tooltip_hs" style="margin-left:20px;position:absolute">
<a href="?task=favoriten&db_task=HS-Mitarbeiter_new&icon=<?=$icon?>" class="ui-nodisc-icon ui-alt-icon" data-ajax="false" data-role="button" data-icon="<?=$icon?>" data-iconpos="notext" data-theme="b" data-inline="true" ></a>
<span style="font-size: 15px" class="tooltiptext">Favorit <?=$hover?></span>
</div>

<?php } ?>


<form id="form_HSMitarbeiter" method="post" action="?task=HSMitarbeiter_new&task_source=<?=$task_source?>" data-ajax="false" <?php if(isset($autocomplete)){ ?> autocomplete="on" <?php } ?> enctype="<?=$HSMitarbeiter::$enctype?>">

<?php if($_POST["registrieren"] == "1"){ ?>
<h3 class="groupheading">Sie müssen erst noch Ihre Profildaten pflegen, bevor Sie sich anmelden können</h3>
<?php } ?>

<div class="ui-field-contain">
<?php
$HSMitarbeiter = Core::$view->HSMitarbeiter;
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
