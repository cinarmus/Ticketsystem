<?php
$user = new user(); // Für Rendering der Elemente 
?>

<form id="loginForm" method="post" action="?task=login" data-ajax="false" data-role="none">
        <?php
        $user->render("Kennung");
        $user->render("Passwort");
        ?>
    <button type="submit" name="login" id="login" value="1">anmelden</button>
</form>