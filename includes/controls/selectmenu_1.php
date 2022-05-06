<?php


    $opt=[
            "name"=>"select",
            "key"=>"rno",
            "text"=>"myval",
            "default"=>"",
            "class"=>"",
      
        ];
        
        foreach($options as $optkey => $optval){ // ersetzt Default durch manuelle Optionen
            $opt[$optkey]=$optval;
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