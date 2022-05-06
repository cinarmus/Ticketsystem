<?php
$url = filter_input(INPUT_GET, "task");
$ref = $opt['task'];
?>

<div class="ui-select"> 
<div style="width:90%;display:inline-block;"><select <?php  if($opt["disabled"]===true || $opt["disabled"]==="true"||  $opt["disabled"]==1){echo 'disabled="disabled"';} ?> name="<?= $opt["name"] ?>" id="<?= $opt["name"] ?>" class="<?= $opt["class"] ?>">
        <?php
        $key = $opt["key"];
        $text = $opt["text"];
        $default = $opt["default"];
        if($opt["required"]!==true && $opt["required"]!=="true"){
             ?>
            <option value="">--- Bitte wählen ---</option>
            <?php
        }
        foreach ($objarraylist as $item) {
            if(is_object($item)){ // wenn Object
        ?>
              <option value="<?= $item->$key ?>"
            <?php
            if ($default != "") {
                if ($item->$key == $default) {
                    echo ' selected="selected"';
                }
            }
            ?>><?= $item->$text ?></option>
        <?php
            }else{ // wenn Array
                ?>
              <option value="<?= $item[$key]; ?>"
                     <?php
                if ($default != "") {
                   if ($item[$key] == $default) {
                       echo ' selected="selected"';
                  }
                 }?> "><?= $item[$text]?></option><?php
            }        
                } ?>
</select></div>
    
<div style="width:9%;display:inline-block;"><a class="ui-btn ui-btn-b ui-icon-plus ui-btn-icon-notext ui-corner-all ui-shadow" data-inline="true" data-role="button" data-ajax="false" style="width:100%;height:40.5px;background-color:#484848" href="?task=<?=$ref?>&chain=<?=$url?>" onclick=""></a></div>

</div>   