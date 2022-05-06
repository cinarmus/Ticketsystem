<?php
/*  @var $help HelperClass */

/**
 * EnthÃ¤lt alle Kontrollelemente
 * @version 1.0 
 * @author Markus Nippa<markus.nippa@hs-pforzheim.de.com>
 */
class Snippet {
   
   
        public static function textArea($attr,$value,$class="",$disabled="false", $readonly="false"){
            
              if($disabled==="true" || $disabled===true){
            $disabled='disabled="disabled"';
        }else{
            $disabled="";
        }
          if($readonly==="true" || $readonly===true){
            $readonly='readonly="readonly"';
        }else{
            $readonly="";
        }
            
            
            
            
            
        ob_start();
        require("includes/getSnippet/textarea.php");
        return ob_get_clean();
    }
    
    
    public static function text($value,$mode="plain", $attr,$disabled="false"){
        ob_start();
        
        switch($mode){
            case "plain":
                require("includes/getSnippet/text_plain.php");
                break;
            case "html":
                require("includes/getSnippet/text_table.php"); //UMBENENNEN "HTMLT" ZU TABLE!
                break;
            default:
                require("includes/getSnippet/text_form.php");
        }          
        return ob_get_clean();
    }
    
    public static function hidden($attr, $value){
        ob_start();
        require("includes/getSnippet/hidden.php");

            
        return ob_get_clean();
    }
  /**
  * stellt die Datenverbindung zu Beginn her
  * @param String $attr Name und ID des Attributs
  * @param String $value der bereits formatierte Wert
  * @param String $class CSS-Klasse zum Formatieren/Javaskript etc.
  * @param String $disabled Wenn True ist das Feld ausgegraut
  * @param String $readonly Wenn True ist das Feld gesperrt
  * @return String gibt gepufferten HTML-Output als String zurÃ¼ck
  */
    
     public static function group($attr,$tag="in",$label="false"){
         
       
          if($readonly==="true" || $readonly===true){
            $readonly='readonly="readonly"';
        }else{
            $readonly="";
        }
        ob_start();
         if($tag=="in" ){
             require("includes/getSnippet/groupin.php");
         }else{
            require("includes/getSnippet/groupout.php");
         }
        return ob_get_clean();
    }
    
    
    public static function textBox($attr,$value,$class="",$disabled="false", $readonly="false",$format="",$placeholder=""){
         
        if($disabled==="true" || $disabled===true){
            $disabled='disabled="disabled"';
        }else{
            $disabled="";
        }
          if($readonly==="true" || $readonly===true){
            $readonly='readonly="readonly"';
        }else{
            $readonly="";
        }
          if(isset($format) && $format!=""){
              if(in_array($format, Core::$masks)){ //entweder vordefinierte Klasse
                  $class=$class." ".$format;
              }else{                
                         $mask='data-mask="'.$format.'"'; // oder direkt Pattern
                         $placeholder='placeholder="'.$placeholder.'"';

              }
        
        }
        
        
        ob_start();
        require("includes/getSnippet/textbox.php");
        return ob_get_clean();
    }
     public static function currencyField($attr,$value,$class="",$disabled="false", $readonly="false"){
         
        if($disabled==="true" || $disabled===true){
            $disabled='disabled="disabled"';
        }else{
            $disabled="";
        }
          if($readonly==="true" || $readonly===true){
            $readonly='readonly="readonly"';
        }else{
            $readonly="";
        }
        
          
        
        
        ob_start();
        require("includes/getSnippet/currencyfield.php");
        return ob_get_clean();
    }
    
    
    
    
    
    
    
    
     public static function password($attr,$value,$class="",$disabled="false", $readonly="false",$doublecheck=false){
         
        if($disabled==="true" || $disabled===true){
            $disabled='disabled="disabled"';
        }else{
            $disabled="";
        }
          if($readonly==="true" || $readonly===true){
            $readonly='readonly="readonly"';
        }else{
            $readonly="";
        }
        ob_start();
        require("includes/getSnippet/password.php");
        return ob_get_clean();
    }
    
      public static function slider($attr,$value,$class="",$disabled="false", $readonly="false"){
         
        if($disabled==="true" || $disabled===true){
            $disabled='disabled="disabled"';
        }else{
            $disabled="";
        }
          if($readonly==="true" || $readonly===true){
            $readonly='readonly="readonly"';
        }else{
            $readonly="";
        }
        ob_start();
        require("includes/getSnippet/slider.php");
        return ob_get_clean();
    }
    
    
    
