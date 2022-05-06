<?php

/*  @var $help HelperClass */

/**
 * Zentrale Singletonklasse für den korrekten Ablauf des MVC-Ansatzes
 * @version 1.0 
 * @author Markus Nippa<markus.nippa@hs-pforzheim.de.com>
 */
class Core {
    /* @var $pdo PDO */
    /* @var $view View */

    /**  @var PDO hält die Verbindung zur Datenbank  */
    public static $pdo;

    /**  @var String enthält den Task, der gerade ausgeführt wird  */
    public static $task = 'home';

    /**  @var String Der Titel der Webseite, der im Header und als Browsertitel angezeigt wird */
    public static $title;
    
    /** @var Versionskontrolle - wird in der Prototypen-Anwendung angezeigt */
    public static $version;

    /**  @var String Gibt an, welcher Task als Startseite geladen werden soll */
    public static $defaultTask = "home";

    /** @var View statisches View-Objekt, das ein Array mit den verwendeten Views und die nötigen Daten aus den Models enthält */
    public static $view;

    /** @var User statisches User-Objekt, das später Informationen über den angemeldeten Benutzer enthält */
    public static $user;

    /** @var String Pfad für die anzuzeigende Navigation (Slider). Kann im Controller bei Bedarf geändert werden */
    public static $navbar = 'includes/main_navbar.php';

    /** @var Array Enthält eine Whitelist mit zulässigen Tasks. Diese werden in der system.main.php gesetzt. */
    private static $taskMap = [];

    /** @var Array enthält alle Fehlermeldungen, die während des Skriptes über  <b><i>addError()</i></b> hinzugefügt wurden. */
    public static $errorMsg = [];

    /** @var Array enthält alle Meldungen, die während des Skriptes über  <b><i>addMessage()</i></b> hinzugefügt wurden.  */
    public static $message = [];

    /** @var Boolean enthält die Inforamtion, ob Debuginformationen ausgegebn werden sollen. Wird üblicherweise über die config.php gesetzt */
    public static $debugMode = 1;

    /** @var Boolean Wenn debugmode aktiviert erfolgt eine Ausgabe im unteren Bereich der Seite. Wird üblicherweise über die config.php gesetzt */
    public static $debugPrint = 1;

    /** @var Boolean Wenn debugmode aktiviert erfolgt eine Ausgabein der Konsole des Browsers(Entwicklertools/Firebug). Wird üblicherweise über die config.php gesetzt */
    public static $debugConsole = 1;

    /** @var Array enthält alle Debugausgaben, die über <b><i>debug()</i></b> hinzugefügt wurden */
    public static $debug = [];
    
    /** @var Aktiviert den Xdebug-Kollektor für verzögerte Fehleranzeige **/
    public static $xdebug = 1;

    /** @var String Legt fest, wie ohne spezielle Angabe Formulardaten gefiltert werden soll. <br><b>Voreinstellung:</b> Es wird nicht gefiltert. */
    public static $defaultFilterValidate = "";

    /** @var String Legt fest, wie Formulardaten ohne spezielle Angaben bereinigt werden sollen.  <br><b>Voreinstellung:</b> Umwandlung in String (FILTER_SANITIZE_STRING) */
    public static $defaultFilterSanitize = "FILTER_SANITIZE_STRING";

    /**
     *
     * @var  Boolean Legt fest, wie die Anwendung mit dem Mapping von Formulardaten umgeht, wenn Mapping angegegben aber keine Form-Felder vorhanden sind.</br>Kann über die Klasse->StrictMapping zur laufzeit angepasst werden
     */
    public static $defaultStrictMapping = true;

    /** @var int legt  das für den Aufruf bebötigte Berechtigungslevel fest */
    public static $accessLevel = 0;

    /** @var Array ein Array mit allen zusätzlich zu ladenden Javaskripts (vollständiger Pfad) auf der Seite. */
    public static $javascript = [];
    public static $dbuser = "";
    public static $dbhost = "";
    public static $dbpassword = "";
    public static $dbdatabase = "";
    public static $useTimestamps = true;

