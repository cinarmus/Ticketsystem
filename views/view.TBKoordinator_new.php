<?php
$referrer=Core::import("referrer");
$autocomplete=Core::import("autocomplete");

$Favoriten=new Favoriten();
$icon=$Favoriten->find_task("TBKoordinator_new",$_SESSION['uid']);
if ($icon =="star"){
$hover = "hinzufügen";
}else{
$hover = "entfernen";
}

$TBKoordinator = Core::$view->TBKoordinator;

if($_POST["registrieren"] != "1"){
$task_source = "TBKoordinator_new";
$task = "TBKoordinator";
}else{
$task_source = $_GET['task'];
}

if(!isset($referrer) && $_POST["registrieren"] != "1"){ ?>

<a href="?task=<?=$task?>" class="ui-btn ui-icon-back ui-btn-icon-notext ui-corner-all" align="right" style="display:inline-block;" data-ajax=false>No text</a>
<div class="tooltip_hs" style="margin-left:20px;position:absolute">
<a href="?task=favoriten&db_task=TB-Koordinator_new&icon=<?=$icon?>" class="ui-nodisc-icon ui-alt-icon" data-ajax="false" data-role="button" data-icon="<?=$icon?>" data-iconpos="notext" data-theme="b" data-inline="true" ></a>
<span style="font-size: 15px" class="tooltiptext">Favorit <?=$hover?></span>
</div>

<?php } ?>


<form id="form_TBKoordinator" method="post" action="?task=TBKoordinator_new&task_source=<?=$task_source?>" data-ajax="false" <?php if(isset($autocomplete)){ ?> autocomplete="on" <?php } ?> enctype="<?=$TBKoordinator::$enctype?>">

<?php if($_POST["registrieren"] == "1"){ ?>
<h3 class="groupheading">Sie müssen erst noch Ihre Profildaten pflegen, bevor Sie sich anmelden können</h3>
<?php } ?>

<div class="ui-field-contain">
<?php
$TBKoordinator = Core::$view->TBKoordinator;
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
