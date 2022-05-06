<?php

/*  @var $help HelperClass */

/**
 * Zentrale Datenbankklasse die alle CRUD Funktionen zur Verf�gung stellt. Die eigenen Anwendungsklassen erben diese dann.
 * Haupts�chlich m�ssen nur die Konstanten kLassenbezogen angepasst werden.<br>Au�erdem werden Methode zur automatischen Verarbeitung von Formulardaten zur Verf�gung gestellt.
 * @version 1.0
 * @author Markus Nippa<markus.nippa@hs-pforzheim.de.com>
 */
class DB {

    public static $access = false;

    /*  @var $core Core */
    /* @var $db PDO */
    /* @var Core::$pdo PDO */
    /* @var $stmt PDOStatement */

    /** @var String Legt die SQL-Anweisung f�r <b><i>create()</b></i> fest.
     */
    const SQL_INSERT = 'INSERT INTO artikel (id,c_ts,m_ts,Artikelnummer,Bezeichnung,Preis,Preis_c,bild) VALUES (?,?,?,?,?,?,?,?)'; // Nur als Beispiel, wird von Kindklasse �berschrieben
    /** @var String Legt die SQL-Anweisung f�r <b><i>update()</b></i> fest
     */
    const SQL_UPDATE = 'UPDATE Kunde SET c_ts=?,m_ts=?,Kundennummer=?,Bezeichnung=?,Preis=?,Preis_c=?,bild=? WHERE id=?';

    /** @var String SQL-Anweisung f�r die <b><i>find()</i/</b>-Methode zur R�ckgabe eines einzelnen Objekts anhand der ID.
     */
    const SQL_SELECT_PK = 'SELECT * FROM Artikel WHERE id=?';

    /** @var String SQL-Anweisung f�r die <b><i>findAll()</i/</b>-Methode zur R�ckgabe aller Objekte einer KLasse.
     */
    const SQL_SELECT_ALL = 'SELECT * FROM Artikel';

    /** @var String Legt die SQL-Anweisung f�r <b><i>delete()</b></i> fest (l�sch einen Datensatz anhand der ID.
     */
    const SQL_DELETE_PK = 'DELETE FROM Artikel WHERE id=?';

    /**
     *  @var String Legt den Prim�rschl�ssel einer Klasse fest, meist id
     */
    const SQL_PRIMARY_KEY = 'id';

    /**
     * @var Array Ordnet Formularfelder bei <b><i>loadFormData()</i></b> den korrekten Attributen zu.
     */
    Public $dataMapping = Array(); // f�r den Import von Formulardaten
    // Public $dataTypeMapping=Array(); 
    /**
     * @var Array Legt f�r jedes Attribut fest, gegen welchen Datentyp validiert werden soll. Wird das Attribut nicht aufgef�hrt wird <b><i>core::$defaultFilterValidate</i></b> verwendet.
     */
    Public $validateMapping = Array();

    /**
     * @var Array Legt f�r jedes Attribut fest, wie Formulardaten ges�ubert(sanitize) werden sollen. Wird das Attribut nicht aufgef�hrt wird <b><i>core::$defaultFilterSanitize</i></b> verwendet.
     */
    Public $sanitizeMapping = Array();

    /**
     *
     * @var Boolean Gibt an, wie die Validierung beim Mapping damit umgehen soll, wenn Felder gar nicht erst vorhanden sind. Es wird immer NULL zur�ckgegeben. Wenn <b>true</b> gubt die loadFormadata <i>false/i>  zur�ck und wirft eine Fehlermeldung aus.</br>Bei <b>false</> wird das Feld �berprungen und ein Debughinweis gegeben.
     */
    Public static $dataScheme = Array();
    Public static $settings = Array();
    Public static $relations = [];
    Public $strictMapping;
    public static $enctype = "application/x-www-form-urlencoded";
    Public static $activeViewport = "";
    Public $id;
    Public $created_id;
    Public $owner_id;
    Public $modified_id;
    Public static $SQLautojoin=true;
    Public static $SQLrestrict=true;
    Public static $SQLidentifier=true;

    const TYPE_BOOLEAN = 1;
    const TYPE_INTEGER = 2;
    const TYPE_STRING = 3;
    const TYPE_FLOAT = 4;
    const TYPE_PRIMARY = 5;
    const TYPE_FOREIGNKEY = 6;
    const TYPE_TIMESTAMP = 7;
    const TYPE_DATE = 8;
    const TYPE_ENUMERATION = 9;
    const TYPE_TIME = 10;
    const TYPE_PICTURE = 11;
    const REGEX_PLZ = '/^([0]{1}[1-9]{1}|[1-9]{1}[0-9]{1})[0-9]{3}$/';
    const REGEX_EMAIL = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/";

     // wird bei __construct() auf die EEintstellung aus dem Core gesetzt
    public function __construct($useDefaults = true) {


        $this->strictMapping = Core::$defaultStrictMapping;
        if ($useDefaults === true) {
            $classname = get_class($this);
            foreach (static::$dataScheme as $key => $att) {
                $default = "";
                    if (isset($att["default"])) {
                    if($att["stereotype"]!="enumeration"){
                        $default = $att["default"];
                    }else{
                        $enum=new $att["type"];
                        $liste=$enum->findAll();
                        foreach($liste as  $item){
                            if($item->literal==$att["default"]){
                                $default=$item->id;
                                break ;
                            }
                        }
                    }
                    
                }
                if (isset(Core::$user->Gruppe)) {
                    $gruppe = "G" . Core::$user->Gruppe;
                    if (isset($att["defaults"][$gruppe])) {
                        $default = $att["defaults"][$gruppe];
                    }
                }


                if ($default!="") {

                
                        switch ($default) {
                            case "{auto}":
                                if(isset($_GET[$key])){ // =>{GET}
                                     $this->$key = filter_input(INPUT_GET, $key);
                                     // $att["renderAs"]["new"]["readonly"] = 1;
                                     //Baumarktprodukt::$dataScheme['_Hersteller']['renderAs']['new']['readonly'] = 1;
                                     //$test = "test";
                                }elseif($att["class"] == filter_input(INPUT_GET, "class")){ // =>{relation}
                                     $this->$key = filter_input(INPUT_GET, "id");
                                }elseif($att["class"] == Core::$user->Gruppe_literal){ //=> $roleid
                                      $this->$key = Core::$user->roleid;
                                }
                                break;
                            
                            
                            
                            
                            case "{GET}":
                                $this->$key = filter_input(INPUT_GET, $key);
                                break;
                            case "{relation}":
                                if ($att["class"] == filter_input(INPUT_GET, "class")) {
                                    $this->$key = filter_input(INPUT_GET, "id");
                                }
                                break;
                                 case "{roleid}":
                               if($att["class"] == Core::$user->Gruppe_literal){ //=> $roleid
                                      $this->$key = Core::$user->roleid;
                                }
                                break;
                            default:
                                $this->$key = $default;
                        }
                    }
                }
           
        }
    }
    
    


    /**
     * L�dt anhand von <b><i>SQL_SELECT_PK</i></b> die Daten in das aktuelle Objekt. Defacto wird die <b><i>find()</i></b>-Methode und anschlie�end <b><i>import()</i></b> durchgef�hrt.<br>
     * Statt der id kann alternativ eine SQL-Anweisung mit anschlie�endem Parametern �bergeben werden 
     * @param type $id Wert des Prim�rschl�ssels (Feld in SQL-Anweisung angegeben)
     * @return boolean Gibt true oder false zur�ck.
     * @example <code>$result=$myObject->loadDBData(27);</code><br>L�dt in aktuelles Objekt Datensatz mit PK=27<br><code>$result=$myObject->loadDBData("SELECT * FROM User WHERE Kennung=?",["Nippa"]);</code><br>L�dt in aktuelles Objekt Ergebnis aus SQL. Beachten Sie, dass die Anweisung (ggf. mit LIMIT) auch nur einen Datensatz als Ergebnis liefert
     */
    public function loadDBData($id, $param = array()) {
        if (count($param) != 0) {
            $obj = self::find($id, $param); // SQL-Anweisung+Parameter
        } else {
            $obj = self::find($id);
        }


        if (is_object($obj)) {
            $this->import($obj);
            return true;
        } else {

            core::addMessage("Kein Datensatz gefunden");
            return false;
        }
    }

    private function autoRelation($SQL) {
        
    }

    /**
     * Statisch, gibt ein einzelnes <b>Objekt</b> der Klasse zur�ck anhand von <b><i>SQL_SELECT_PK</i></b><br>
     * Statt der id kann alternativ eine <b>SQL-Anweisung</b> mit anschlie�endem Parametern �bergeben werden .
     * Also eigentlich �berladen find($id) und find(SQL,[param1,....])
     * @param Long $id Wert des Prim�rschl�ssels oder parametrisierte SQL-Anweisung
     * @param Array $param ordinales Array mit Werten(optional)
     * @return Object|false Standardobjekt oder false

     * @example <code>$stdobject=MyClass::find(27);</code>gibt �blicherweise den Datensatz mit dem Prim�rschl�ssel 27 zur�ck<br><code>MyClass::find("SELECT * FROM User Where Kennung="?",[$variable]);</code>
     * 
     */
    public static function find($id, $param = array()) {
        if (count($param) != 0) {
            $SQL = $id; // �berladung verarbeiten
        } else {
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id == false) {
                core::debug("Kein Schl�ssel �bergeben");
                core::addMessage("Kein Schl�ssel �bergeben");
                return false;
            }
            $SQL = static::SQL_SELECT_PK;
            $param[] = $id;
        }

        $classname = static::class;

        if (static::$SQLidentifier) {
            $ident = static::$settings["identifier"];
            $SQLArray = db::querySplit($SQL);
            $SQLArray["SELECT"] = "SELECT " . $SQLArray["DISTINCT"] . $ident . " AS identifier, " . substr($SQLArray["SELECT"], 6 + strlen($SQLArray["DISTINCT"]));
            $SQL = db::queryJoin($SQLArray);
        } else {
            $SQLArray = db::querySplit($SQL);
            $SQLArray["SELECT"] = "SELECT " . $SQLArray["DISTINCT"] . substr($SQLArray["SELECT"], 6 + strlen($SQLArray["DISTINCT"]));
            $SQL = db::queryJoin($SQLArray);
        }

