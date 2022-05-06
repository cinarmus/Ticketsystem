<?php

class Help{
    
  
    
    /**
     * Wandelt Kommazahl ins kaufmännische Format um
     * 
     * Üblicherweis zur Ausgabe in der View
     * @param float $value zu konvertierende Zahl
     * @return String im kaufmännischen Format z.B. 1.234,25 €
     * 
     */
    public static function currency($value)
    {
        return number_format($value,2,",",".")." €";
    }
       /**
     * Wandelt  kaufmännische Format in Kommazahl  mit . für MySQL um
     * 
     * Üblicherweis zur Ausgabe in der View
     * @param String $value Zahl (kaufmännisches Format
     * @return float im MySQL-tauglichen Format 1.234,25 € => 1234.25
     * 
     */
    public static function currencyMySQL($value)
    {
        $temp= str_replace(".","",$value); //entfernt den Tausenderpunkt
        $temp= str_replace(",",".",$temp);
        $temp= filter_var($temp, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION); // konvertiert in Zahl und entfernt ungültige Zeichen, auch €-Zeichen
        return  $temp; // ersetzt deutsches Komma mit Punkt
      }
    
    
     /**
     * Formatiert einen Boolean Wert mit individuellem Text
     * @param Boolean $value Wert der gerendert werden soll
     * @param String $true optional Anzeige für Wahr
     * @param String $false optional Anzeige für Falsch 
     * @return String im Format z.B. 21.12.2018 
     */
    public static function boolText($value,$true="richtig",$false="falsch"){
        if($value){
            return $true;
        }else{
            return $false;
        }
    }
    
    
    
    
    /**
     * Formatiert einen Timestamp in deutsches Datum 
      * 
      * In PHP bekommt man mittels time() den Zeitstempel der aktuellen Systemzeit
      * Formell handelt es sich bei einem Timestamp um einen Long-Wert
     * @param long $ts Timestamp
     * @return String im Format z.B. 21.12.2018 
     */
    public static function toDate($ts){
        return date('d.m.Y',$ts);    
    }
     public static function toDateShort($ts){
        return date('d.m',$ts);    
    }
      /**
     * Formatiert einen Timestamp in deutsches Datum samt Uhrzeit
      * 
      * In PHP bekommt man mittels time() den Zeitstempel der aktuellen Systemzeit
      * Formell handelt es sich bei einem Timestamp um einen Long-Wert
     * @param long $ts Timestamp
     * @return String im Format z.B. 21.12.2018 20:15:37
     */
    public static function toDateTime($ts){
        return date('d.m.Y H:i:s',$ts);    
    }
   
    
     /**
     * Erzeugt eine mit dynamischen Daten gefüllte HTML-Klappbox/Menü (<select>)
      * 
      * Es ist dafür eine Liste(Array) mit Objekten einer Tabelle nötig(z.B: $help->sql_queryList), die über ein entsprechendes model bereitgestellt werden muss.
      * Das Ganze ist  für eine Janus-Enumeration automatisch voreingerstellt, kann aber über Parameter konfiguriert werden. 
      * Standardmäßig wird ein Menü mit dem Namen SELECT erzeugt
      * @param Objectarray $obj Objektarray der Datenbanktabelle/Abfrage
      * @param array $options Standardeinstellungen:
         *  "name"=>"select",<br>
         *  "key"=>"codes",<br>
         *  "text"=>"myval",<br>
         *  "default"=>"",<br>
         *  "class"=>"",<br>
         *  "label"=>"Label" automatically added, if set<br>
 *
     * @return String HTML-Ausgabe, samt Daten
     */	
	public static function htmlSelect($obj,$options=[])    {
        $opt=[
            "name"=>"select",
            "key"=>"rno",
            "text"=>"myval",
            "default"=>"",
            "class"=>"",
            "label"=>""
        ];
        
        foreach($options as $optkey => $optval){ // ersetzt Default durch manuelle Optionen
            $opt[$optkey]=$optval;
        }
        
        if($opt["label"]!=""){ ?>
<label for="<?=$opt["name"]?>"><?=$opt["label"]?>:</label><?php
        }
        ?><select name="<?=$opt["name"]?>" id="<?=$opt["name"]?>" class="<?=$opt["class"]?>">
         <?php
         $key=$opt["key"];
         $text=$opt["text"];
         $default=$opt["default"];
        foreach($obj as $item){
        ?>
  <option value="<?=$item->$key?>"
    <?php
  if($default!=""){
      if($item->$key==$default){
          echo ' selected="selected"';          
      }
  }
  ?>><?=$item->$text?></option>
      <?php } ?>
</select>
        <?php        
    }
	
