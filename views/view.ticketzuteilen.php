<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

?>

<div class="titel">
    <h1>Ticket zuteilen</h1>
    <br><br>
    
</div>

<div>
    <table class="Tickets">
        <thead>
            <tr>
                <th>Auswahl</th>
                <th>Titel</th>
                <th>Kategorie</th>
                <th>Frist</th>
                <th>Status</th>
                <th>Priorität</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input id="radio" type="radio"></td>
                <td>kaputtes Fenster</td>
                <td>Gebäudemangel</td>
                <td>03.07.2022</td>
                <td>in Bearbeitung</td>
                <td>akut</td>
            </tr>
            
            <tr>
                <td><input id="radio" type="radio"></td>
                <td>defekte Steckdose</td>
                <td>Elektrik</td>
                <td>01.07.2022</td>
                <td>offen</td>
                <td>möglichst bald</td>
            </tr>
            
            <tr>
                <td><input id="radio" type="radio"></td>
                <td>fehlende Lichter</td>
                <td>Event</td>
                <td>28.06.2022</td>
                <td>zugeteilt</td>
                <td>Sicherheitsgefährdung</td>
            </tr>
        </tbody>
    </table>

    <style>
        table.Tickets{
            border-collapse: collapse;
            margin: 32px 0;
            min-width: 1000px;
            border-radius: 5px 5px 0 0;
            overflow: hidden;
        }
        
        table.Tickets thead tr{
            background-color: #006699;
            color: white;
            text-align: left;
            
        }
        
        table.Tickets th,
        table.Tickets td {
            padding: 12px 16px;
            
        }
        
        table.Tickets tbody td{
            border-bottom: 1px solid;
        }
        
        table.Tickets tbody {
            border-bottom: 2px solid #006699 ;
        }
        
        #radio{
            cursor: pointer;
        }
    </style>
    
</div>
