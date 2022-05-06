<?php
switch($mode){
    case "plain":
       echo $label; 
    default:
     ?>
<a href="?task=<?=$task?>" data-role="<?=$datarole ?>" data-theme="<?=$datatheme ?>" data-icon="<?=$dataicon?>"  class="<?=$class?>" data-ajax="false" ><?=$label?></a>

  
<?php   
}
