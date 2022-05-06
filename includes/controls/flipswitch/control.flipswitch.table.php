<td>
<select <?=$disabled?> <?=$readonly?>  name='<?=$attr?>' id='<?=$attr?>' class="fliptext" data-role='flipswitch' >
       
           <option value='0'>Off</option>
           <option value='1' <?php if($value!=0){echo 'selected="selected"';}?>>On</option>
      
</select>
</td>