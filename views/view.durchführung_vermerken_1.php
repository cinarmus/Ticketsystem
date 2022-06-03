<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

?>

<h1>Durchführung vermerken</h1><br>

<label>Ticket:</label><br><!-- get info von Ticketname aus SQL Table -->

        <form action='#'>
            <p><label for="comment">Bitte fügen Sie eine Bemerkung hinzu:</label></p>
            <textarea id="comment" name="comment" rows="5" cols="50" placeholder="max. 800 Zeichen..."></textarea>
            <br>
        </form>

<button type="submit">Durchführung vermerken</button>