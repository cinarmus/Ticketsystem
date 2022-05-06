<?php // css muss noch aus der style-Anweisung raus

if($mode=="form"){
   
    ?>
    
        <?php if($text!=""){ ?>
      <a style="padding: .4em;"id="<?=$attr?>" href="<?=$text?>" data-ajax="false" target="_blank"><?=$text?></a>
        <?php }else{ ?>
      <div class="ui-input-text formtext" >
            <input><?=$text?></input>
    </div>
        <?php }
        }else{
   $a=2; 
    ?>
   <?php if($text!=""){ ?>
<a href="<?=$text?>" data-ajax="false" target="_blank"><?=$text?></a>
       <?php } ?>
<?php } ?>