     public static function dateField($attr,$value,$class="",$disabled="false", $readonly="false"){
         
        if($disabled==="true" || $disabled===true){
            $disabled='disabled="disabled"';
        }else{
            $disabled="";
        }
          if($readonly==="true" || $readonly===true){
            $readonly='readonly="readonly"';
        }else{
            $readonly="";
        }
        ob_start();
        require("includes/getSnippet/datefield.php");
        return ob_get_clean();
    }
     public static function dateTime($attr,$value,$class="",$disabled="false", $readonly="false"){
         
        if($disabled==="true" || $disabled===true){
            $disabled='disabled="disabled"';
        }else{
            $disabled="";
        }
          if($readonly==="true" || $readonly===true){
            $readonly='readonly="readonly"';
        }else{
            $readonly="";
        }
        ob_start();
        require("includes/getSnippet/dateTime.php");
        return ob_get_clean();
    }
    
    public static function time($attr,$value,$class="",$disabled="false", $readonly="false"){
         
        if($disabled==="true" || $disabled===true){
            $disabled='disabled="disabled"';
        }else{
            $disabled="";
        }
          if($readonly==="true" || $readonly===true){
            $readonly='readonly="readonly"';
        }else{
            $readonly="";
        }
        ob_start();
        require("includes/getSnippet/time.php");
        return ob_get_clean();
    }
  
    public static function flipswitch($attr,$value,$class="",$disabled="false", $readonly="false"){
         
        if($disabled==="true" || $disabled===true){
            $disabled='disabled="disabled"';
        }else{
            $disabled="";
        }
          if($readonly==="true" || $readonly===true){
            $readonly='readonly="readonly"';
        }else{
            $readonly="";
        }
        ob_start();
        require("includes/getSnippet/flipswitch.php");
        return ob_get_clean();
    }
    
     public static function checkbox($attr,$value,$label,$class="",$disabled="false", $readonly="false"){
         
        if($disabled==="true" || $disabled===true){
            $disabled='disabled="disabled"';
        }else{
            $disabled="";
        }
          if($readonly==="true" || $readonly===true){
            $readonly='readonly="readonly"';
        }else{
            $readonly="";
        }
        
        ob_start();
        require("includes/getSnippet/checkbox.php");
        return ob_get_clean();
    }
     public static function picture($attr,$src,$class="",$mode="plain",$options=[]){
      ob_start();
      if($mode=="html"){ echo "<td>";}
      if($mode=="plain"){
          require("includes/getSnippet/picture.php");
      }else{
          require("includes/getSnippet/picture_form.php");
      }
      if($mode=="html"){ echo "</td>";}
        return ob_get_clean();
     }
     public static function nav($label,$mode="",$task="",$dataicon="",$datarole="button",$datatheme="a",$class=""){
            ob_start();
        require("includes/getSnippet/nav.php");
        return ob_get_clean();
     }
     
     
     public static function link($attr,$text,$class="",$mode="plain",$options=[]){
      ob_start();
        require("includes/getSnippet/link.php");
        return ob_get_clean();
     }
     
     
     public static function fileupload($attr,$options=[]){
      ob_start();
        require("includes/getSnippet/fileupload.php");
        return ob_get_clean();
     }
       public static function filepicture($attr,$src,$class="",$mode,$options=[]){
      ob_start();
        require("includes/getSnippet/filepicture.php");
        return ob_get_clean();
     }
     
     
     
     
    public static function selectmenu($objarraylist,$options=[]){
        // Defaultwerte
        $opt = [
            "name" => "select",
            "key" => "id",
            "text" => "literal",
            "default" => "",
            "class" => "",
            "required" => "",
            "disabled" =>"",
            "readonly" =>"",
            "combo" => "",
            "task" => ""
        ];

        foreach ($options as $optkey => $optval) { // ersetzt Default durch manuelle Optionen
            $opt[$optkey] = $optval;
        }
        ob_start();
        if( $opt["readonly"]===true ||$opt["readonly"]==="true" || $opt["readonly"]==1){ // da es kein readonly fÃ¼r HTML-Select gibt
           // hidden field, damit Wert Ã¼bertragen wird.
        $attr=   $opt["name"];
        $value=$opt["default"];
        require("includes/getSnippet/hidden.php");
        
        // Noch Überarbeitungsdürftig
        if(core::$user->Gruppe == 4){
        $opt["name"]= $opt["name"];
        }else{
        $opt["name"]= $opt["name"]."_sysreadonly";
        $opt["disabled"]= "true";
        }
        
        }
        if($opt["combo"] == "true"){
        require("includes/getSnippet/selectmenuCombo.php");    
        }else{
        require("includes/getSnippet/selectmenu.php");
        }
        return ob_get_clean();
    }
}
