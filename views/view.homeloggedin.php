<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>

<div class="erfolg">
    <label id="uber1" id="uber1"><b>Anmeldung war erfolgreich!</b></label><br>
    <label id="uber2" id="uber2">Womit möchten Sie fortfahren?</label>
    
    <div class="buttons">
    <a class="erstellen" id="ticket erstellen" href="google.de"><b>Ticket<br>erstellen</b></a><br>
    <a class="zuteilen" href=#><b>Ticket<br>zuteilen</b></a><br>
    <a class="einsehen" href=#><b>Ticket<br>einsehen</b></a><br>
    <a class="einsehen" href=#><b>Liste<br>einsehen</b></a><br>
    </div>
    
    <style>
        
    html, body{
        background-color: red;
    }
        
    #uber1{
        display:flex;
        width: 30%;
        margin-left: 40%;
        margin-right: 40%;
        text-align: center;
        font-size: xx-large;
        color: #005599;
        margin-top: 100px;
        
    }
    #uber2{
        display:flex
        width: 30%;
        margin-left: 40%;
        margin-right: 40%;
        text-align: center;
        display: flex;
        color: #005599;
        font-size: x-large;
    }
    
    .button{
        width: 10px;
        display: grid;
    }

    .erstellen{
        border-color: black;
    }

    
    .buttons{
        postion:relative;
        font-weight: bold;
        font-size: 20px;
        text-align: center;
        width: 20%;
        background-color: #005599;
        margin-left: 40%;
        margin-right: 40%;
        margin-top: 20px;
        border-color: black;
        border-radius: 10px;
    }
    erstellen:hover{
        color: red;
    }
    </style>
    
</div>