    /** @var String Teilt der anwendung mit, welcher Viewport gerade gerendert wird */
    public static $currentView = "view1";
    public static $currentViewport = "list";
    public static $enctype = "application/x-www-form-urlencoded";
    public static $masks = ["phone", "money", "ip_address", "cep", "placeholder", "date", "time", "datetime", "credit", "currency"]; // currency wird mit mask Money verarbeitet

    /**
     * stellt die Datenverbindung zu Beginn her
     * @param String $host Server(z.B. 141.47.76.106)
     * @param String $database (z.B. ss2018001)
     * @param String $user (üblicherweise ist User=Datenbank
     * @param String $pw DB-Passwort
     * @return boolean Gibt zurück, wenn erfolgreich
     */

    public function __construct($host, $user, $password, $database) {
        static::$dbdatabase = $database;
        static::$dbuser = $user;
        static::$dbpassword = $password;
        static::$dbhost = $host;

        try {
            static::$pdo = new PDO("mysql:host=" . $host . ";dbname=" . $database . ";charset=utf8", $user, $password);
            self::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // For Debugging
        } catch (Exception $e) {
            self::addError('Keine Datenbankverbindung: ' . $e->getMessage());
        }
        static::$view = new View();
    }

    private static function count_visits() {
        $db = Core::$pdo;
        $month = date('m');
        $first_letter = $month{0};
        if ($first_letter == "0") {
            $month = substr($month, 1);
        }
        $SQL = "SELECT * FROM Visits WHERE id='$month'";
        $results = $db->query($SQL);
        if ($results) {
            foreach ($results as $result) {
                $visits = $result['visits'];
                $visits++;
                $SQL = "UPDATE Visits SET visits=" . $visits . " WHERE id=?";
                $stmt = $db->prepare($SQL);
                $results = $stmt->execute([$month]);
            }
        }
        return $results;
    }

    /**
     * Generiert eine Whitelist ($taskMap), welche Tasks in der Anwendung zulässig sind (Sicherheitsaspekte). Tasks ohne Dateinamen('') werden automatisch in der Form controller.<i>taskname</i>.php erwartet.
     * @param Array $arr ein Array mit Key=>Value-Paaren mit Task+zugehöriger Datei
     */
    public static function setTaskMap($arr = array()) {
        foreach ($arr as $key => $task) {
            if ($task == '') {
                $a = $key;

                $file = 'controller.' . $a . ".php"; // Setzt automatisch die passende PHP-Datei im Controller bei passender Nomenklatur
            } else {
                $file = $task;
            }
            self::$taskMap[$key] = $file; // wenn neu wird automatisch ein neuer key erzeugt
        }
    }

    /**
     * Zentrale Methode des Cores. Ruft das korrekte Controller-Skript nach Ablgeich mit der Whitelist auf.
     * Wird ein GET-Paramter errorMsg mitgegeben, wird auf der Task error nebst Fehlermeldung durchgeführt
     * Wird ein GET-Paramter message mitgegeben, erscheint die Meldung am Fuß der Seite angezeigt.
     * 
     * 
     */
    public static function controller() {
        // Task verareiten
        // core::$user->nachname="Nippa";
        //core::$user->vorname="Markus";
        //core::$user->gruppe=3;
        if (filter_input(INPUT_GET, "errorMsg") != false) { // Wenn eine Fehlermeldung via GET mitgegeben wird, wird immer die Error-PHP aufgerufen
            self::addError(filter_input(INPUT_GET, "errorMsg"));
        }

        if (filter_input(INPUT_GET, "message") != false) { //  Für das MEldungsfenster unten
            self::addMessage(filter_input(INPUT_GET, "message"));
        }

        $task = filter_var($_REQUEST['task'], FILTER_SANITIZE_SPECIAL_CHARS);
        if (count(self::$errorMsg) > 0) {
            $task = "error";
        } // falls bereits jetzt ein Fehler (z.B.) DB aufgetreten, wird nur der Error angezeigt
        if ($task) {
            include "controller/controller.entry.php";
            self::$task = $task;
            
        } else {
            include "controller/controller.entry.php";
            self::$task = self::$defaultTask;
        }

        // mit Whitelist abgleichen
        if (null != array_key_exists(self::$task, self::$taskMap)) {

            if ($task == "") {
                Core::count_visits();
            }

            if (isset($_GET['id'])) {
                $datensatz_id = $_GET['id'];
            } else {
                $datensatz_id = NULL;
            }

            require("controller/" . self::$taskMap[self::$task]);
        } else {
            //  self::$errorMsg="Die Seite kann nicht angezeigt werden";
            core::addError("Die Seite kann nicht angezeigt werden");
            $seite = self::$taskMap["error"];
            require("controller/" . $seite);
        }
    }

