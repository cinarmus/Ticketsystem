
<div class="ui-input-text formtext">
    
    <?php
if($src!=""){
?>
    
    <img  class="<?=$class?>" src="<?=$src?>" alt="<?=$label?>"/>
<?php }else{ ?>
   <img  style="height:50px" class="<?=$class?>" src="images/placeholder.png" alt="<?=$label?>"/>
<?php }?>
</div>