        if (static::$SQLautojoin) {
            foreach (static::$dataScheme as $key => $scheme) {
                if (isset($scheme["stereotype"])) {
                    if ($scheme["stereotype"] == "relation" && ($scheme["join"] == "INNER" || $scheme["join"] == "LEFT" || $scheme["join"] == "RIGHT" )) {
                        $SQLArray = db::querySplit($SQL);
                        $relationClass = $scheme["class"];
                        $classAlias = $scheme["classAlias"];
                        $basis = static::class;
                           $joinAdapted=$scheme["join"];
                        if(static::$settings['strictJoin']=="false"){ // Korrektur Lazy JOIN =>LEFT
                          $joinAdapted=  "LEFT";
                        }
                        $newJoin = " " .$joinAdapted . " JOIN $relationClass AS $classAlias ON $relationClass.id=$basis.$key";
                        $SQLArray["JOIN"] = $SQLArray["JOIN"] . $newJoin;
                        $from = stripos($SQLArray["SELECT"], " FROM");
                        $length = strlen($SQLArray["SELECT"]);
                        $left = substr($SQLArray["SELECT"], 0, $from);
                        $right = substr($SQLArray["SELECT"], -($length - $from));
                        if ($scheme["identifier"] == "") {
                            $scheme["identifier"] = $relationClass::$settings["identifier"];
                        }
                        if (static::$activeViewport != "") {
                            if (isset($scheme["renderAs"][static::$activeViewport]["identifier"])) {
                                if ($scheme["renderAs"][static::$activeViewport]["identifier"] != "") {
                                    $scheme["identifier"] = $scheme["renderAs"][static::$activeViewport]["identifier"];
                                }
                            }
                        }



                        if (static::$SQLidentifier) {
                            $left = $left . ", " . $scheme["identifier"] . " AS " . $key . "_identifier";
                        }
                        $SQLArray["SELECT"] = $left . $right;
                        $SQL = db::queryJoin($SQLArray);
                    }
                }
            }
        }
        if (static::$access == true && static::$SQLrestrict) {
            $access = static::$settings["access"];
            if (is_array($access)) {
                $gruppe = "G" . Core::$user->Gruppe;
                if (is_array($access[$gruppe])) {
                    switch ($access[$gruppe]["data"]) {
                        case "all":
                            $join = $access[$gruppe]["join"];
                            $group = $access[$gruppe]["group"];
                            if ($SQLArray["GROUP"] == "" && $group!="" && $group!=NULL){
                                $SQLArray["GROUP"] = $group;
                            }
                            if ($join!="" && $join!=NULL) {
                                $SQLArray["JOIN"] = $SQLArray["JOIN"] . " " . $join;
                            }
                            $SQL = db::queryJoin($SQLArray);
                            break;
                        case "owned":
                            $join = $access[$gruppe]["join"];
                            $group = $access[$gruppe]["group"];
                            $SQL = self::restrictSQLOwned($SQL, $param,$join,$group);
                            break;
                        case "expression":
                            // no safe paraeters!!
                            $join = $access[$gruppe]["join"];
                            $group = $access[$gruppe]["group"];
                            $restriction = $access[$gruppe]["restriction"];
                            $newparams = explode(",", $access[$gruppe]["param"]);

                            $SQL = self::restrictSQLExpression($SQL, $restriction, $param, $newparams, $join,$group);
                            break;
                        default:
                            $SQL = self::restrictSQLNoData($SQL);
                    }
                }
            }
        }

         Core::log(get_called_class()."#".__FUNCTION__."(): ".$SQL);
        $db = Core::$pdo;
        $stmt = $db->prepare($SQL);
        $result = $stmt->execute($param);


