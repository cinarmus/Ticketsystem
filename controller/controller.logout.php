<?php
$user = new User;
$user->logout();
Core::$user=NULL;
Core::redirect("home",["message"=>"Erfolgreich abgemeldet"]);
