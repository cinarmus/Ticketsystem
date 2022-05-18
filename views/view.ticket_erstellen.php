<?php

?>

<div class="titel">
    <h1>Ticket erstellen</h1>
    <br><br>
    
</div>

<div class="input">
    
    <label>Titel des Tickets:</label>
    <input form="titel" name="Titel" placeholder="Bitte einen Titel eingeben!"></input>
    <br>
        
    <label for="date">Bitte eine Kategorie auswählen</label>
        <input list="category" id="categoryy" name="category" placeholder='Kategorie auswählen...' />
        <datalist id="category">
            <option value="Gebäudemangel">
            <option value="Elektrik">
            <option value="Vorlesungsraum">
            <option value="Event">
        </datalist>
        <br>
        
        <label>
            Bitte geben Sie das Frist-Datum an:
            <input type="date">
        </label>
        <br>

        <form action='#'>
            <p><label for="desc">Bitte fügen Sie eine Beschreibung hinzu:</label></p>
            <textarea id="desc" name="desc" rows="5" cols="50" placeholder="max. 800 Zeichen..."></textarea>
            <br>
        </form>
        
        <label for="anhang">Fügen Sie eine Datei hinzu:</label>
        <input type="file" id="anhang" name="anhang">
        <br>
        
        <input type="submit" value="Ticket erstellen">
        
</div>
