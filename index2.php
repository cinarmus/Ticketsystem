<?php require("includes/system.main.php");

$view=filter_input(INPUT_GET,"view");
  $views= explode("|",$view);
  foreach($views as $renderview){
    Core::$view->render($renderview);
  }
    ?>


 
  <?php if(core::$debugMode==1){
 


  
  if(Core::$debugConsole==1 && count(core::$debug)>0){
  ?>
      <script language="javascript">
    <?php foreach(core::$debug as $debugitem){
        ?>      
    console.log(<?=json_encode($debugitem,JSON_UNESCAPED_UNICODE);?>);
          
    <?php } ?></script>
 <?php
  }
 }
    