    /**
     * Fügt dem Array <b><i>$message[]</i></b> eine weitere Nachricht hinzu. Diese werden im Message-Container der Reihenfolge nach angezeigt
     * @param String $msg Text der Nachricht, die angezeigt werden soll
     */
    public static function addMessage($msg) {
        array_push(self::$message, $msg);
    }

    /**
     * Fügt dem Array <b><i>$errorMsg[]</i></b> eine weitere Fehlermeldung hinzu. Diese werden im Error-Container der Reihenfolge nach angezeigt
     * @param String $msg Text der Fehlermeldung, die angezeigt werden soll
     */
    public static function addError($msg) {
        array_push(self::$errorMsg, $msg);
    }

    /**
     * rendert die Nachrichten für die index.php.
     * @return string Zeilenweise Ausgabe der Nachrichten
     */
    public static function showMessages() {
        $text = "";
        foreach (self::$message as $msg) {
            $text = $text . $msg . "</br>";
        }
        return $text;
    }

    /**
     * rendert die Fehlermeldungen für die index.php.
     * @return string Zeilenweise Ausgabe der Fehlermeldungen
     */
    public static function showErrors() {
        $text = "";
        foreach (self::$errorMsg as $msg) {
            $text = $text . $msg . "</br>";
        }
        return $text;
    }

    /**
     * liest <b>sicher</b> den Task der Seite aus und speichert diesen in <b><i>::$task</i></b>.
     */
    public function init() {

        if (isset($_REQUEST['task'])) {
            self::$task = filter_var($_REQUEST['task'], FILTER_SANITIZE_STRIPPED);
        } else {


            self::$task = self::$defaultTask;
        }
        if (class_exists("User")) { // wenn Benutzerverwaltung in main aktiviert
            $user = new User();
            if (isset($_SESSION['uid'])) {
                if ($_SESSION['uid'] != "") {
                    $user->loadDBData($_SESSION['uid']);
                } else {
                    $user->Gruppe = 0; // Gast 
                }
            } else {
                $user->Gruppe = 0; // Gast
            }
            Core::$user = $user;
        }
    }

    /**
     * Fügt eine neue Ausgabe zum Debuggen auf der Seite hinzu.
     * @param string $text Text, der ausgegeben werden soll
     * @param string $extra alternativ wird ein zweiter Text in eckigen Klammern dahinter angezeigt
     */
    public static function debug($text, $extra = "") {

        if (is_string($text) || is_numeric($text)) {
            if ($extra != "") {
                $text = $text . "[" . $extra . "]";
            }
        } else if (is_array($text)) {
            array_push($text, $extra);
        } else if (is_object($text)) {
            $text->extra = $extra;
        }

        array_push(self::$debug, $text);
    }

    public static function log($text) {
        $path = "log.txt";
        $text = date("d.m.Y H:i:s ") . $text . "\r";
        $file = fopen($path, "a");
        fwrite($file, $text);
        fclose($file);
    }