      /**
     * Erzeugt eine mit dynamischen Daten gefüllte HTML-Klappbox/Menü samt Bild(<select>)
      * 
      * Es ist dafür eine Liste(Array) mit Objekten einer Tabelle nötig(z.B: $help->sql_queryList), die über ein entsprechendes model bereitgestellt werden muss.
      * Das Ganze ist  für eine Janus-Enumeration automatisch voreingerstellt, kann aber über Parameter konfiguriert werden. 
      * Standardmäßig wird ein Menü mit dem Namen SELECT erzeugt
      * @param Objectarray $obj Objektarray der Datenbanktabelle/Abfrage
      * @param array $arr folgende Arrayfelder sind zulässig:<br>
         * "name"=>"select",<br>
         *  "key"=>"codes",<br>
         *  "text"=>"myval",<br>
         *  "default"=>"",<br>
         *  "class"=>"",<br>
         *  "label"=>"Label" automatically added, if set<br>

 *
     * @return String HTML-Ausgabe, samt Daten
     */	
	public static function htmlImageSelect($obj,$arr= [])    {
        $name="select";
        $key="rno";
        $text="myval";
        $default="";
        $class="";
        if(isset($arr['name'])){$name=$arr['name'];}
        if(isset($arr['default'])){$default=$arr['default'];}
        if(isset($arr['key'])){$key=$arr['key'];}
        if(isset($arr['text'])){$text=$arr['text'];}
        if(isset($arr['class'])){$class=$arr['class'];}
        if(isset($arr['label'])){             
        $label=$arr['label'];
        ?> <label for="<?=$name?>"><?=$label?>:</label><?php
        }
        ?><select name="<?=$name?>" id="<?=$name?>" class="<?=$class?>">
         <?php
        foreach($obj as $item){
        ?>
  <option data-image="includes/images/<?=$item->$text?>" value="<?=$item->$key?>"
    <?php
  if($default!=""){
      if($item->$key==$default){
          echo ' selected="selected"';          
      }
  }
  ?>><?=$item->$text?></option>
      <?php } ?>
</select>
        <?php        
    }
 
  /**
 * Sort a multi-domensional array of objects by key value
 * Usage: usort($array, arrSortObjsByKey('VALUE_TO_SORT_BY'));
 * Expects an array of objects. 
 *
 * @param String    $key  The name of the parameter to sort by
 * @param String 	$order the sort order
 * @return A function to compare using usort
 */ 
public static function  arrSortObjsByKey($key, $order = 'DESC') {
	return function($a, $b) use ($key, $order) {
		// Swap order if necessary
		if ($order == 'DESC') {
 	   		list($a, $b) = array($b, $a);
 		} 
 		// Check data type
 		if (is_numeric($a->$key)) {
 			return $a->$key - $b->$key; // compare numeric
 		} else {
 			return strnatcasecmp($a->$key, $b->$key); // compare string
 		}
	};
} 
    
  /**
     * Erzeugt eine mit dynamischen Daten gefüllte HTML-Radioboxgruppe (<select>)
      * 
      * Es ist dafür eine Liste(Array) mit Objekten einer Tabelle nötig(z.B: $help->sql_queryList), die über ein entsprechendes model bereitgestellt werden muss.
      * Das Ganze ist  für eine Janus-Enumeration automatisch voreingerstellt, kann aber über Parameter konfiguriert werden. 
      * Standardmäßig wird ein Menü mit dem Namen <b>radio</b> erzeugt
      * @param Objectarray $obj Objektarray der Datenbanktabelle/Abfrage
      * @param array $options Standardeinstellungen:</br>
         *  "name"=>"radio",<br>
         *  "key"=>"codes",<br>
         *  "text"=>"myval",<br>
         *  "default"=>"",<br>
         *  "class"=>"",<br>
         *  "label"=>"Label",<br>
         *  "type"=>"button" // button, buttonmini, radio, radiomini<br>
     
     * @return String HTML-Ausgabe, samt Daten
     */	  
    
    
 
