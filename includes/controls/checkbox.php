 <fieldset data-role="controlgroup">
    <legend><?=$label?>:</legend>
<input <?=$disabled?> <?=$readonly?> type="checkbox"  value="<?=$value?>" <?php if($value!=0){echo 'checked="checked"';}?> class="ui-select <?=$class?>"name='<?=$attr?>'  id='<?=$attr?>' />
 </fieldset>