        self::stmtDebug($stmt);
        $class = get_called_class();
        if (class_exists($class)) {
             $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class);
            $obj = $stmt->fetch(); // Object der aufrufenden Klasse
        } else {
            $obj = $stmt->fetch(); // Standardobject
        }
        return $obj;
    }

    private static function querySplit($SQL) {
        $SQLArray = array();
        $SQLArray["SELECT"] = "";
        $SQLArray["JOIN"] = "";
        $SQLArray["WHERE"] = "";
        $SQLArray["GROUP"] = "";
        $SQLArray["HAVING"] = "";
        $SQLArray["ORDER"] = "";
        $SQLArray["DISTINCT"] = "";

        $length = strlen($SQL);
        $counter = strlen($SQL);

        // DISTINCT
        $distinctpos = stripos($SQL, " DISTINCT ");
        if ($distinctpos !== false) {
            $SQLArray["DISTINCT"] = "DISTINCT ";
        }

        // ORDER BY
        $orderpos = stripos($SQL, " ORDER ");
        if ($orderpos !== false) {
            $SQLArray["ORDER"] = substr($SQL, $orderpos);
            $counter = $orderpos;
        }
        // HAVING
        $havingpos = stripos($SQL, " HAVING ");
        if ($havingpos !== false) {
            $SQLArray["HAVING"] = substr($SQL, $havingpos, $counter - $havingpos);
            $counter = $havingpos;
        }
        // GROUP BY
        $grouppos = stripos($SQL, " GROUP BY ");
        if ($grouppos !== false) {
            $SQLArray["GROUP"] = substr($SQL, $grouppos, $counter - $grouppos);
            $counter = $grouppos;
        }
        // WHERE
        $wherepos = stripos($SQL, " WHERE ");
        if ($wherepos !== false) {
            $SQLArray["WHERE"] = substr($SQL, $wherepos, $counter - $wherepos);
            $counter = $wherepos;
        }
        // JOIN
        $firstJoin = stripos($SQL, " JOIN ");
        if ($firstJoin !== false) {
            if (stripos($SQL, " INNER JOIN ") !== false && stripos($SQL, " INNER JOIN ") < $firstJoin) {
                $joinpos = stripos($SQL, " INNER JOIN ");
            } elseif (stripos($SQL, " LEFT JOIN ") !== false && stripos($SQL, " LEFT JOIN ") < $firstJoin) {
                $joinpos = stripos($SQL, " LEFT JOIN ");
            } elseif (stripos($SQL, " RIGHT JOIN ") !== false && stripos($SQL, " RIGHT JOIN ") < $firstJoin) {
                $joinpos = stripos($SQL, " RIGHT JOIN ");
            }

            $SQLArray["JOIN"] = substr($SQL, $joinpos, $counter - $joinpos);
            $counter = $joinpos;
        }
        $SQLArray["SELECT"] = substr($SQL, 0, $counter);

        return $SQLArray;
    }

    private static function queryJoin($SQLArray = []) {
        $SQL = "";
        $SQL = $SQLArray["SELECT"] . $SQLArray["JOIN"] . $SQLArray["WHERE"] . $SQLArray["GROUP"] . $SQLArray["HAVING"] . $SQLArray["ORDER"];
        return $SQL;
    }

    private static function restrictSQLOwned($SQL, &$param,$join=false,$group=false) {
        $SQLArray = DB::querySplit($SQL);
        $classname = static::class;
        // zun�chst wir davon ausgegangen, dass kein PArameter nach WHERE folgt

        if ($join!="" && $join !=NULL && $join!=false) {
            if ($SQLArray["JOIN"] != "") {
                $SQLArray["JOIN"] = $SQLArray["JOIN"] . " " . $join;
            } else {
                $SQLArray["JOIN"] = $join;
            }
        }
        if ($group!="" && $group!=false && $group !=NULL && $SQLArray["GROUP"] == "") {
            $SQLArray["GROUP"] =$group;
        }


        if ($SQLArray["WHERE"] != "") {
            $SQLArray["WHERE"] = $SQLArray["WHERE"] . " AND " . $classname . ".owner_id=?";
        } else {
            $SQLArray["WHERE"] = " WHERE " . $classname . ".owner_id=?";
        }
        array_push($param, Core::$user->id);
        return DB::queryJoin($SQLArray);
    }

    private static function restrictSQLNoData($SQL) {
        $SQLArray = DB::querySplit($SQL);
        // zun�chst wir davon ausgegangen, dass kein PArameter nach WHERE folgt
        if ($SQLArray["WHERE"] != "") {
            $SQLArray["WHERE"] = $SQLArray["WHERE"] . " AND 1=0";
        } else {
            $SQLArray["WHERE"] = " WHERE 1=0";
        }

        return DB::queryJoin($SQLArray);
    }

    private static function restrictSQLExpression($SQL, $expr, &$param, $newparam = [], $join=false,$group=false) {
        $SQLArray = DB::querySplit($SQL);
        // zun�chst wir davon ausgegangen, dass kein PArameter nach WHERE folgt und zun�chst ohne Parameter
        if ($SQLArray["GROUP"] == "" && $group!=false && $group!="" && $group!=NULL) {
            $SQLArray["GROUP"] = " ".$group;
        }
        if ($SQLArray["WHERE"] != "") {
            if ($expr!="") {
                $SQLArray["WHERE"] = $SQLArray["WHERE"] . " AND $expr";
            }
        } else {
            if ($expr!="") {
                $SQLArray["WHERE"] = " WHERE $expr";
            }
        }
        if ($join != "" && $join!=false && $join!=NULL) {
            if ($SQLArray["JOIN"] != "") {
                $SQLArray["JOIN"] = $SQLArray["JOIN"] . " " . $join;
            }else{
                $SQLArray["JOIN"] = " ".$join;
            }
        }
        foreach ($newparam as $new) {
            if (stristr($new, "$") !== false) {
                if (stristr($new, "::") !== false) {
                    $tmp = explode("::", $new);
                    $klasse = $tmp[0];
                    $vars = get_class_vars("$klasse");
                    $prop = substr($tmp[1], 1);
                    if (stristr($prop, "->") !== false) {
                        $tmp2 = explode("->", $prop);
                        $obj = $vars[$tmp2[0]];
                        $att = $tmp2[1];
                        $new = $obj->$att;
                    } else {
                        $new = $vars[$prop];
                    }
                } else {
                    $new = $$new;
                }
            } elseif (stristr($new, "::") !== false && stristr($new, "(") !== false && stristr($new, ")") !== false) { // Funktionsaufruf
                $tmp = explode("::", $new);

                $a = $tmp[0];
                $tmp2 = explode("(", $tmp[1]);
                $b = $tmp2[0];
                $c = substr($tmp2[1], 0, -1);
                $new = $a::$b($c);
            }
            array_push($param, $new);
        }

        //  array_push($param,Core::$user->id);
        return DB::queryJoin($SQLArray);
    }

    /**
     * Statisch. Gibt eine Liste/Array von Objekten einer SQL-Anweisung zur�ck. Wird nichts angegeben, wird <b><i>SQL_SELECT_ALL</i></b> verwendet.<br>Hier kann eine <b>eigene</b> SQL-Anweisung direkt aus der <b>DB</b>-Klasse ausgef�hrt werden.. R�ckgabe-Klasse ist diejenige, die neben <i>FROM</i> steht.
     * @param String $SQL
     * @param Array $param
     * @return Array(Standardobjekte)|false
     * @example <code>$liste=Artikel::findAll()</code><br>Anhand von SQL_SELECT_ALL<br><code>$liste=Artikel::findAll("SELECT * FROM Artikel WHERE Bezeichnung LIKE '%test%')</code><br><code>$liste=Artikel::findAll("SELECT * FROM Artikel WHERE Bezeichnung LIKE ?,['%test%'])</code> 
     */
    public static function findAll($SQL = "", $param = array()) {
        if ($SQL == "") {
                $SQL = static::SQL_SELECT_ALL;

        }
        $classname = static::class;
        if (static::$SQLidentifier) {
            $ident = static::$settings["identifier"];
            $SQLArray = db::querySplit($SQL);
            $SQLArray["SELECT"] = "SELECT " . $SQLArray["DISTINCT"] . $ident . " AS identifier, " . substr($SQLArray["SELECT"], 6 + strlen($SQLArray["DISTINCT"]));
            $SQL = db::queryJoin($SQLArray);
        }else{
            $SQLArray = db::querySplit($SQL);
            $SQLArray["SELECT"] = "SELECT " . $SQLArray["DISTINCT"] . substr($SQLArray["SELECT"], 6 + strlen($SQLArray["DISTINCT"]));
            $SQL = db::queryJoin($SQLArray);  
        }
        if (static::$SQLautojoin) {
            foreach (static::$dataScheme as $key => $scheme) {
                if (isset($scheme["stereotype"])) {
                    if ($scheme["stereotype"] == "relation" && ($scheme["join"] == "INNER" || $scheme["join"] == "LEFT" || $scheme["join"] == "RIGHT" )) {
                        $SQLArray = db::querySplit($SQL);
                        $relationClass = $scheme["class"];
                        $classAlias = $scheme["classAlias"];
                        $basis = static::class;
                         $joinAdapted=$scheme["join"];
                        if(static::$settings['strictJoin']=="false"){ // Korrektur Lazy JOIN =>LEFT
                          $joinAdapted=  "LEFT";
                        }
                        $newJoin = " " .  $joinAdapted . " JOIN $relationClass AS $classAlias ON $relationClass.id=$basis.$key";
                     
                        $SQLArray["JOIN"] = $SQLArray["JOIN"] . $newJoin;
                        $from = stripos($SQLArray["SELECT"], " FROM");
                        $length = strlen($SQLArray["SELECT"]);
                        $left = substr($SQLArray["SELECT"], 0, $from);
                        $right = substr($SQLArray["SELECT"], -($length - $from));
                        if ($scheme["identifier"] == "") {
                            $scheme["identifier"] = $relationClass::$settings["identifier"];
                        }
                        if (static::$activeViewport != "") {
                            if (isset($scheme["renderAs"][static::$activeViewport]["identifier"])) {
                                if ($scheme["renderAs"][static::$activeViewport]["identifier"] != "") {
                                    $scheme["identifier"] = $scheme["renderAs"][static::$activeViewport]["identifier"];
                                }
                            }
                        }


                        if (static::$SQLidentifier) {
                            $left = $left . ", " . $scheme["identifier"] . " AS " . $key . "_identifier";
                        }
                        $SQLArray["SELECT"] = $left . $right;
                        $SQL = db::queryJoin($SQLArray);
                        $a = 55;
                    }
                }
            }
        }
 

        if (static::$access == true && static::$SQLrestrict) {
            $access = static::$settings["access"];
            if (is_array($access)) {

                $gruppe = "G" . Core::$user->Gruppe;
                if (is_array($access[$gruppe])) {
                    switch ($access[$gruppe]["data"]) {
                        case "all":
                            $join = $access[$gruppe]["join"];
                            $group = $access[$gruppe]["group"];
                            if ($SQLArray["GROUP"] == "" && $group!="" && $group!=NULL){
                                $SQLArray["GROUP"] = $group;
                            }
                            if ($join!="" && $join!=NULL) {
                                $SQLArray["JOIN"] = $SQLArray["JOIN"] . " " . $join;
                            }
                            $SQL = db::queryJoin($SQLArray);
                            break;
                        case "owned":
                            $join = $access[$gruppe]["join"];
                            $group = $access[$gruppe]["group"];
                            $SQL = self::restrictSQLOwned($SQL, $param,$join,$group);
                            break;
                        case "expression":
                            // no safe paraeters!!
                            $join = $access[$gruppe]["join"];
                            $group = $access[$gruppe]["group"];
                            if(static::$activeViewport!="new") {
                                $restriction = $access[$gruppe]["restriction"];
                                $newparams = explode(",", $access[$gruppe]["param"]);
                            }else{
                                $restriction="";
                                $newparams=[];
                            }


                            $SQL = self::restrictSQLExpression($SQL, $restriction, $param, $newparams, $join,$group);
                            break;
                        default:
                            $SQL = self::restrictSQLNoData($SQL);
                    }
                }
            }
        }


        $db = Core::$pdo;
        $daten[] = array();
        
        Core::log(get_called_class()."#".__FUNCTION__."(): ".$SQL);
        $stmt = $db->prepare($SQL);
        $result = $stmt->execute($param);
        // Debugging und resultierende SQL-Anweisung
        self::stmtDebug($stmt);
        ///

        $daten = $stmt->fetchAll(PDO::FETCH_CLASS, get_called_class());
        // $this->import($test);
        return $daten;
    }

    /**
     * Legt aus dem aktuellen Objekt einen Datensatz an. Wenn nicht anders angegeben mit <b><i>SQL_INSERT</i></b>. Der erzeugte Prim�rschl�ssel wird im Objekt aktualisiert.<br>Sollten durch SQL (Default-Werte, autotimestamp...) weitere eigene Werte erzeugt worden sein, wird ein erneutes <b><i>loadDBData()</i></b>empfohlen<br> Zeitstempel werden automatisch gesetzt.
     * @param Array $param Ein ordinales Array mit den Feldern in korrekter Reihenfolge. Wenn nicht angegeben, automatisch aus Insert-Anweisung generiert.
     * @param String $SQL ggf. eigene SQL-Anweisung
     * @example <code>$result=$myObject->create()</code><br>Anhand von SQL_INSERT<br><code>$result=$myObject->create("INSERT INTO...VALUES(?,?)")</code><br>Attributwerte werden �bernommen<br><code>$result=$myObject->create("INSERT INTO...VALUES(?,?)",[$var1,$var2])</code><br>Werte separat �bergeben

     * @return Long Die via autoincrement angelegte ID, der letzten Anweisung
     */
    public function create($SQL = "", $param = array()) {

        $db = Core::$pdo;
        if ($SQL == "") {
            $SQL = static::SQL_INSERT;
        }

        if (static::$access == true) {

            $this->owner_id = core::$user->id;
            $this->created_id = core::$user->id;
            $this->modified_id = core::$user->id;
        }


        if ($param[0] == "") { // Dann zieht er sich automatisch die Feldnamen aus der Insert Anweisung
            $start = strpos($SQL, "(");
            $ende = strpos($SQL, ")");
            $fields = substr($SQL, $start + 1, ($ende - $start - 1));
            $fieldlist = explode(",", $fields);

            if (static::$access == true) {
                array_push($fieldlist, "`owner_id`");
                array_push($fieldlist, "`created_id`");
                array_push($fieldlist, "`modified_id`");
                $SQL = str_replace("?)", "?, ?, ?, ?)", $SQL); // Parameter erg�nzen in SQL
                $SQL = Help::str_replace_first(")", ", `owner_id` , `created_id` , `modified_id` )", $SQL);
            }

            foreach ($fieldlist as $field) {
                $feld = trim($field);
                //Die Zeichen `` werden entfernt
                if (stristr($feld, '`') != FALSE) {
                    $feld = substr($feld, 1, -1);
                }


                array_push($param, $this->$feld);
            }
        }

          Core::log(get_called_class()."#".__FUNCTION__."(): ".$SQL);
        $stmt = $db->prepare($SQL);
        $result = $stmt->execute($param);

        self::stmtDebug($stmt);


        $autoID = $db->lastInsertId();
        $col = static::SQL_PRIMARY_KEY;
        $this->$col = $autoID;
        return $autoID;
    }

    /**
     * Aktualisiert die Daten in der Datenbank mit den Werten des aktuellen Objektes. Standardm��ig <b><i>SQL_UPDATE</i></b>
     * @param String $SQL
     * @param Array $param  Ordinales Array mit Feldliste, der zu aktualisierenen Feldern.<br> Wenn nicht angegeben, werden die Felder automatisch aus  Der SQL-Anweisung bzw. SQL_UPDATE generiert

     * @return boolean
     * @example <code>$result=myObject->update()</code> anhand SQL_UPDATE<br><code>$result=myObject->update("UPDATE User SET Vorname=?")</code><br>�bernimmt automatisch Attributwert Vorname<br><code> myObject->update("UPDATE User Set Vorname=?",["Klaus"])</code><br>Aktualisiert die Tabelle direkt mit konkreten (Variablen-)Werten
     */
    public function update($SQL = "", $param = array()) { // Aktualisiert das aktuelle Element
        $db = Core::$pdo;
        if ($SQL == "") {
            $SQL = static::SQL_UPDATE;
        }
        if (static::$access == true) {

            $this->modified_id = core::$user->id;
            $SQL = str_ireplace(" WHERE ", " , `modified_id`=? WHERE ", $SQL);
        }

          Core::log(get_called_class()."#".__FUNCTION__."(): ".$SQL);
        $stmt = $db->prepare($SQL);

        if ($param[0] == "") {     // Aus SET-Anweisung die Felder extrahieren
            $abschnitt = explode('=', $SQL);

            foreach ($abschnitt as $teil) {
                $tmp = rtrim($teil); //F�ngt ab, falls zwischen Feld un = ein Leerzeichen war
                $pos = strripos($tmp, " ");
                $tmp2 = substr($tmp, $pos + 1);
                $tmp2 = ltrim($tmp2, ",");
                if (stristr($tmp2, '`') != FALSE) {
                    $tmp2 = substr($tmp2, 1, -1);
                }
                if ($tmp2 != "") {
                    array_push($param, $this->$tmp2);
                }
            }
        }

        $result = $stmt->execute($param);

        self::stmtDebug($stmt);
        return $result;
    }

    /**
     * Statisch. L�scht einen einzelnen Datensatz
     * @param Long $id Prim�rschl�sselwert des zu L�schenden Datensatzes auf Grundlage <b><i>SQL_DELETE_PK</i></b><br>Alternativ SQL-Abfrage+Parameter
     * @param Array $param Parameterwerte f�r SQL-Anweisung
     * @return boolean
     * @example <code>$result=Artikel::delete(27)</code><br><code>$result=Artikel::delete("DELETE FROM Artikel WHERE id=? OR id=?",[5,8])</code>
     */
    public static function delete($id, $param = array()) {
        $db = Core::$pdo;

        if (count($param) > 0) {
            $stmt = $db->prepare($id); // SQL-Anweisung
            $result = $stmt->execute([$param]);
        } else {
            if ($id != "") {
                $stmt = $db->prepare(static::SQL_DELETE);
                $result = $stmt->execute([$id]);
                return $result;
            } else {
                return false;
            }
        }
    }

    /**
     * F�hrt ein Prepared-SQL-Statement aus(PDO). Es sollte sich um eine Auswahlabfrage handeln, die ein oder mehrere Elemente zur�ckliefert.<br>Sie werden als Standardobjekte in einem Array zur�ckgegeben.<br>Standardobjekte beinhalten alle Attribute der Abfrage, aber keine Methoden etc.
     * @param String $SQL SQL-Statement (prepared). Parameter werden �ber Fragezeichen angegeben, Werte m�ssen in gleicher Reihenfolge �ber <b><i>$param</i></b> �bergeben werden 
     * @param Array $param Ordinales Array mit den Werten f�r die SQL Anweisung
     * @return ObjektArray
     * @example <code>$liste=Artikel::query("SELECT * FROM Artikel ORDER BY ?",["Bezeichnung"])</code<br><code>db::query("SELECT * FROM Artikel INNER JOIN...")</code>
     */
    public static function query($SQL, $param = array()) {
        $SQLArray = db::querySplit($SQL);
         if (static::$SQLautojoin) {
            
            foreach (static::$dataScheme as $key => $scheme) {
                if (isset($scheme["stereotype"])) {
                    if ($scheme["stereotype"] == "relation" && ($scheme["join"] == "INNER" || $scheme["join"] == "LEFT" || $scheme["join"] == "RIGHT" )) {
                        $relationClass = $scheme["class"];
                        $classAlias = $scheme["classAlias"];
                        $basis = static::class;
                        $joinAdapted=$scheme["join"];
                        if(static::$settings['strictJoin']=="false"){ // Korrektur Lazy JOIN =>LEFT
                          $joinAdapted=  "LEFT";
                        }
                        $newJoin = " " . $joinAdapted . " JOIN $relationClass AS $classAlias ON $relationClass.id=$basis.$key";
                        $SQLArray["JOIN"] = $SQLArray["JOIN"] . $newJoin;
                        $SQL = db::queryJoin($SQLArray);
                    }
                }
            }
        }
        if (static::$access == true && static::$SQLrestrict) {
            $access = static::$settings["access"];
            if (is_array($access)) {
                $gruppe = "G" . Core::$user->Gruppe;
                if (is_array($access[$gruppe])) {
                    switch ($access[$gruppe]["data"]) {
                        case "all":
                            $join = $access[$gruppe]["join"];
                            if ($join!="" && $join!=NULL) {
                                $SQLArray["JOIN"] = $SQLArray["JOIN"] . " " . $join;
                            }
                            $SQL = db::queryJoin($SQLArray);
                            break;
                        case "owned":
                            $join = $access[$gruppe]["join"];
                            $SQL = self::restrictSQLOwned($SQL, $param,$join);
                            break;
                        case "expression":
                            // no safe paraeters!!
                            $join = $access[$gruppe]["join"];
                            $SQL = self::restrictSQLExpression($SQL, "", $param, array(), $join);
                            break;
                    }
                }
            }
        }
        $db = Core::$pdo;
          Core::log(get_called_class()."#".__FUNCTION__."(): ".$SQL);
        $stmt = $db->prepare($SQL);
        $result = $stmt->execute($param);
        self::stmtDebug($stmt);
        $class = get_called_class();
        if (class_exists($class) & $class != "DB") {
            $daten = $stmt->fetchAll(PDO::FETCH_CLASS, $class);
        } else {
            $daten = $stmt->fetchAll(PDO::FETCH_CLASS);
        }

        return $daten;
    }

    /**
     * F�hrt ein Prepared-SQL-Statement als Aktionsabfrage(UPDATE, DELETE etc.) aus(PDO). Als Ergebnis wird true oder false zur�ckgegeben
     * @param String $SQL SQL-Statement (prepared). Parameter werden �ber Fragezeichen angegeben, Werte m�ssen in gleicher Reihenfolge �ber <b><i>$param</i></b> �bergeben werden 
     * @param Array $param Ordinales Array mit den Werten f�r die SQL Anweisung
     * @return boolean
     * @example <code>$result=db::execQuery("Update Artikel SET...WHERE id=?,[...,27])</code>
     * 
     */
    public static function execQuery($SQL, $param = array()) {
        $db = Core::$pdo;
          Core::log(get_called_class()."#".__FUNCTION__."(): ".$SQL);
        $stmt = $db->prepare($SQL);
        $result = $stmt->execute($param);
        self::stmtDebug($stmt);


        return $result;
    }

    /**
     * �bertr�gt Formulardaten direkt in das aktuelle Objekt.<br>Die Zuordnung der Formularfelder zu den Attributen erfolgt �ber den Parameter <b><i>$mapping</i></b>. Wenn nicht angegeben, wird <b><i>$dataMapping</i></b> der Klasse verwendet.<br>
     * Alle Felder werden automatisch nach den Vorgaben in  <b><i>$sanitizeMapping</i></b> und  <b><i>$validateMapping</i></b> bereinigt und validiert.
     * @param Array $mapping Assoziatives Array mit Attribut=>Formularfeld Paaren (siehe <i>DB::dataMapping</i>)
     * @param String $method POST oder GET

     * @return Boolean gibt by Validation-Error false zur�ck ansonsten true   
     * @example <code>$result=$object->loadFormData()</code>
     */
    public function loadFormDataOld($mapping = array(), $method = "POST") {
        $success = true;
        if (count($mapping) == 0) {
            $mapping = $this->dataMapping;
        }
        foreach ($mapping as $fieldname => $value) {
            if ((isset($_POST[$this->dataMapping[$fieldname]]) || $this->strictMapping == true)) {
                if ($this->sanitizeMapping[$fieldname] != "") {
                    $sanitize = constant($this->sanitizeMapping[$fieldname]);
                } else {
                    $sanitize = constant(Core::$defaultFilterSanitize);
                }
                // SANITIZE
                if ($sanitize == FILTER_SANITIZE_NUMBER_FLOAT) {  // zus�tzlich optionalen Parameter 
                    $wert = filter_var($_POST[$this->dataMapping[$fieldname]], $sanitize, FILTER_FLAG_ALLOW_FRACTION);
                } else {
                    $wert = filter_var($_POST[$this->dataMapping[$fieldname]], $sanitize);
                }

                if ($this->validateMapping[$fieldname] != "") {
                    $validate = constant($this->validateMapping[$fieldname]);
                    $wert = filter_var($wert, $validate, FILTER_NULL_ON_FAILURE);
                }





                if ($wert === NULL) {
                    $this->$fieldname = NULL;

                    Core::debug("Validation Error for {" . $fieldname . "}");
                    Core::addError("Bitte geben Sie g�ltige Daten f�r �" . $fieldname . "�an");
                    $success = false;
                } else {

                    $this->$fieldname = $wert;
                }
            } else {
                $this->$fieldname = NULL;
                Core::debug("Validation Skipped(No Formdata) for {" . $fieldname . "}");
            }
        }
        return $success;
    }

    public function loadFormData($mapping = array(), $method = "POST") {
        $success = true;
        if (count($mapping) == 0) {
            $mapping = $this->dataMapping;
        }
        foreach ($_POST as $fieldname => $value) {
            $attribute = $fieldname;
            if (isset($_POST[$mapping[$fieldname]])) {
                $attribute = $mapping[$fieldname];
            }
            $sanitize = constant(Core::$defaultFilterSanitize);


            $this->$attribute = filter_var($_POST[$fieldname], $sanitize);


            $a = 1;
        }
        $this->unformat();
        $a = 1;
        return $this->validate();
    }

    /**
     *  Private Funktion zur Ausgabe von Fehlern w�hrend eines Prepared Statements
     * @param PDOStatement $stmt Das zu untersuchende Prepared-Statement-Objekt
     */
    private static function stmtDebug($stmt) {
        ob_start();
        $stmt->debugDumpParams();
        $tmp = ob_get_contents();
        $a = strpos($tmp, 'Key: Position');
        $info = substr($tmp, 0, $a);
        ob_clean();
        Core::debug($info);
    }

    /**
     * �bertr�gt die Daten aus einem anderen Objekt in das aktuelle Objekt (clone).<br>Damit kann das Ergebnis einer Abfrage in das aktuelle Objekt �bertragen werden.
     * @param type $object Objekt der gleichen Klasse, welche die Methode aufruft
     * @example <code>$object->import($stdobject)</code><br>L�dt Standardobjekt als vollwertige Instanz
     */
    public function import($object) {

        if (is_array($object)) {  // betrifft ggf. Standardobject aus Query
            foreach (get_object_vars($object[0]) as $key => $value) {
                $this->$key = $value;
            }
        } else {
            foreach (get_object_vars($object) as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Aktualisiert/erstellt eine Datei in DB und im Filesystem.<br> Standardm��ig wird ein Zufallsdateiname generiert.<br>�ber <i>options</i> k�nnen weitere Einstellungen vorgenommen werden
     * @param String $attribut Attribut/Feldname der Datei, die in der DB nur den Pfad enth�lt.
     * @param Array $options ist wie folgt vordefiniert und kann beim aufruf angepasst werden:<br>
      $opt=[<br>
      "path"=>"files/",<br>
      "fileinput"=>"", // Feldname im Formular (default=Attributname)<br>
      "random"=>"true", // false=>Original-Dateiname<br>
      "filename"=>"", //"" =>random oder Original Filename<br>
      "filetypes"=>"jpg;jpeg;JPG;png;PNG;GIF;gif;pdf;PDF",<br>
      "overwrite"=>"false",<br>
      "dbupdate"=>"true",<br>
      ];<br>
     * @example <code>$object->updateFile("Bild")</code><br><code>$object->updateFile("Bild",["path"=>"images/"])</code>
     */
    public function updateFile($attribut, $options = []) {
        $opt = [
            "path" => "images/",
            "pathDB" => "", // wenn Pfad in abweichendes Feld vom Upload geschrieben wird
            "fileinput" => "", // Feldname im Formular (default=Attributname)
            "random" => "true", // false=>Original-Dateiname
            "filename" => "", //"" =>random oder Original Filename
            "filetypes" => "jpg;jpeg;JPG;png;PNG;GIF;gif;pdf;PDF",
            "overwrite" => "false",
            "dbupdate" => "true", // Neben Upload wird Feld in DB geupdated
            "mandatory" => "true"
        ];
        foreach ($options as $optkey => $optval) {
            $opt[$optkey] = $optval;
        }
        $fileInput = $attribut;
        if ($opt['fileInput']) {
            if ($this->dataMapping[$attribut] != "") {
                $fileInput = $this->dataMapping[$attribut];
            }
        }
        if ($opt["pathDB"] == "") {
            $opt["pathDB"] = $fileInput;
        }
        $file = $_FILES[$fileInput];
        if ($file == NULL) {
            Core::addError("Dateifeld nicht vorhanden");
            return false;
        }
        if ($file['error'] == UPLOAD_ERR_OK) { // Datei�bertragung zum Server erfolgreich
            $endung = pathinfo($file['name'], PATHINFO_EXTENSION);
            $ftypes = explode(";", $opt["filetypes"]);
            if (!in_array($endung, $ftypes)) { // zul�ssiger Dateityp??
                Core::addError("Falscher Dateityp");
                return false;
            }
            if ($opt["random"] == "true") {
                $uniqid = uniqid();
            }

            if ($opt["filename"] != "") {
                $fullPath = $opt["path"] . $opt["filename"];
            } else {
                if ($opt["random"] == "true") {
                    $fullPath = $opt["path"] . $uniqid . "." . $endung;
                } else {
                    $fullPath = $opt["path"] . $file['name'];
                }
            }
            if ($opt["filename"] != "") {
                $fullPath = $opt["path"] . $opt["filename"];
            } else {
                if ($opt["random"] == "true") {
                    $fullPath = $opt["path"] . $uniqid . "." . $endung;
                } else {
                    $fullPath = $opt["path"] . $file['name'];
                }
            }

            // Pr�fen, ob vorhanden
            if (is_file($fullPath)) {
                if ($opt['overwrite'] == "true") {
                    Core::addMessage("Datei �berschrieben");
                } else {
                    Core::addError("Datei bereits vorhanden. Abbruch");
                    return false;
                }
            }

            $erg = move_uploaded_file($file['tmp_name'], $fullPath);
            if (!$erg) {
                Core::addError("Datei konnte nicht gespeichert werden");
                return false;
            } else {

                if ($this->$attribut != "") {
                    // alte Datei l�schen
                    unlink($this->$attribut);
                }

                //$this->$attribut = $fullPath;
                $feld = $opt["pathDB"];
                $this->$feld = $fullPath;

                $class = get_class($this);
                $SQL = "UPDATE $class SET $feld=? WHERE id=?";
                if ($opt["dbupdate"] == "true") {
                    $this->update($SQL);
                }
                return true;
            }
        } else { // Fehler oder keine Datei
            switch ($file['error']) {
                case UPLOAD_ERR_NO_FILE:
                    if ($opt['mandatory'] == "false") {
                        return true; //kein Fehler aber kein Update in DB und kein Upload
                    } else {
                        core::addError("Es wurde keine Datei ausgew�hlt");
                        return false;
                    }
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    core::addError("Datei kann nicht auf dem Server gepeichert werden");
                    return false;
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    core::addError("Kein tempor�res Serververziechnis vorhanden");
                    return false;
                    break;
                case UPLOAD_ERR_EXTENSION:
                    core::addError("PHP-Erweiterung hat Upload verhindert");
                    return false;
                    break;
                case UPLOAD_ERR_INI_SIZE:
                    core::addError("Datei �berschreitet maximale Dateigr��e");
                    return false;
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    core::addError("Datei �berschreitet im Formular definierte Dateigr��e");
                    return false;
                    break;
                case UPLOAD_ERR_PARTIAL:
                    core::addError("Die Datei wurde nur teilweise hochgeladen");
                    return false;
                    break;
                default:
                    core::addError("Unbekannter Fehler");
                    return false;
            }
        }
    }

    /**
     * Pr�ft alle Attribute Anhand des vorgebebenen Schemas<br> 
     * 
     */
    Public function validate($strict = false) {

        $validateErrors = [];
        foreach (static::$dataScheme as $att => $value) {
            switch ($value["type"]) {
                case static::TYPE_PRIMARY:
                    if ($strict && !isset($this->$att) && $value["null"] === false) { // Nullwerte bei Bedarf pr�fen
                        array_push($validateErrors, $att . ": must not be Null");
                        Core::addError($att . ": must not be Null");
                    } else {
                        if (!static::my_is_int($this->$att) && isset($this->$att)) { // ist eine Ganzahl?
                            array_push($validateErrors, $att . ": �" . $this->$att . "� is not a valid Key(no Integer)");
                            Core::addError($att . ": �" . $this->$att . "� is not a valid Key(no Integer)");
                        }
                    }
                    break;
                case static::TYPE_INTEGER:
                    if ($strict && !isset($this->$att) && $value["null"] === false) { // Nullwerte bei Bedarf pr�fen
                        array_push($validateErrors, $att . ": must not be Null");
                        Core::addError($att . ": must not be Null");
                    } elseif (!is_null($this->$att)) {
                        if (!static::my_is_int($this->$att)) { // ist eine Ganzahl?
                            array_push($validateErrors, $att . ": �" . $this->$att . "� is not an  Integer");
                            Core::addError($att . ": �" . $this->$att . "� is not an  Integer");
                        } else { // zus�tzliche Optionen pr�fen
                            if (isset($value["min"])) {
                                if ($this->$att < $value["min"]) {
                                    array_push($validateErrors, $att . ": �" . $this->$att . "� is lower than " . $value["min"]);
                                    Core::addError($att . ": �" . $this->$att . "� is lower than " . $value["min"]);
                                }
                            }
                            if (isset($value["max"])) {
                                if ($this->$att > $value["max"]) {
                                    array_push($validateErrors, $att . ": �" . $this->$att . "� is bigger than " . $value["max"]);
                                    Core::addError($att . ": �" . $this->$att . "� is bigger than " . $value["max"]);
                                }
                            }
                        }
                    }
                    break;

                case static::TYPE_STRING:
                    if ($strict && !isset($this->$att) && $value["null"] === false) {
                        array_push($validateErrors, $att . ":  must not be empty");
                        Core::addError($att . ":  must not be empty");
                    } elseif (!is_null($this->$att)) {
                        if (isset($value["maxlength"])) {
                            if (strlen($this->$att) > $value["maxlength"]) {
                                array_push($validateErrors, $att . ":  �" . $this->$att . "� too many characters (" . $value["maxlength"] . ")");
                                Core::addError($att . ":  �" . $this->$att . "� too many characters (" . $value["maxlength"] . ")");
                            }
                        }
                        if (isset($value["minlength"])) {
                            if (strlen($this->$att) < $value["minlength"]) {
                                array_push($validateErrors, $att . ":  �" . $this->$att . "� not enough characters (" . $value["minlength"] . ")");
                                Core::addError($att . ":  �" . $this->$att . "� not enough characters (" . $value["minlength"] . ")");
                            }
                        }





                        if (isset($value["regex"])) {
                            if (preg_match($value["regex"], $this->$att) === 0) {
                                array_push($validateErrors, $att . ":  �" . $this->$att . "� doesn't match pattern (" . $value["regex"] . ")");
                                Core::addError($att . ":  �" . $this->$att . "� doesn't match pattern (" . $value["regex"] . ")");
                            }
                        }
                    }
                    break;
                case static::TYPE_TIMESTAMP:
                    if ($strict && !isset($this->$att) && $value["null"] === false) { // Nullwerte verboten?
                        array_push($validateErrors, $att . ":  must not be Null");
                        Core::addError($att . ":  must not be Null");
                    } else {
                        
                    }
                    break;
                case static::TYPE_DATE:
                    if ($strict && !isset($this->$att) && $value["null"] === false) { // Nullwerte verboten?
                        array_push($validateErrors, $att . ":  must not be Null");
                        Core::addError($att . ":  must not be Null");
                    } else {
                        
                    }
                    break;
                case static::TYPE_FLOAT:
                    if ($strict && !isset($this->$att) && $value["null"] === false) { // Nullwerte verboten?
                        array_push($validateErrors, $att . ":  must not be Null");
                        Core::addError($att . ":  must not be Null");
                    } elseif (!is_null($this->$att)) { // Wenn nicht Null
                        if (is_numeric($this->$att) === false) { // ist eine Ganzahl?
                            array_push($validateErrors, $att . ": �" . $this->$att . "� is not a Float");
                            Core::addError($att . ": �" . $this->$att . "� is not a Float");
                        } else { // zus�tzliche Optionen pr�fen
                            if (isset($value["min"])) {
                                if ($this->$att < $value["min"]) {
                                    array_push($validateErrors, $att . ": �" . $this->$att . "� is lower than " . $value["min"]);
                                    Core::addError($att . ": �" . $this->$att . "� is lower than " . $value["min"]);
                                }
                            }
                            if (isset($value["max"])) {
                                if ($this->$att > $value["max"]) {
                                    array_push($validateErrors, $att . ": �" . $this->$att . "� is bigger than " . $value["max"]);
                                    Core::addError($att . ": �" . $this->$att . "� is bigger than " . $value["max"]);
                                }
                            }
                        }
                    }
                    break;

                default :
                    if ($value["type"] != "string") {
                        if ($this->$att == "") {
                            $this->$att = null;
                        }
                    }
            }
        }

        if (count($validateErrors) > 0) {
            return $validateErrors;
        } else {
            return true;
        }
    }

    Public Function format($att, $viewport = "") {
        if ($viewport == "") {
            $viewport = Core::$view->viewport[Core::$currentView];
        }
        $scheme = static::$dataScheme[$att];
        switch ($scheme["type"]) {
            case "string":
                return $this->$att;
                break;
            case "integer":
                return $this->$att;
                break;
            case "float":
                if ($viewport != "") {
                    if ($scheme['renderAs'][$viewport]['control'] == "currencyfield") {
                        $fmt = new NumberFormatter('de_DE', NumberFormatter::CURRENCY);
                        return $fmt->formatCurrency($this->$att, "EUR");
                    } else {
                        return str_replace(".", ",", $this->$att);
                    }
                } else {
                    return str_replace(".", ",", $this->$att);
                }
                break;
            case "timestamp":
                $ts = strtotime($this->$att);
                $format = $scheme["textformat"];
                return date($format, $ts);
                break;
            case "date":
                if ($this->$att != "" && $this->$att != null) {
                    $ts = strtotime($this->$att);
                    $format = $scheme["textformat"];
                   
                    return date($format, $ts);
                } else {
                    return $this->$att;
                }

                break;
            case "datetime":
                $ts = strtotime($this->$att);
                $format = $scheme["textformat"];
                return date($format, $ts);
                break;
            case "currency":
                $fmt = new NumberFormatter('de_DE', NumberFormatter::CURRENCY);

                return $fmt->formatCurrency($this->$att, "EUR");
                break;
            default:
                return $this->$att;
        }
    }

    Public Function textformat($att) {
        $scheme = static::$dataScheme[$att];
        switch ($scheme["type"]) {
            case "string":
                return $this->$att;
                break;
            case "integer":
                return $this->$att;
                break;
            case "float":
            case "currency":
                if ($this->$att == "" || $this->$att == Null) {
                    return "-"; //$this->$att;
                } else {


                    if (!isset($scheme["textformat"])) {

                        $fmt = new NumberFormatter('de_DE', NumberFormatter::DECIMAL);
                        $fmt->setPattern("#0,##");
                        $fmt->setAttribute(NumberFormatter::GROUPING_USED, FALSE);
                        return $fmt->format($this->$att);
                    } else {
                        switch ($scheme["textformat"]) {
                            case "":
                                $fmt = new NumberFormatter('de_DE', NumberFormatter::DECIMAL);
                                $fmt->setAttribute(NumberFormatter::GROUPING_USED, FALSE);
                                $fmt->setPattern("#0,##");
                                return $fmt->format($this->$att);
                                break;
                            case "currency":
                                $fmt = new NumberFormatter('de_DE', NumberFormatter::CURRENCY);
                                //  $fmt->setPattern("#0.## kg");
                                return $fmt->formatCurrency($this->$att, "EUR");
                                break;
                            case "scientific":
                                $fmt = new NumberFormatter('de_DE', NumberFormatter::SCIENTIFIC);
                                //  $fmt->setPattern("#0.## kg");
                                return $fmt->format($this->$att);
                                break;
                            case "round":
                                $fmt = new NumberFormatter('de_DE', NumberFormatter::ROUND_HALFUP);

                                //  $fmt->setPattern("#0.## kg");
                                return $fmt->format($this->$att);
                                break;
                            case "grouping":
                                $fmt = new NumberFormatter('de_DE', NumberFormatter::DECIMAL);
                                $fmt->setPattern("#0,##");
                                $fmt->setAttribute(NumberFormatter::GROUPING_USED, TRUE);
                                //  $fmt->setPattern("#0.## kg");
                                return $fmt->format($this->$att);
                            default: // eigener Ausdruck
                                $fmt = new NumberFormatter('de_DE', NumberFormatter::DECIMAL);
                                $fmt->setPattern($scheme["textformat"]);
                                return $fmt->format($this->$att);
                        }
                    }
                }




                break;
            case "timestamp":
                $ts = strtotime($this->$att);
                $format = $scheme["textformat"];
                return date($format, $ts);
                break;
            case "date":
                if ($this->$att != "" && $this->$att != null) {
                    $ts = strtotime($this->$att);
                    $format = $scheme["textformat"];
                    return date($format, $ts);
                } else {
                    return $this->$att;
                }
                break;
            case "datetime":
                $ts = strtotime($this->$att);
                $format = $scheme["textformat"];
                return date($format, $ts);
                break;
            default:
                return $this->$att;
        }
    }

    Public function format_old($viewport = "list") {
        foreach (static::$dataScheme as $att => $value) {

            switch ($value["type"]) {
                case static::TYPE_INTEGER:

                    break;
                case static::TYPE_DATE:
                    if (static::my_is_int($this->$att)) { // timestamp in Datum uwandeln
                        $format = "d.m.Y";
                        if (isset($value["format"])) {
                            $format = $value["format"];
                        }
                        $this->$att = date($format, $this->$att);
                    }
                    $aa = 1;
                    break;
                case static::TYPE_FLOAT:
                    if (is_numeric($this->$att)) {
                        $decimals = "2";
                        $thousands = ".";
                        $decimalsep = ",";
                        if (isset($value["format"])) {
                            $decimals = $value["format"][0];
                            $thousands = $value["format"][2];
                            $decimalsep = $value["format"][1];
                        }
                        $this->$att = number_format($this->$att, $decimals, $decimalsep, $thousands);
                    }
                    break;
            }
            // Einheit erg�nzen nur bei action="show"
            if ($action == "show") {
                if (isset($value["unit"])) {
                    $this->$att = $this->$att . " " . $value["unit"];
                }
            }
        }
    }

    Public function unformat() {
        foreach (static::$dataScheme as $att => $value) {

            switch ($value["type"]) {
                case static::TYPE_INTEGER:

                    break;
                case static::TYPE_DATE:
                    if (!static::my_is_int($this->$att) && isset($this->$att)) { // timestamp in Datum uwandeln
                        $format = "d.m.Y";
                        if (isset($value["format"])) {
                            $format = $value["format"];
                        }
                        $date = new DateTime();
                        $date = $date->createFromFormat($format, $this->$att);

                        $this->$att = $date->getTimestamp();
                    }

                    break;
                case static::TYPE_FLOAT:


                    $decimals = "2";
                    $thousands = ".";
                    $decimalsep = ",";
                    if (isset($value["format"])) {
                        $decimals = $value["format"][0];
                        $thousands = $value["format"][2];
                        $decimalsep = $value["format"][1];
                    }

                    // entfernen der Tausendertrennzeichen
                    $this->$att = str_replace($thousands, "", $this->$att);
                    // ersetzt Komma
                    $this->$att = str_replace($decimalsep, ".", $this->$att);
                    $a = 1;
                    break;
            }
        }
    }

    private static function my_is_int($s) {

        $erg = ctype_digit($s) || is_int($s);
        $aa = 3;
        return $erg;
    }

    public static function renderUnit($field) {
        $unit = "";
        if (isset(static::$dataScheme[$field]["unit"])) {
            $unit = " [" . static::$dataScheme[$field]["unit"] . "]";
        }
        return $unit;
    }

    public static function renderNav($class) {
        if (isset($class::$settings["navigation"])) {
            $gruppe = "G" . Core::$user->Gruppe;
            if (is_array($class::$settings["navigation"]["group"][$gruppe])) {
                $class::$settings["navigation"] = db::array_cascade([$class::$settings["navigation"], $class::$settings["navigation"]["group"][$gruppe]]);


                $nav = $class::$settings["navigation"];
                if ($nav["label"]!=""){
                    $label =$nav["label"];
                }else{
                    $label = $class;
                }
                if ($nav["display"] === true || $nav["display"] === "true" || $nav["display"] === "1") {

                    echo snippet::nav($label, $nav["mode"], $nav["task"], $nav["icon"], $nav["data-role"], $nav["theme"], $nav["class"]);
                } else {
                    return false;
                }
            }
        } else {
            return ucfirst($class);
        }
    }

    public function renderLabel($attr, $viewport = "") {
        if ($viewport == "" || $viewport == null) {
            $viewport = Core::$view->viewport[Core::$currentView];
        }



        $class = get_class($this);
         if(isset(Core::$view->dataScheme[Core::$currentView])){
           $scheme= Core::$view->dataScheme[Core::$currentView][$attr];
        }else{
          $scheme = static::$dataScheme[$attr];
        }
        if (isset($scheme["display"])) {   // wenn Attribut nicht angezeigt werden soll Rendern abbrechen
            if ($scheme["display"] === "false" || $renderAs["display"] === false || $renderAs["display"] === 0) {
                return false;
            }
        }
        $renderAs = $scheme["renderAs"][$viewport];
        if (isset($renderAs["display"])) { // Abbruch falls Element in diesem Modus nicht gerendert werden soll
            if ($renderAs["display"] === "false" || $renderAs["display"] === false || $renderAs["display"] === 0) { //|| $renderAs['control']==="checkbox"){
                return false;
            }
        }
        if (isset($scheme['groupIn'])) {
            if ($scheme['groupIn'] === true || $scheme['groupIn'] === 'true') {
                if (isset($scheme['sysParent'])) {
                    $parent = $scheme['sysParent'];
                    if (isset(static::$dataScheme[$parent]["group"])) {
                        if (static::$dataScheme[$parent]["group"] === true || static::$dataScheme[$parent]["group"] === "true") {
                            echo snippet::group($attr);
                        }
                    }
                }
            }
        }
        $label = $scheme["label"];
        if ($renderAs['control'] != "hidden") {  // Blacklist, wann nicht gerendert wird
            include("includes/getSnippet/label.php");
        }
    }

    /*
     * Rendert das Label als �berschrift (z.B. einer Tabelle)nach der Angabe des Labels im Datascheme
     * @param String $attr Name des Attributs
     * @param String $html Die Ausgabe des Header erfolgt inklusive HTML oder nur als Text<br>M�gliche Werte: "none" und "table"
     * @return boolean Gibt true oder false zur�ck.

     */

    public function renderHeader($attr, $html = "none") {
        if ($viewport == "" || $viewport == null) {
            $viewport = Core::$view->viewport[Core::$currentView];
        }
        if($viewport == ""){
            $viewport = "list";
        }

        $class = get_class($this);
        if(isset(Core::$view->dataScheme[Core::$currentView])){
           $scheme= Core::$view->dataScheme[Core::$currentView][$attr];
        }else{
          $scheme = static::$dataScheme[$attr];
        }
       
        if (isset($scheme["display"])) {   // wenn Attribut nicht angezeigt werden soll Rendern abbrechen
            if ($scheme["display"] === "false" || $renderAs["display"] === false || $renderAs["display"] === 0) {
                return false;
            }
        }
        $renderAs = $scheme["renderAs"][$viewport];
        if (isset($renderAs["display"])) { // Abbruch falls Element in diesem Modus nicht gerendert werden soll
            if ($renderAs["display"] === "false" || $renderAs["display"] === false || $renderAs["display"] === 0) {
                return false;
            }
        }

        $header = $scheme["label"];
        if ($renderAs["control"] != "hidden") {
            switch ($html) {
                case "none":
                    include("includes/getSnippet/header_plain.php");
                    break;
                case "table":
                    if (isset($renderAs["dataPriority"])){
                    $dataPriority=$renderAs["dataPriority"];                        
                    }
                    include("includes/getSnippet/header_table.php");
                    break;
                default:
                    include("includes/getSnippet/header_plain.php");
            }
        }
    }

    public function render($attr, $viewport = "", $as = "") {
        if ($viewport == "" || $viewport == null || !isset($viewport)) {
            $viewport = Core::$view->viewport[Core::$currentView];
        }

        $class = get_class($this);
        
        if(isset(Core::$view->dataScheme[Core::$currentView])){
           $scheme= Core::$view->dataScheme[Core::$currentView][$attr];
        }else{
          $scheme = static::$dataScheme[$attr];
        }
        if (isset($scheme["display"])) {   // wenn Attribut nicht angezeigt werden soll Rendern abbrechen
            if ($scheme["display"] == "false" || $scheme["display"] === false || $renderAs["display"] === 0) {
                return false;
            }
        }
        if (isset($scheme["derived"])) { // Bei Funktion abgeleitetet Attribut berechnen
            if ($scheme["derived"]["mode"] == "function") {
                // $this->$attr=$this->calc_BestOf();
                $functioname = $scheme["derived"]["calculation"];
                $this->$attr = $this->$functioname($this->id);
            }
        }



        $label = $scheme["label"];
        //  $renderAs = $scheme['renderAs'];
        $value = $this->$attr;
        $type = $scheme["type"];
        $stereotype = $scheme["stereotype"];


        // Fremschl�ssel
        if ($type == "foreign") {
            $txt = $attr . "_identifier";
            $value = $this->$txt;
        }


        $renderAs = $scheme["renderAs"][$viewport];
        $control = $renderAs["control"];
        if (isset($renderAs["display"])) { // Abbruch falls Element in diesem Modus nicht gerendert werden soll
            if ($renderAs["display"] === "false" || $renderAs["display"] === false || $renderAs["display"] === 0) {
                return false;
            }
        }


        if ($as != "") {
            $control = $as;
        }

        if (isset($renderAs["mode"])) {
            $mode = $renderAs["mode"];
        } else {
            $mode = "";
        }
        
        //für Login-Form
        if(isset($renderAs["datarole"])){
            $datarole = $renderAs["datarole"];
        }
        if(isset($renderAs["class"])){
            $class = $renderAs["class"];
        }
        if(isset($renderAs["placeholder"])){
            $placeholder = $renderAs["placeholder"];
        }
        if($viewport == "login"){
            $attr = $attr."1";
        }
        
        switch ($stereotype) {
            Case "primitive":

                switch ($control) {
                   
                    case "text": // umgestellt
                        if ($type != "foreign") {
                            $value = $this->textformat($attr);
                        }
                                               
                        echo controls::text($value, $mode, $attr, $renderAs["disabled"], $viewport);
                        break;
                    case "textbox": // umgestellt
                        $value = $this->format($attr, $viewport);
                        echo controls::textBox($attr, $value, $renderAs["disabled"], $renderAs["readonly"], $renderAs["format"], $placeholder, $datarole, $class);                     
                        break;
                    case "currencyfield":
                        $value = $this->textformat($attr);
                        if ($renderAs["readonly"] === true || $renderAs["readonly"] === "true") {
                            if ($viewport == "list") {
                                $mode = "plain";
                            } else {
                                $mode = "form";
                            }
                            echo snippet::text($value, $mode, $attr);
                            break;
                        } else {
                            $value = $this->format($attr);
                            echo snippet::currencyField($attr, $value, $renderAs["class"], $renderAs["disabled"], $renderAs["readonly"]);
                        }
                        //  include("includes/getSnippet/$control.php");
                        break;
                    case "password":
                        $value = $this->format($attr);
                        if ($viewport == "edit" || $viewport == "new") {
                            $doublecheck = true;
                        } else {
                            $doublecheck = false;
                        }
                        echo controls::password($attr, $value, $renderAs["disabled"], $renderAs["readonly"], $doublecheck, $placeholder, $datarole, $class);
                        //  include("includes/getSnippet/$control.php");
                        break;
                    case "hidden":
                        $value = $this->format($attr);
                        echo controls::hidden($attr, $value);
                        //  include("includes/getSnippet/$control.php");
                        break;
                    case "textarea": // umgestellt
                        $value = $this->format($attr);
                        echo controls::textArea($attr, $value, $renderAs["class"], $renderAs["disabled"], $renderAs["readonly"]);


                        break;
                    case "datefield":
                         
                        if($this->$attr=="" ||$this->$attr==null){
                            $value="";
                        }else{
                            $ts = strtotime($this->$attr);
                             $value = date("Y-m-d", $ts);
                        }
                        echo snippet::dateField($attr, $value, "", $renderAs["disabled"], $renderAs["readonly"]);
                        break;

                    case "datetime":

                        $ts = strtotime($this->$attr);
                        $value = date("Y-m-d H:i", $ts);
                        $value = str_replace(" ", "T", $value); // Gro�es T f�r Steuerelement einf�gen
                        echo snippet::dateTime($attr, $value, "", $renderAs["disabled"], $renderAs["readonly"]);
                        break;
                    case "time":
                        // Gro�es T f�r Steuerelement einf�gen
                        echo snippet::time($attr, $value, "", $renderAs["disabled"]);
                        break;
                    case "flipswitch":
                        // Gro�es T f�r Steuerelement einf�gen
                        $value = $this->format($attr);
                        echo controls::flipswitch($attr, $mode,$value, "", $renderAs["disabled"],$renderAs["readonly"]);
                        break;
                    case "checkbox":
                        $value = $this->format($attr);

                          echo controls::checkbox($attr, $mode,$value,  "", $renderAs["disabled"], $renderAs["readonly"]);
                        break;
                    case "option":
                        break;
                    case "link":

                        if ($viewport == "list") {
                            $class = "ui-btn ui-icon-eye ui-btn-icon-notext ui-corner-all ui-btn-inline";
                            $mode = "plain";
                            //       if($scheme["type"]=="float"){
                            //    $title=$this->textformat($attr);
                            //         }else{
                            $title = $this->$attr;
                            //     }
                        } else {
                            $class = "";
                            $mode = "form";
                            $title = $this->$attr;
                        }





                        echo snippet::link($attr, $title, $class, $mode);
                        break;
                    case "picture":
                        if(isset($renderAs["class"])){
                            $class=$renderAs["class"];
                        }else{
                            $class="";
                        }
                        $src = $this->$attr;
                        echo controls::picture($attr, $src, $class, $mode);
                        break;
                    case "slider":
                        $value = $this->format($attr);
                        echo snippet::slider($attr, $value, "", $renderAs["disabled"]);
                        break;
                    case "fileupload":
                        echo snippet::fileupload($attr);
                        break;
                    /* case "groupIn":
                      echo "<div style='border: solid 2px'>";
                      case "groupOut":
                      echo "<div>"; */
                    case "filepicture":
                        $src = $this->$attr;
                        if ($viewport == "list") {
                            $class = "picture_thumb";
                            if(isset($renderAs["mode"])){
                                $mode = $renderAs["mode"];
                            }else{
                            $mode = "plain";
                            }
                        } else {
                            $class = "picture_normal";
                            $mode = "form"; // hier muss das noch viewportabh�ngig aus dem datascheme gelesen werden 
                        }



                        echo snippet::filepicture($attr, $src, $class, $mode);
                        break;
                    default:
                        $value = $this->format($attr);
                        echo snippet::textbox($attr, $value);
                }
                break;
            Case "enumeration":
                // $value="HaHa";
                switch ($control) {
                    case "text":
                        $lit = $renderAs["options"]["literal"];
                        $litField = $attr . "_" . $lit;
                        $value = $this->$litField;
                        //   $value = "HaHa";
                        switch ($viewport) {
                            case "detail":
                              //  echo Snippet::text($attr, $value, $control, "false", "true");
                                echo controls::text($value, $mode, $attr, $disabled);
                                break;
                             case "list":
                              //  echo Snippet::text($attr, $value, $control, "false", "true");
                                echo controls::text($value, "table", $attr, $disabled);
                                break;
                            default:
                               // echo Snippet::text($value, "html", $attr);
                               echo controls::text($value, $mode, $attr, $disabled);
                  //              echo snippet::text($value, $mode, $attr, $renderAs["disabled"]);
                        }

                        //include("includes/getSnippet/$control.php");
                        break;
                    case "menu":
                        $lit = $renderAs["options"]["literal"];
                        $varname = $renderAs["options"]["data"];
                        $required = $renderAs["required"];
                          $readonly = $renderAs["readonly"];
                            $disabled = $renderAs["disabled"];
                        // $arrayobj=Core::import($varname);
                        $arrayobj = Core::import($attr);
                        $litField = $attr . "_" . $lit;
                        $output = Snippet::selectmenu($arrayobj, ["default" => $value, "name" => $attr, "required" => $required,"readonly" => $readonly,"disabled" => $disabled]); //Bindung an Element
                        echo $output;
                        //   include("includes/getSnippet/$control.php");
                        break;

                    default:
                }

                // Ggf. Gruppierungsende
                if ($attr == "person_geburtsdatum") {
                    echo snippet::group($attr, "out");
                }


                break;

            Case "relation":
                // $value="HaHa";
                switch ($control) {
                    case "text":
                        //   $ident=$scheme["identifier"];
                        $identField = $attr . "_identifier";
                        $value = $this->$identField;
                        //   $value = "HaHa";
                        switch ($viewport) {
                            case "detail":

                            //    echo Snippet::textbox($attr, $value, "plaintext", "false", "true");  
                            //break;
                            case "edit":
                                echo Snippet::text($value, "form", $attr);
                                break;
                            default:
                                echo Snippet::text($value, "html", $attr);
                   //             echo snippet::text($value, $mode, $attr, $renderAs["disabled"]);
                        }

                        //include("includes/getSnippet/$control.php");
                        break;
                    case "hidden":    
                        $value = $this->$attr;
                        echo Snippet::hidden($attr, $value);
                        break;
                       case "textbox":
                        $value = $this->format($attr, $viewport);
                        echo snippet::textBox($attr, $value, $renderAs["class"], $renderAs["disabled"], $renderAs["readonly"], $renderAs["format"], $renderAs["placeholder"]);                       
                        break;
                    case "menu":
                        if (!isset($scheme["identifier"])) {
                            $ident = "identifier";
                        } elseif ($scheme["identifier"] == "") {
                            $ident = "identifier";
                        } else {

                            $ident = $scheme["identifier"]; // GEHT NUR SO, DA NICHT bekannt ist, f�r welche Klasse das Element agiert.
                            // Vollqualifiziereten Namen entfernen
                            $ident = str_ireplace($scheme["class"] . ".", "", $ident);
                        }

                        if (isset($scheme["renderAs"][$viewport]["identifier"])) {
                            if ($scheme["renderAs"][$viewport]["identifier"] != "") {
                                $ident = $scheme["renderAs"][$viewport]["identifier"];
                                $ident = str_ireplace($scheme["class"] . ".", "", $ident);
                            }
                        }



                        $varname = $renderAs["options"]["data"];
                        $value = $this->$attr;
                        $ownClass = $scheme['class'];

                        // $arrayobj=Core::import($varname);
                        $arrayobj = Core::import($attr);
                         $readonly = $renderAs["readonly"];
                         $disabled = $renderAs["disabled"];
                         $class = $renderAs['class'];
                         $task = $ownClass."_new";
                         $combo = "true";
                        $output = Snippet::selectmenu($arrayobj, ["default" => $value,"class" => $class, "name" => $attr, "text" => $ident,"readonly" => $readonly,"disabled" => $disabled, "combo" => $combo, "task" => $task]); //Bindung an Element
                        echo $output;
                        //   include("includes/getSnippet/$control.php");
                        break;

                    default:
                }

                // Ggf. Gruppierungsende
                if ($attr == "person_geburtsdatum") {
                    echo snippet::group($attr, "out");
                }


                break;



            Case "structure":

                switch ($control) {
                    case "text":
                        break;
                    case "fileupload":
                        echo snippet::fileupload($attr, $value, "", $renderAs["disabled"]);
                        break;
                }
                break;
            default:
        }

        if (isset($scheme['groupOut'])) {
            if ($scheme['groupOut'] === true || $scheme['groupOut'] === 'true') {
                if (isset($scheme['sysParent'])) {
                    $parent = $scheme['sysParent'];
                    if (isset(static::$dataScheme[$parent]["group"])) {
                        if (static::$dataScheme[$parent]["group"] === true || static::$dataScheme[$parent]["group"] === "true") {
                            echo snippet::group($attr, "out");
                        }
                    }
                }
            }
        }


        /*

          if(isset($scheme['groupOut'])){
          if($scheme['groupOut']===true || $scheme['groupOut']==='true'){
          echo snippet::group($attr,"out");
          }
          }
         */
    }

    public static function loadSettings($class, $stereotyp = "class") {
        $klasse = lcfirst($class);
        $class= ucfirst($class);
        $settingsGeneral = json_decode(file_get_contents("includes/json/class_settings.json"), true);
        help::array_replace_valueRecursive("@class", $class, $settingsGeneral);

        if ($settingsGeneral["identifier"] == "") {
            $dataScheme = $klasse::$dataScheme;
            $ident = "id";
            foreach ($dataScheme as $key => $att) {
                if ($key != "id" && $key != "c_ts" && $key != "m_ts" && $key != "created_id" && $key != "owner_id" && $key != "modified_id" && $key != "identifier" && $dataScheme[$key]['stereotype'] != "structure" && $dataScheme[$key]['type'] != "foreign" && !isset($dataScheme[$key]['derived'])) {
                    $ident = $key;
                    break;
                }
            }
            if ($dataScheme[$key]['stereotype'] == "enumeration"){
/*                if (isset($dataScheme[$key]['classAlias'])){
                    $settingsGeneral["identifier"] = $dataScheme[$key]['classAlias'] . "." . "literal";
                }else{
                    $settingsGeneral["identifier"] = $klasse . "." . $ident;
                }*/
                $settingsGeneral["identifier"] = $class . "." . $ident;
            }else {
                $settingsGeneral["identifier"] = $class . "." . $ident;
            }
        }

        if (is_file("models/json/" . $class . "_settings.json")) {
            $settings = json_decode(file_get_contents("models/json/" . $class . "_settings.json"), true);
            help::array_replace_valueRecursive("@class", ucfirst($class), $settings);
            $newSettings = self::array_cascade([$settingsGeneral, $settings]);
        } else {
            $newSettings = $settingsGeneral;
        }

        return $newSettings;
    }

    public function buildScheme($class, $stereotyp = "class") {

        $klasse = lcfirst($class);
        if ($stereotyp == "class") {
            $dataSchemeGeneral = json_decode(file_get_contents("includes/json/class.json"), true);
        } else {
            $dataSchemeGeneral = array();
        }
        $dataSchemeAttribute = json_decode(file_get_contents("includes/json/attribute.json"), true);
        $dataSchemeAccess = json_decode(file_get_contents("includes/json/access.json"), true);
        $dataSchemeDerived = json_decode(file_get_contents("includes/json/derived.json"), true);
        $dataSchemeString = json_decode(file_get_contents("includes/json/string.json"), true);
        $dataSchemeEnumVal = json_decode(file_get_contents("includes/json/enumerationval.json"), true);
        $dataSchemeInteger = json_decode(file_get_contents("includes/json/integer.json"), true);
        $dataSchemeFloat = json_decode(file_get_contents("includes/json/float.json"), true);
        $dataSchemeCurrency = json_decode(file_get_contents("includes/json/currency.json"), true);
        $dataSchemeDate = json_decode(file_get_contents("includes/json/date.json"), true);
        $dataSchemeDateTime = json_decode(file_get_contents("includes/json/datetime.json"), true);
        $dataSchemeTimeStamp = json_decode(file_get_contents("includes/json/timestamp.json"), true);
        $dataSchemeTime = json_decode(file_get_contents("includes/json/time.json"), true);
        $dataSchemeFile = json_decode(file_get_contents("includes/json/file.json"), true);
        $dataSchemePicture = json_decode(file_get_contents("includes/json/picture.json"), true);
        $dataSchemeForeign = json_decode(file_get_contents("includes/json/foreign.json"), true);
        $dataSchemeRelationVal = json_decode(file_get_contents("includes/json/relationval.json"), true);

        $dataSchemeConcrete = json_decode(file_get_contents("models/json/$class.json"), true);
        // Step 1 Grundklasse Aufpassen

        $newScheme = $dataSchemeGeneral;

        if (class_exists($class)) {
            if ($class::$access == true) {
                $newScheme = self::array_cascade([$newScheme, $dataSchemeAccess]);
            }
        }

        // Step 2 Konkretes DataScheme hinzuf�gen, ma�geblich um alle Attribute zu handeln, �berschreibt ggf. default-Werte Step 1

        $newScheme2 = self::array_cascade([$newScheme, $dataSchemeConcrete]);

        // Step 3 Jedes Attribut durchgehen und Anhand des Datentyps zugeh�riges DefaultScheme laden

        foreach ($newScheme2 as $fieldname => $attribut) {
            // Vorbelegung
            $vorlage = $dataSchemeAttribute;
            $vorlage["label"] = ucfirst($fieldname);
            if (isset($attribut['derived'])===true) { // wenn abgeleitet => readonly
                $vorlage = db::array_cascade([$vorlage, $dataSchemeDerived]);
                //   help::array_replace_valueRecursive("@class", ucfirst($class), $vorlage);
            }

            // ge�ndert Nippa
            //   $attribut = db::array_cascade([$vorlage, $attribut]); // 
            if (!is_array($attribut)) {
                $aa = 22;
            }
            if (!isset($attribut["stereotype"])) {
                $attribut["stereotype"] = "primitive";
            }

            switch ($attribut["stereotype"]) {
                case "structure":

                    $structure = db::buildScheme($attribut["type"], "structure");
                    //   $first=true;
                    foreach ($structure as $structKey => $structAtt) {
                        $newFieldname = $fieldname . "_" . $structKey;
                        // Korektur Variable muss hier erfolgen alle Data-werte mit @attribute mit $newFieldname ersetzen. Structures wurden dort bewusst ignoriert.
                        if ($structAtt["stereotype"] == "enumeration") {
                            help::array_replace_valueRecursive("@attribute", $newFieldname, $structAtt);
                        } else {
                            help::array_replace_valueRecursive("@parent", ucfirst($fieldname), $structAtt);
                        }
                            if (isset($structAtt['derived'])===true) { // wenn abgeleitet => readonly
                                   $structAtt = db::array_cascade([$structAtt, $dataSchemeDerived]);
                                 
                //   help::array_replace_valueRecursive("@class", ucfirst($class), $vorlage);
            }
                        $newScheme2[$newFieldname] = $structAtt;
                        $newScheme2[$newFieldname]["sysParent"] = $fieldname;
                    }
                    // Expirimentell fr Struktures
                    $newScheme2[$fieldname]["label"] = $vorlage["label"];

                    // Verarbeitung spezieller Strukturen




                    break;
                case "enumeration":
                    $newFieldname = $fieldname . "_literal";
                    $lit = self::array_cascade([$dataSchemeAttribute, $dataSchemeString]);
                    $newScheme2[$newFieldname] = $lit;
                    $newScheme2[$fieldname] = self::array_cascade([$newScheme2[$fieldname], $dataSchemeEnumVal]);
                    $newScheme2[$fieldname] = self::array_cascade([$newScheme2[$fieldname], $dataSchemeConcrete[$fieldname]]);
                    if ($stereotyp == "class") { // keine Struktur
                        help::array_replace_valueRecursive("@attribute", $fieldname, $newScheme2[$fieldname]); // Ersetzt alle @attribute durch den konkreten Attributnamen
                    }

                    break;
                case "relation":
                    $newFieldname = $fieldname . "_identifier";
                    $newScheme2[$newFieldname] = self::array_cascade([$dataSchemeAttribute, $dataSchemeString]);

                    //   $newScheme2[$newFieldname] = $ident;
                    $newScheme2[$fieldname] = self::array_cascade([$newScheme2[$fieldname], $dataSchemeForeign]);
                    $newScheme2[$fieldname] = self::array_cascade([$newScheme2[$fieldname], $dataSchemeRelationVal]);
                    $newScheme2[$fieldname] = self::array_cascade([$newScheme2[$fieldname], $dataSchemeConcrete[$fieldname]]);
                    if (!isset($newScheme2[$fieldname]["label"])) {
                        $newScheme2[$fieldname]["label"] = "->" . substr($fieldname, 1);
                        $newScheme2[$newFieldname]["label"] = "->" . substr($fieldname, 1);
                    } elseif ($newScheme2[$fieldname]["label"] == "") {
                        $newScheme2[$fieldname]["label"] = "->" . substr($fieldname, 1);
                        $newScheme2[$newFieldname]["label"] = "->" . substr($fieldname, 1);
                    } 
                    help::array_replace_valueRecursive("@attribute", $fieldname, $newScheme2[$fieldname]); // Ersetzt alle @attribute durch den konkreten Attributnamen
                    help::array_replace_valueRecursive("@class", $klasse, $newScheme2[$newFieldname]); // Erset

                    break;
                default:

                    Switch ($attribut["type"]) {

                        Case "string":
                            $vorlage2 = self::array_cascade([$vorlage, $dataSchemeString]);
                            $newScheme2[$fieldname] = self::array_cascade([$vorlage2, $attribut]);

                            break;
                        Case "foreign":
                            $vorlage2 = self::array_cascade([$vorlage, $dataSchemeForeign]);
                            $newScheme2[$fieldname] = self::array_cascade([$vorlage2, $attribut]);

                            break;
                        Case "integer":
                            $vorlage2 = self::array_cascade([$vorlage, $dataSchemeInteger]);
                            $newScheme2[$fieldname] = self::array_cascade([$vorlage2, $attribut]);
                            break;
                        Case "float":
                            $vorlage2 = self::array_cascade([$vorlage, $dataSchemeFloat]);
                            $newScheme2[$fieldname] = self::array_cascade([$vorlage2, $attribut]);
                            break;
                        Case "currency":
                            $vorlage2 = self::array_cascade([$vorlage, $dataSchemeCurrency]);
                            $newScheme2[$fieldname] = self::array_cascade([$vorlage2, $attribut]);
                            break;
                        Case "timestamp":
                            $vorlage2 = self::array_cascade([$vorlage, $dataSchemeTimeStamp]);
                            $newScheme2[$fieldname] = self::array_cascade([$vorlage2, $attribut]);
                            break;
                        Case "date":
                            $vorlage2 = self::array_cascade([$vorlage, $dataSchemeDate]);
                            $newScheme2[$fieldname] = self::array_cascade([$vorlage2, $attribut]);
                            break;
                        Case "datetime":
                            $vorlage2 = self::array_cascade([$vorlage, $dataSchemeDateTime]);
                            $newScheme2[$fieldname] = self::array_cascade([$vorlage2, $attribut]);
                            break;
                        Case "time":
                            $vorlage2 = self::array_cascade([$vorlage, $dataSchemeTime]);
                            $newScheme2[$fieldname] = self::array_cascade([$vorlage2, $attribut]);
                            break;
                        Case "picture":
                            $vorlage2 = self::array_cascade([$vorlage, $dataSchemePicture]);
                            $newScheme2[$fieldname] = self::array_cascade([$vorlage2, $attribut]);
                            self::$enctype = "multipart/form-data";
                            break;


                        Case "file":
                            $vorlage2 = self::array_cascade([$vorlage, $dataSchemeFile]);
                            $newScheme2[$fieldname] = self::array_cascade([$vorlage2, $attribut]);
                            self::$enctype = "multipart/form-data";
                            break;
                        /* zun�chst nicht notwendig
                          Case "layout":
                          $vorlage2 = self::array_cascade([$vorlage, $dataSchemeTime]);
                          $newScheme2[$fieldname] = self::array_cascade([$vorlage2, $attribut]);
                         */
                        Case "primary":
                            break;
                        Case "foreign":
                            break;
                        default: // z.B. Strukturen
                    }
            }
        }

        return $newScheme2;
    }

    public static function array_cascade($arrays) {
        $result = array();

        foreach ($arrays as $array) {
            if (!is_array($array)) {
                $test = 1;
            }
            foreach ($array as $key => $value) {
                // Renumber integer keys as array_merge_recursive() does. Note that PHP
                // automatically converts array keys that are integer strings (e.g., '1')
                // to integers.
                if (is_integer($key)) {
                    $result[] = $value;
                } elseif (isset($result[$key]) && is_array($result[$key]) && is_array($value)) {
                    $result[$key] = self::array_cascade(array(
                                $result[$key],
                                $value,
                    ));
                } else {
                    $result[$key] = $value;
                }
            }
        }
        return $result;
    }

    public static function renderScript($viewport, $form_name = "") {
        $classname = static::class;
        if ($form_name == "") {
            $form_name = "form_" . $classname . "_" . $viewport;
        }

        //  $txt .= '$("#' . strtolower($form_name) . '").validate({' . PHP_EOL;
        $txt .= '$("#' . $form_name . '").validate({' . PHP_EOL;
        $txt .= 'rules: {' . PHP_EOL;
        foreach (static::$dataScheme as $att => $value) {
            $txt .= "\t$att: {" . PHP_EOL;
            $renderAs = $value["renderAs"][$viewport];
            // Generelle Felder:
            if (isset($value["validation"])) {
                switch ($value["validation"]) {
                    case "float":
                        $txt .= "\t\tfloat: true," . PHP_EOL;
                        break;
                    case "string":
                        $txt .= "\t\tstring: true," . PHP_EOL;
                        break;

                    case "integer":
                        $txt .= "\t\tinteger: true," . PHP_EOL;
                        break;
                    case "currency":
                        $txt .= "\t\tcurrency: true," . PHP_EOL;
                        break;
                    case "email":
                        $txt .= "\t\temail: true," . PHP_EOL;
                        break;
                    case "PLZ":
                        $txt .= "\t\tPLZ: true," . PHP_EOL;
                        break;
                    case "URL":
                        $txt .= "\t\url: true," . PHP_EOL;
                        break;
                    default:
                        $txt .= "\t\tregex: '" . $value["validation"] . "'," . PHP_EOL;
                }
            }
            // *********** REQUIRED *********

            if (isset($renderAs["required"])) {
                if ($renderAs["required"] === "true" || $renderAs["required"] === true) {
                    $txt .= "\t\trequired: true," . PHP_EOL;
                }
            }
            // ********* Typpr�fung **********
            if ($value["type"] == "integer") {
                $txt .= "\t\tdigits: true," . PHP_EOL;
            }
            if ($value["type"] == "float") {
                $txt .= "\t\tfloat: true," . PHP_EOL;
            }
            // ******** Zeichenl�nge MIN ********* 
            if (isset($renderAs["minlength"])) {
                $txt .= "\t\tminlength: " . $renderAs["minlength"] . "," . PHP_EOL;
            }
            // ******** Zeichenl�nge MAX ********* 
            if (isset($renderAs["maxlength"])) {
                $txt .= "\t\tmaxlength: " . $renderAs["maxlength"] . "," . PHP_EOL;
            }
            // ********  MIN ********* 
            if (isset($renderAs["min"])) {
                $txt .= "\t\tmin: " . $renderAs["min"] . "," . PHP_EOL;
            }
            // ******** MAX ********* 
            if (isset($renderAs["max"])) {
                $txt .= "\t\tmax: " . $renderAs["max"] . "," . PHP_EOL;
            }
            // REGEX 
            if (isset($renderAs["regex"])) {
                $txt .= "\t\tregex: " . $renderAs["regex"] . "," . PHP_EOL;
            }

            $txt = help::stripLast($txt);
            $txt .= "\t}," . PHP_EOL;
        }
        $txt = help::stripLast($txt);
        $txt .= '}' . PHP_EOL;

        $txt .= '});' . PHP_EOL;

        $path = "models/js/" . strtolower($classname) . "_" . $viewport . ".js";
        $file = fopen($path, "w");
        fwrite($file, $txt);
        fclose($file);
        Core::loadJavascript($path);
    }

}
