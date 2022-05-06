<input  <?=$readonly?> type='password' class="<?=$class?>" name='<?=$attr?>' id='<?=$attr?>' value='' <?=$placeholder?>/>
<?php
if($doublecheck){
    $placeholder = substr($placeholder, 0, -1).' Wiederholen"'; ?>
<input  <?=$readonly?> type='password' class="<?=$class?>" name='<?=$attr?>_check' id='<?=$attr?>_check' data-rule-equalTo="#<?=$attr?>" value='' <?=$placeholder?>/>
<?php } ?>
