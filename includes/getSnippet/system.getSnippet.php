<?php
function getSnippet($attr, $as, $scheme, $value){
    $element=$scheme['renderAs'][$as]['control'];
    $option_enabled=$scheme['renderAs'][$as]['option']['enabled'];
    $label=$scheme['label'];
    
    //für Enumeration
    if($scheme['stereotyp']=='enumeration'){
        $type=$scheme['type'];
        $enumeration=new $type();
        $eintrag_list=$enumeration->findAll();
        
        $test='test';
    }
    
    if($option_enabled==false){
        $disabled='disabled';
    }else{
        $disabled='';
    }
    include"$element.php";
    return $e;
}

