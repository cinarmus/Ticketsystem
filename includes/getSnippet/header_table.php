<?php if(isset($dataPriority)){
    ?>
    <th data-priority='<?=$dataPriority?>'><?=$header?></th>

<?php }else{
    ?>
    <th><?=$header?></th>
<?php
}
?>