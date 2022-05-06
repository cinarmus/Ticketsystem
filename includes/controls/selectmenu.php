 <select <?php  if($opt["disabled"]===true || $opt["disabled"]==="true"||  $opt["disabled"]==1){echo 'disabled="disabled"';} ?> name="<?= $opt["name"] ?>" id="<?= $opt["name"] ?>" class="<?= $opt["class"] ?>">
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
        </select>