   public static function htmlRadioGroup( $obj, $options=[]){
        $opt=[
            "name"=>"radio",
            "key"=>"codes",
            "text"=>"myval",
            "default"=>"",
            "class"=>"",
            "label"=>"Label",
            "type"=>"button" // button, buttonmini, radio, radiomini
        ];
        
        foreach($options as $optkey => $optval){ // ersetzt Default durch manuelle Optionen
            $opt[$optkey]=$optval;
        }     
        $key=$opt["key"];    
        $text=$opt["text"];
  
  
       
        ?>

 <fieldset id="<?=$opt["name"]?>fieldset" class="ui-grid-a" data-role="controlgroup" <?php        
           switch($opt["type"]){
               case "button":
                   echo' data-type="horizontal"';
                   break;
               case "buttonmini":
                     echo' data-type="horizontal" data-mini="true"';
                   break;
               case "radio":
                   break;
               case "radiomini":
                    echo' data-mini="true"';
                   break;
               default:
                 echo' data-type="horizontal"';   
           }                    
          ?> >                  
       <legend><?=$opt["label"]?></legend>
         <?php
         $i=0;
      
        foreach($obj as $radio){
        $i++ ;?>
        <input type="radio" name="<?=$opt["name"]?>" id="<?=$opt["name"].$i?>" class="<?=$opt["class"]?>" value="<?=$radio->$key?>" <?php  if($opt["default"]!=""){
        if($radio->$key == $opt["default"]){echo ' checked="checked"';}}
      ?>>
        <label  for="<?=$opt["name"].$i?>"><?=$radio->$text?></label>
       
        <?php  
     
    } ?>
    </fieldset>
    <?php
   }   
    /**
     * Rendert ein HTML-Bild unter Angabe des Pfades (<image>)
      * 
      * Über den zweiten Parameter options[] können typische HTML-Attribute gesetzt werden
      * Standardmäßig wird ein Menü mit dem Namen <b>radio</b> erzeugt
      * @param String $path Pfad zum Bild, oft direkt aus DB-Feld
      * @param Array $options  Typische HTML-Attribute (Größe über css definieren:<br>
      *   $options=[<br> "style"=>"",<br> "class"=>"",<br> "name"=>"",<br> "alt"=>"",<br>];
     
     * @return String gerendertes HTML des Bildes
     */	  
   
   
    public static function htmlImage($path, $options=[]){
       $opt=[
            "style"=>"",
            "class"=>"", 
            "name"=>"",
            "alt"=>""            
        ];
        foreach($options as $optkey => $optval){ // ersetzt Default durch manuelle Optionen
            $opt[$optkey]=$optval;
        } 
        if($opt["name"]==""){
            $id= "img_".uniqid();
        }else{
            $id=$opt["name"];
        }
        
        ?>
        <image id="<?=$id?>" name="<?=$id?>" src="<?=$path?>" class="<?=$opt['class']?>" alt="<?=$opt['alt']?>" style="<?=$opt['style']?>"/>
        <?php
    }
  
   
 public static function stripLast($txt,$character=","){
     if(substr($txt,-3,1)==$character){
         return substr($txt,0,-3).PHP_EOL;
     }else{
           if(substr($txt,-2,1)==$character){
               return substr($txt,0,-2).PHP_EOL;
           }else{
            return $txt;   
           }
         
     }
 }
   
 public static function array_replace_valueRecursive($old,$new,&$array){
    foreach($array as $key => &$value){
        if(is_array($value)){
          self::array_replace_valueRecursive($old,$new,$value);
        }else{
            if($value===$old){
                $value=$new;
                if(is_bool($value)){
                    if($value===false){
                        $value="false";
                    }else{
                        $value="true";
                    }
                }
            }else{
                $value= str_replace($old, $new, $value);
                 if(is_bool($value)){
                    if($value===0){
                        $value="false";
                    }else{
                        $value="true";
                    }
                }
            }
                
        }
        
    }
} 
public static function str_replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        return substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}
  public static function getMax($id){ // nur Für Testzwecke
     return "101";
    }  
}