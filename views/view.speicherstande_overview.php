<?php
$filearray=Core::$view->file_array;



$Favoriten=new Favoriten();
$icon=$Favoriten->find_task("speicherstande",$_SESSION['uid']);
if ($icon =="plus"){
$hover = "hinzufügen";
}else{
$hover = "entfernen";
}
?>
<div data-role="ui-bar ui-bar-a">
<h1>Speicherstände

<?php if(Core::$user->Gruppe >0){ ?>
<div class="tooltip_hs">
<a href="?task=favoriten&db_task=speicherstande&icon=<?=$icon?>" class="ui-nodisc-icon ui-alt-icon" data-ajax="false" data-role="button" data-icon="<?=$icon?>" data-iconpos="notext" data-theme="b" data-inline="true"></a>
<span style="font-size: 15px" class="tooltiptext">Favorit <?=$hover?></span>
</div>
<?php } ?>
</h1>
</div>


<div class="speicherstandforms">

<div data-role="collapsible" data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
    <h4>Speicherstände Exportieren</h4>
    <ul data-role="listview" data-inset="false">
<form id="form_datenexport" method="post" action="?task=datenexport" data-ajax="false" data-enhanced="true"> 
<div class="ui-body ui-body-a ui-corner-all" id="exportcontainer"> 
<div class="datenexport-left">
<input name="file_name" id="file_name" placeholder="Ordnername" value="" />
<label for="Bilder"  data-enhanced="true">Bilder</label><input data-theme="b" type="checkbox" name="Bilder" id="Bilder" value="1" checked="checked" />
<label for="Datenbank" data-enhanced="true">Datenbank</label><input data-theme="b" type="checkbox" name="Datenbank" id="Datenbank" value="1" checked="checked"/>
<label for="Dateien" data-enhanced="true">Dateien</label><input data-theme="b" type="checkbox" name="Dateien" id="Dateien" value="1" checked="checked"/>
</div>   
<div class="datenexport-right">
<textarea name="Versionskommentar" id="datenexport-right-textarea" placeholder="Versionskommentar (optional):"></textarea> 
</div>  
<button class="ui-btn ui-btn-a ui-icon-plus ui-btn-icon-left" type="submit" name="save" id="update" value="1" >Speicherstand exportieren</button>
</div>
</form>
    </ul>
</div>

<div data-role="collapsible" data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
    <h4>Speicherstände Uploaden & Importieren</h4>
    <ul data-role="listview" data-inset="false">
<form id="form_speicherstand" method="post" action="?task=speicherstand_upload" data-ajax="false" data-enhanced="true" enctype="multipart/form-data">
    <div class="ui-body ui-body-a ui-corner-all" id="exportcontainer">
    <div style="width:50%;display:inline-block;float:left;">
        <input type="file" class="form-control-file" name="speicherstand" id="speicherstand" title=" ">
    </div>
    <div style="width:48%;display:inline-block;float:right;">
        <label style="padding-top:8px;padding-bottom:8px;border-radius:2px;" for="speicherstandImport" data-enhanced="true">Speicherstand direkt Importieren</label><input style="border-width:1px!important;border-style:solid!important;border-radius:.1875em!important;" data-theme="b" type="checkbox" name="speicherstandImport" id="speicherstandImport" value="1"/>
    </div>
<button class="ui-btn ui-btn-a ui-icon-cloud-upload ui-btn-icon-left" type="submit" name="save" id="update" value="1" >Speicherstand Uploaden</button>
</div>
</form>
    </ul>
</div>

</div>



<table data-role="table" id="tbl_speicherstande" data-filter="true" data-input="#filterTable-input" class="ui-responsive">
<thead>
<tr>
<th>Name</th>
<th>Datum</th>
<th>Umbenennen</th>
<th></th>
<th style="text-align: center;">Importieren</th>
<th style="text-align: center;">Downloaden</th>
<th style="text-align: center;">Löschen</th>
</tr>
</thead>
<tbody>
<?php 
foreach($filearray as $klasse){
    $fileLink = "../Ticketsystem/speicherstände/Ticketsystem/".$klasse[2];
?>
<tr>
<td><?php echo $klasse[0] ?> <a class="ui-btn ui-alt-icon ui-nodisc-icon ui-btn-inline ui-icon-info ui-btn-icon-notext" title="<?php echo $klasse[4] ?>" style="border:none;background:none;margin:0px;"></a></td>
<td><?php echo $klasse[1] ?></td>
<td width: 16%;>
<form id="speicherstand_edit" method="post" action="?task=speicherstand_edit&id=<?=$klasse[2]?>" data-ajax="false">
<input id="file_name_edit" name="file_name_edit" value="" />
</td>
<td>
<button class="ui-btn ui-icon-edit ui-btn-icon-notext ui-corner-all ui-btn-inline" type="submit" name="save" id="update" value="1" >show</button>
</form>
</td>
<td style="text-align: center;">
<a href="?task=datenimport&id=<?=$klasse[2]?>" data-ajax="false" data-role="button"  class="ui-btn ui-icon-recycle ui-btn-icon-notext ui-corner-all ui-btn-inline" style="text-align: center;">show</a>
</td>
<td style="text-align: center;">
<a href="<?=$fileLink?>?>" data-ajax="false" data-role="button"  class="ui-btn ui-icon-cloud-download ui-btn-icon-notext ui-corner-all ui-btn-inline" style="text-align: center;">show</a>
</td>
<td style="text-align: center;">
<a href="?task=speicherstand_delete&id=<?=$klasse[2]?>" data-ajax="false" data-role="button"  class="ui-btn ui-icon-delete ui-btn-icon-notext ui-corner-all ui-btn-inline" style="text-align: center;">show</a>
</td>
</tr>
<?php
}
if(count($filearray)<1){
        ?> <tr><td colspan="5"><br>Hier ist Platz für Ihre Speicherstände. <br>Wählen Sie über die Checkboxen aus, welche Informationen Sie speichern wollen. Sie können optional einen Ordnernamen setzen und ein Versionskommentar hinzufügen.<br></td></tr> <?php
}
?>
</tbody>
</table>
<br>
