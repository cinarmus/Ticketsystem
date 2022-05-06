<?php
$TBKoordinator_list=Core::$view->TBKoordinator_list;
$TBKoordinator=Core::$view->TBKoordinator;
$Ticket=Core::$view->Ticket;
?>
<div data-role="ui-bar ui-bar-a">
<p><h3>Beziehungsübersicht zur Klasse: TB-Koordinator <a href="#popup_TBKoordinator" data-rel="popup" data-transition="pop" class="my-tooltip-btn ui-btn ui-alt-icon ui-nodisc-icon ui-btn-inline ui-icon-info ui-btn-icon-notext" title="Erfahre mehr">Erfahre mehr</a></h3></p>
<div data-role="popup" id="popup_TBKoordinator" class="ui-content" data-theme="a" style="max-width:800px;">
<h3>Informationen zu dieser Beziehung ():</h3><br>
Ticket (*..*) ---- (1..1) TBKoordinator <br><br>
<h4>Bedeutet für diese Seite der Beziehung:</h4>
<p>Das Objekt in dieser Detailansicht (aus der Klasse: Ticket) muss genau eine Verbindung zu einem Objekt der Partnerklasse (TBKoordinator) haben (1..1).</p><br>
<h4>Bedeutet für die Partner-Seite der Beziehung:</h4>
<p>Das Partnerobjekt kann mehrere Verbindungen zu den Objekten aus dieser Klasse haben (*..*).</p>
<h4>Die Information zur Partner-Seite sollte vor allem dann beachtet werden:</h4>
<ul><li>wenn eine Verbindung gelöscht wird</li>
<li>wenn ein Objekt gelöscht wird</li></ul>
... durch einen solchen Vorgang könnte nämlich eine erfüllte Muss-Beziehung, auf Seite des Partnerobjekts auf einmal nicht mehr erfüllt sein!
</div>
</div>
<div class="ui-field-contain">
<?php foreach($TBKoordinator_list as $klasse){
$partner=true;
$klasse->renderLabel("id", "detail");
$klasse->render("id", "detail");
$klasse->renderLabel("c_ts", "detail");
$klasse->render("c_ts", "detail");
$klasse->renderLabel("m_ts", "detail");
$klasse->render("m_ts", "detail");
$klasse->renderLabel("Name_Vorname", "detail");
$klasse->render("Name_Vorname", "detail");
$klasse->renderLabel("Name_Nachname", "detail");
$klasse->render("Name_Nachname", "detail");
$klasse->renderLabel("Adresse_Straße", "detail");
$klasse->render("Adresse_Straße", "detail");
$klasse->renderLabel("Adresse_PLZ", "detail");
$klasse->render("Adresse_PLZ", "detail");
$klasse->renderLabel("Adresse_Ort", "detail");
$klasse->render("Adresse_Ort", "detail");
$klasse->renderLabel("_User_uid", "detail");
$klasse->render("_User_uid", "detail");
}
if($partner!==true){
echo"Aktuell liegt keine Verbindung zu einem Objekt der Partnerklasse vor.";
}
?>
</div>
