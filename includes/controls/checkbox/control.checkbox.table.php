<td>
 <input type="hidden" value="0" name='<?=$attr?>' />   
    <input <?=$disabled?> <?=$readonly?> type="checkbox"  value="<?=$value?>" <?php if($value!=0){echo 'checked="checked"';}?> class="ui-select <?=$class?>"name='<?=$attr?>'  id='<?=$attr?>' />
</td>