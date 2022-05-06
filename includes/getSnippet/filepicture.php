<input <?=$disabled?> <?=$readonly?> type='file' name='<?=$attr?>' id='<?=$attr?>' placeholder='<?=$label?>' value='<?=$value?>' />
<?php
if($src!=""){
?>
<label> </label><div class="ui-input-text formtext"><img  class="<?=$class?>" src="<?=$src?>" alt="<?=$label?>"/></div>
<?php } ?>



