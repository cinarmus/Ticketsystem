<?php
Core::checkAccessLevel(1);
    Core::setView("visits", "view1");
    $db = Core::$pdo;
    $sql = "SELECT * FROM Visits";
    $results = $db->query($sql);
    foreach ($results as $result) {
        $db = Core::$pdo;
        $sql = "SELECT * FROM Visits";
        $results = $db->query($sql);
        foreach ($results as $result) {
            $month = $result['month'];
            switch ($month) {
                case "Januar":
                    $januar = $result['visits'];
                case "Februar":
                    $februar = $result['visits'];
                case "März":
                    $märz = $result['visits'];
                case "April":
                    $april = $result['visits'];
                case "Mai":
                    $mai = $result['visits'];
                case "Juni":
                    $juni = $result['visits'];
                case "Juli":
                    $juli = $result['visits'];
                case "August":
                    $august = $result['visits'];
                case "September":
                    $september = $result['visits'];
                case "Oktober":
                    $oktober = $result['visits'];
                case "November":
                    $november = $result['visits'];
                case "Dezember":
                    $dezember = $result['visits'];
            }

        }
    }
    Core::publish($januar, "januar");
    Core::publish($februar, "februar");
    Core::publish($märz, "märz");
    Core::publish($april, "april");
    Core::publish($mai, "mai");
    Core::publish($juni, "juni");
    Core::publish($juli, "juli");
    Core::publish($august, "august");
    Core::publish($september, "september");
    Core::publish($oktober, "oktober");
    Core::publish($november, "november");
    Core::publish($dezember, "dezember");