    /**
     * Prüft, ob der Benutzer (core::$user->gruppe) die notwendige Berechtigung (Core::$accesslevel) besitzt und leitet ansonsten
     * zu einer Fehlerseite um. Üblicherweise sollte dies zu Beginn des Controllers geschehen.
     * @param Short $accessLevel Optionaler Parameter der automatisch Core::$accessLevel auf diesen Wert setzt 
     * @param Boolean $exactMatch wenn auf <b>true</b> gesetzt muss das Level exakt übereinstimmen. By <b>false</b> handelt es sich um ein Mindestlevel(default)
     * @return Redirect Leitet im Fehlerfall zur error.php um
     * 
     */
    public static function checkAccessLevel($accessLevel = 0, $exactMatch = false) {
        if ($accessLevel != 0) {
            static::$accessLevel = $accessLevel;
        }

        $localRight = 0;
        if (is_object(self::$user)) {
            $localRight = core::$user->Gruppe;
        }
        if ($exactMatch) {
            if (static::$accessLevel != $localRight) {
                $arr = array("errorMsg" => "Sie haben keine Berechtigung für die Seite");
                Core::redirect("error", $arr);
            }
        } else {
            if (static::$accessLevel > $localRight) {
                $arr = array("errorMsg" => "Sie haben keine Berechtigung für die Seite");
                Core::redirect("error", $arr);
            }
        }
    }
    
    public static function checkAccessGui($classSettings, $taskType) {
        $userG = Core::$user->Gruppe;
        $code = strval("G".$userG);
        if($classSettings['gui'][$code][$taskType] != "true") {
            $arr = array("errorMsg" => "Sie haben keine Berechtigung für die Seite");
            Core::redirect("error", $arr);
        }else{
        $access = [];
        foreach($classSettings['gui'][$code] as $key => $value){
        $access[$key] = $value;
        }
        return $access;
        }
    }

    /**
     * Es wird zu einem neuen Task direkt umgeleitet. Die Seite wird dabei neu geladen (Der User bekommt davon nichts mit). Es ist möglich neben dem Tasknamen weitere Parameter zu übergeben
     * @param String $task gibt den Task an zu dem umgeleitet werden soll
     * @param Array $options Ein assoziatives Array mit Name/Werte Paaren. Diese werden als Getparameter (url-enkodiert) mit übergeben. So können Biespielsweise ID's oder Meldungen für die Messagebos mitgegeben werden
     */
    public static function redirect($task, $options = array()) {
        $getparam = "";
        foreach ($options as $paramname => $paramvalue) {
            $getparam = $getparam . "&" . $paramname . "=" . urlencode($paramvalue);
        }


        header("location: ?task=" . $task . $getparam);
    }

    /**
     * Javaskripts müssen in der index.php an einer bestimmten Seite stehen. Die Methode speichert die Pfade in einem Array und lädt Sie anschließend in der index.php.
     * @param String $path lreativer Pfad der Datei, die eingebunden werden soll.
     */
    public static function loadJavascript($path) {
        array_push(static::$javascript, $path);
    }

    public static function loadDynJavaskript($javaskript) {
        array_push(static::$dynJavascript, $javaskript);
    }

    public static function publish($controllervar, $varname,$view="") {
        if($view==""){
            Core::$view->$varname = $controllervar;
        }else{
            Core::$view->$varname[$view]=$controllervar;
            $a=1;
        }
    }

    public static function import($varname) {
        return Core::$view->$varname;
    }

    /**
     * Lädt in den entsprechenden Template-Container in der index.php das gewünschte Skript und legt den Ansichtsmodus(Viewport) fest.
     * @param String $filenameShort  gibt den kurznamen der View an also bei view.artikel_detail.php => artikel_detail
     * @param String $view legt fest, in welchem Div-Container die View gernedert werden soll.
     * @param String $viewport gibt an, welcher Ansichtsmodus (Viewport) des Dataschemes verwendet werden soll:<br>list, detail, edit oder new
     */
    public static function setView($filenameShort, $view = "view1", $viewport = "list", $prefix = "view.", $suffix = ".php") {
        Core::$view->path[$view] = "views/" . $prefix . $filenameShort . $suffix;
        Core::$view->viewport[$view] = $viewport;
    }

