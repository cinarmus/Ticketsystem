<div class="formcheckbox" >
    
    
<!-- Für korrekte Übergabe, falls Checkbox nicht gedrückt wurde -->    
 <input type="hidden" value="0" name='<?=$attr?>' />   
<input  <?=$disabled?> <?=$readonly?> type="checkbox"  value="<?=$value?>" <?php 
if($value!=0){echo 'checked="checked"';}?> class="  ui-checkbox"name='<?=$attr?>'  id='<?=$attr?>'  data-enhanced="true"/>

</div>

<?php //class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-checkbox-on"