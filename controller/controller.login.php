<?php
Core::setView("login", "view_login", "login");

if (isset($_POST["login"])) {
    $user = new User;
    $user->loadFormData();
    if ($user->login()) {
        $profileID = $user->checkProfile();
        if ($profileID) { 
            if ($user->roleid != $profileID && $profileID>0) { // Bei erstmLIGER aNMELDUNG rOLENid SETZEN
                $user->roleid = $profileID;
                $user->update("UPDATE User SET roleid=? WHERE id=? ",[$user->roleid,$user->id]);
            }
            Core::redirect("home",["message"=>"Erfolgreich angemeldet"]);
        } else {
            $enumerationen = $user->enumerationen();
            foreach ($enumerationen as $key => $enum) {
                Core::publish($enum, $key);
            }
            $_SESSION['uid'] = "";
            $gruppe = new gruppet;
            $gruppe->loadDBData($user->Gruppe);
            $Gruppenname = $gruppe->literal;
            $Profil = new $Gruppenname();
            $Profil->_User_uid = $user->id;
            Core::publish($Profil, $Gruppenname);
            Core::publish($user, "user");
            Core::setView($Gruppenname . "_new", "view1", "new");
            Core::addMessage("Sie müssen erst noch Ihre Profildaten pflegen, bevor Sie Sie sich anmelden können");
              Core::setView($Gruppenname . "_new", "view1", "new");
        }
    } else {
        Core::addError("Sie konnten sich nicht anmelden");
        Core::setView("error", "view1", "detail");
    }
} else {
}  