    public static function setViewScheme($view, $viewport, $class = "", $concrete = "") {
        if ($concrete != "") { // nur für Framework, derzeit nicht im Generator implementiert
            Core::$view->dataScheme[$view] = json_decode(file_get_contents("models/json/" . $concrete . ".json"), true);
            Core::$view->class[$view] = $class;
            return true;
        }
        if ($class != "" && class_exists($class)) {
            $settings = $class::$settings;
            $gruppe = "G" . Core::$user->Gruppe;
            Core::$view->class[$view] = $class;
            if (isset($settings["rendering"][$gruppe][$viewport])) {
                $mode = $settings["rendering"][$gruppe][$viewport];
            } else {
                $mode = false;
            }
            if ($mode) {
                switch ($mode) {
                    case "none":
                        $scheme = $class::$dataScheme;
                        foreach ($scheme as &$att) {
                            $att["renderAs"][$viewport]["display"] = "false";
                        }
                        Core::$view->dataScheme[$view] = $scheme;
                        $fp = fopen("models/json/Ticket_" . $viewport . "_complete.json", "w");
                        fwrite($fp, json_encode(Core::$view->dataScheme[$view], JSON_UNESCAPED_UNICODE));
                        fclose($fp);
                        break;
                    case "full":
                        $scheme = $class::$dataScheme;
                        foreach ($scheme as &$att) { // Ausnahmen, die trotzdem nicht gerendert werden
                            if ($att["type"] != "primary" && $att["type"] != "timestamp" && $att["type"] != "foreign") {
                                $att["renderAs"][$viewport]["disabled"] = "false";
                                $att["renderAs"][$viewport]["readonly"] = "false";
                            }
                            if($viewport=="list" &&  $att["renderAs"][$viewport]["control"]=="fileupload"){
                                $att["renderAs"][$viewport]["display"] = "false";
                            }else{
                               $att["renderAs"][$viewport]["display"] = "true";  
                            }
                          
                           
                        }
                        Core::$view->dataScheme[$view] = $scheme;
                        $fp = fopen("models/json/Ticket_" . $viewport . "_complete.json", "w");
                        fwrite($fp, json_encode(Core::$view->dataScheme[$view], JSON_UNESCAPED_UNICODE));
                        fclose($fp);
                        break;

                    case "disabled":
                        $scheme = $class::$dataScheme;
                        foreach ($scheme as &$att) {
                            $att["renderAs"][$viewport]["disabled"] = "true";
                        }
                        Core::$view->dataScheme[$view] = $scheme;
                        $fp = fopen("models/json/Ticket_" . $viewport . "_complete.json", "w");
                        fwrite($fp, json_encode(Core::$view->dataScheme[$view], JSON_UNESCAPED_UNICODE));
                        fclose($fp);
                        break;

                    case "readonly":
                        $scheme = $class::$dataScheme;
                        foreach ($scheme as &$att) {
                            $att["renderAs"][$viewport]["readonly"] = "true";
                        }
                        Core::$view->dataScheme[$view] = $scheme;
                        $fp = fopen("models/json/Ticket_" . $viewport . "_complete.json", "w");
                        fwrite($fp, json_encode(Core::$view->dataScheme[$view], JSON_UNESCAPED_UNICODE));
                        fclose($fp);
                        break;
                    case "customscript":
                        $scheme_tmp=$class::$dataScheme;
                        $filename=$class."_".$viewport."_".$gruppe.".json";
                         $schemeGroup = json_decode(file_get_contents("models/json/".$filename), true);
                     
                         Core::$view->dataScheme[$view] = db::array_cascade([$scheme_tmp,$schemeGroup]);
                        break;
                    case "standard":
                        break;
                    case "datascheme":
                        Core::$view->dataScheme[$view] = $class::$dataScheme;
                    default:
                        Core::$view->dataScheme[$view] = $class::$dataScheme;
                }
            } else {
                Core::$view->dataScheme[$view] = $class::$dataScheme;
            }
        } else {
            return false;
        }
    }

}
