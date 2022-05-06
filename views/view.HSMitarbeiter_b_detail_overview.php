<?php
$HSMitarbeiter_b_list=Core::$view->HSMitarbeiter_b_list;
$HSMitarbeiter_b=Core::$view->HSMitarbeiter_b;
$Ticket=Core::$view->Ticket;
?>
<div data-role="ui-bar ui-bar-a">
<p><h3>Beziehungsübersicht zur Klasse: HS-Mitarbeiter <a href="#popup_HSMitarbeiter_b" data-rel="popup" data-transition="pop" class="my-tooltip-btn ui-btn ui-alt-icon ui-nodisc-icon ui-btn-inline ui-icon-info ui-btn-icon-notext" title="Erfahre mehr">Erfahre mehr</a></h3></p>
<div data-role="popup" id="popup_HSMitarbeiter_b" class="ui-content" data-theme="a" style="max-width:800px;">
<h3>Informationen zu dieser Beziehung ():</h3><br>
Ticket (*..*) ---- (1..*) HSMitarbeiter <br><br>
<h4>Bedeutet für diese Seite der Beziehung:</h4>
<p>Das Objekt in dieser Detailansicht (aus der Klasse: Ticket) muss mindestens eine Verbindung zu einem Objekt der Partnerklasse (HSMitarbeiter) haben (1..*).</p><br>
<h4>Bedeutet für die Partner-Seite der Beziehung:</h4>
<p>Das Partnerobjekt kann mehrere Verbindungen zu den Objekten aus dieser Klasse haben (*..*).</p>
<h4>Die Information zur Partner-Seite sollte vor allem dann beachtet werden:</h4>
<ul><li>wenn eine Verbindung gelöscht wird</li>
<li>wenn ein Objekt gelöscht wird</li></ul>
... durch einen solchen Vorgang könnte nämlich eine erfüllte Muss-Beziehung, auf Seite des Partnerobjekts auf einmal nicht mehr erfüllt sein!
</div>
</div>
<?php
if(!empty($HSMitarbeiter_b_list)){
?>
<form>
<input id="filterTable-input" data-type="search">
</form>
<div class="overflowx">
<table data-role="table" id="tbl_HSMitarbeiter_b" data-filter="true" data-input="#filterTable-input" class="ui-responsive" data-mode="columntoggle" data-column-btn-theme="b" data-column-btn-text="Spalten" data-column-popup-theme="a">
<thead>
<tr>
<?php $HSMitarbeiter_b->renderHeader("id", "table"); ?>
<?php $HSMitarbeiter_b->renderHeader("c_ts", "table"); ?>
<?php $HSMitarbeiter_b->renderHeader("m_ts", "table"); ?>
<?php $HSMitarbeiter_b->renderHeader("Name_Vorname", "table"); ?>
<?php $HSMitarbeiter_b->renderHeader("Name_Nachname", "table"); ?>
<?php $HSMitarbeiter_b->renderHeader("Adresse_Straße", "table"); ?>
<?php $HSMitarbeiter_b->renderHeader("Adresse_PLZ", "table"); ?>
<?php $HSMitarbeiter_b->renderHeader("Adresse_Ort", "table"); ?>
<?php $HSMitarbeiter_b->renderHeader("_User_uid", "table"); ?>
<th></th>
</tr>
</thead>
<tbody>
<?php foreach($HSMitarbeiter_b_list as $klasse){
?>
<tr>
<?php $klasse->render("id", "list"); ?>
<?php $klasse->render("c_ts", "list"); ?>
<?php $klasse->render("m_ts", "list"); ?>
<?php $klasse->render("Name_Vorname", "list"); ?>
<?php $klasse->render("Name_Nachname", "list"); ?>
<?php $klasse->render("Adresse_Straße", "list"); ?>
<?php $klasse->render("Adresse_PLZ", "list"); ?>
<?php $klasse->render("Adresse_Ort", "list"); ?>
<?php $klasse->render("_User_uid", "list"); ?>
<td>
<a href="?task=Ticket_delete_HSMitarbeiter_b&id=<?=$klasse->zwkls_id?>&back=<?=$Ticket->id?>&muss=true " data-ajax="false" data-role="button"  class="ui-btn ui-icon-delete ui-btn-icon-notext ui-corner-all ui-btn-inline">delete</a>
</td>
</td>
</tr>
<?php }
}else{
echo"<div>";
echo"Aktuell liegt keine Verbindung zu einem Objekt der Partnerklasse vor.";
}
?>
</tbody>
</table>
</div>
