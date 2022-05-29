<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

?>

<h1>Ticket zuteilen</h1>
<br><br>

<label>Ticket: Hier wird Ticket-ID displayed</label><br>


<label for="TSMA">Mitarbeiter auswählen</label>
    <input list="TSMA" id="TSMA" name="TS-Mitarbeiter" placeholder='Wählen Sie einen der Mitarbeiter zur Bearbeitung aus...' />
        <datalist id="TSMA">
            <option value="Hr.Dar">
            <option value="Hr. Cinar">
            <option value="Hr. Müller">
            <option value="Hr. Meier">
        </datalist>
    
<br>
<div class="aktDatum">
    <label>Erstellungszeitpunkt des Tickets:</label>
        <input id="aktDatum"></label>

    <script type="text/javascript">
    document.getElementById("aktDatum").readOnly = true;
    document.getElementById("aktDatum").value = new Date().toLocaleString('de-DE');
    </script>
</div>

<br>
<div class="aktKoord">
    <label>Ticket wird zugeteilt durch:</label>
        <input id="aktKoord"></label>
<!-- Hier wird User ID gepickt und Feld belegt -->
    <script type="text/javascript">
    document.getElementById("aktKoord").readOnly = true;
    document.getElementById("aktKoord").value = new Date().toLocaleString('de-DE');
    </script>
</div>
<br>
<button type="submit">Ticket zuweisen</button>