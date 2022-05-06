<div class="error">
<?php // Hier kann noch eine eigene Meldung stehen ?>
</div>


<?php $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
	
	if (!empty($referer)) {
		
		echo '<p><a id="bbutton" href="'. $referer .'" title="Zurück zur vorherigen Seite." class=" ui-btn ui-shadow ui-corner-all ui-icon-back ui-btn-icon-left">ZURÜCK</a></p>';
		
	} else {
		
		echo '<p><a id="bbutton" href="javascript:history.go(-1)" class=" ui-btn ui-shadow ui-corner-all ui-icon-back ui-btn-icon-left" title="Zurück zur vorherigen Seite.">ZURÜCK</a></p>';
		
	}
?>