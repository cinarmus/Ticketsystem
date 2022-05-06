<?php
if($mode=="html"){
    echo "<td>";
}else{ 
    echo "";
}
?>
<?php
if($src!=""){
?>
<img  class="<?=$class?>" src="<?=$src?>" alt="<?=$label?>"/>
<?php } ?>
<?php
if($mode=="html"){
    echo "</td>";
}else{ 
    echo "";
}
?>
