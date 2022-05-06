<?php require("includes/system.main.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=Core::$title?></title>
<link rel="stylesheet" href="css/themes/jquery.mobile.icons.min.css" />
<link href="css/themes/jqm-icon-pack-fa.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.mobile.custom.structure.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/themes/hs.css" />
<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<script src="includes/js/jquery-2.1.3.min.js"></script>
<script src="includes/js/jquery.mobile.custom.min.js"></script>
<script src="includes/js/jquery.validate.min.js"></script>
<script src="includes/js/additional-methods.min.js"></script>
<script src="includes/js/jquery.mask.js"></script>
<script src="includes/js/jquery.maskMoney.min.js"></script>
<script src="includes/js/login-registration-form.js"></script>

<script type="text/javascript">
     $(function () {
 
        jQuery.validator.addMethod("float", function (value, element) {
    return this.optional(element) || /[0-9]+([,\.][0-9]+)?/.test(value);
}, "Bitte gültige Zahl eingeben");

 
        jQuery.validator.addMethod("integer", function (value, element) {
    return this.optional(element) || /[0-9]/.test(value);
}, "Bitte eine Ganzzahl eingeben");
        jQuery.validator.addMethod("string", function (value, element) {
    return this.optional(element) || /[ -~]/.test(value);
}, "Es sind ungültige Zeichen vorhanden");

  jQuery.validator.addMethod("currency", function (value, element) {
    return this.optional(element) || /^-?\d{1,3}(?:\.\d{3})*(?:,\d{0,2})? €/.test(value);
}, "Bitte gültigen Betrag eingeben");
  jQuery.validator.addMethod("email", function (value, element) {
    return this.optional(element) || /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(value);
}, "Bitte gültigen E-Mailadresse eingeben");
  jQuery.validator.addMethod("PLZ", function (value, element) {
    return this.optional(element) || /\b\d{5}\b/.test(value);
}, "Bitte gültigen Postleitzahl eingeben");


  $.validator.addMethod(
            "regex",
            function(value, element, regexp) 
            {
                if (regexp.constructor != RegExp)
                    regexp = new RegExp(regexp);
                else if (regexp.global)
                    regexp.lastIndex = 0;
                return this.optional(element) || regexp.test(value);
            },
            "Die Eingabe ist nicht gültig"
    );
    
 
	 <?php
	 foreach(Core::$javascript as $script ){ 
             if(is_file($script)){
           
                include($script); 
             }else
             {
               core::debug("Javaskriptdatei: ".$script." konnte nicht geladen werden" )  ;
             }
             
         }
         include("includes/js/example_mask.js");
         
           include("includes/js/jquery.validate.messages.js");
	 ?>
            $(".sysinteger" ).change(function() {
                   if (jQuery(this).data('mask') != undefined) {
                jQuery(this).val(jQuery(this).cleanVal());
            }
             });    
      
   
         $("form").submit(function(){  

     $('.currency').each(function( index, element ){ // Ausschalten der Prüfung auf Whrung und entfernen der Maske
          $(this).rules('add', {
        //  float: false ,
          currency: false
            });
        console.log(this);
         var value =$(this).maskMoney('unmasked')[0];
            $(this).val(value);
         });    
 
          if($(this).valid()){
              $(".sysfloat" ).each(function() {
              
                old= $(this).val();
               neu=old.replace(",",".");
               $(this).val(neu);
            
             });
         }
        });
        $(".currency").maskMoney({thousands:'.', decimal:',', allowZero:true, suffix: ' €'});
  
   
});
    
    
    
    
        function ajaxload(task, destination, render=0){
        if(render===0){
            renderContainer=destination;
        }else{
            renderContainer=render;
        }  
        
        $.get( 'index2.php?task='+task+'&view='+destination, function( data ) {
          $( '#'+renderContainer ).html( data ); 
          $('#page1').trigger('create');
})
     }
        function ajaxpost(element, task, destination, render=0,minzeichen=2,empty=false){
          if ($(element).val().length>=minzeichen){
            if(render===0){
               renderContainer=destination;
            }else{
               renderContainer=render;
            }     
            var formdata = $(element).closest('form').serialize();
            $.post('index2.php?task='+task+'&view='+destination, formdata,function(data){                  
                      $( '#'+renderContainer ).html( data ); 
                         $('#page1').trigger('create');
           })
          }
        }
</script>


</head>

<body>

<?php
$chain = $_GET["chain"];
?>
  
<?php if(!isset($chain)){ Menu::showModule("headerMenu"); } ?>

<div id="page1" class="page" data-role="page">

    <?php if(!isset($chain)){ Menu::showModule("panelMenu"); } ?>  
 
  <div data-role="content" class="ui-content">
    
      <?php if(count(Core::$errorMsg)>0) { ?>
      <div id="ErrorMessage" class="errorMessage">
   
    <?php echo(Core::showErrors());?>
   </div>
   <?php } ?>
   <?php if(count(core::$message)>0) { ?>
      <div id="message" class="message">
   
    <?php echo(Core::showMessages());?>
   </div>
   <?php } ?>
       <script type="text/javascript">
        function fadeMessage(){
   $('#message').fadeTo("fast",1);
  $('#message').fadeTo("slow",0);
  // $('#message').fadeOut("slow");
}
setTimeout(fadeMessage, 2500);
    </script>
    <div class="groupwrapper"><?php
Core::$view->render("view_group");
?></div>
    <div id="entry">
    <?php 
  Core::$view->render("view_entry");
    ?>  
    </div>
    <div id="view1">
    <?php 
  Core::$view->render("view1");
    ?>
   </div>
   <div id="view2">
    <?php Core::$view->render("view2");?>
   </div>
    <div id="view3">
    <?php Core::$view->render("view3");?>
   </div>
 
 
  <?php if(core::$debugMode==1){?>
  <div id="debug">

  <?php
  if(Core::$debugPrint==1 ){
     if(count(core::$debug)>0){
      var_dump(core::$debug);    
     }
  }
  
  if(Core::$debugConsole==1 && count(core::$debug)>0){
  ?>
      <script language="javascript">
    <?php foreach(core::$debug as $debugitem){
        ?>      
    console.log(<?=json_encode($debugitem,JSON_UNESCAPED_UNICODE);?>);
          
    <?php } ?></script>
 <?php
  }
  ?>
</div>
    
<?php if(Core::$xdebug == 1){ ?>
<div id="phpErrors">
  <?php 
  foreach($debugarray=xdebug_get_collected_errors() as $info){
   echo($info);
  ?></div>
<?php }} 
  }?>

    
<div data-role="popup" id="popupDetail" class="ui-content" style=" opacity: 0.9; width: auto; height: auto; display:block">
  <p> </p>
</div>
    
</div>

    <div class="versioncontrol">
        Version: <?=Core::$version?>
    </div>
    
    
<?php if(!isset($chain)){ Menu::showModule("footerMenu"); } ?>


<script>

var dropdown = document.getElementsByClassName("dropdown");
var i;
var j;

/* Alle Dropdown Button durchschleifen und bei Click die display toggeln (display:none; -> display:block;) */
for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  var dropdownContent = this.nextElementSibling;
  if (dropdownContent.style.display === "block") {
  dropdownContent.style.display = "none";
  } else {
  dropdownContent.style.display = "block";
  }
});
}
/* SchlieÃŸt alle Dropdown-Menüs sobald irgendwo anders im Screen geklickt wird */
/*    window.onclick = function(event){
        for(j = 0; j < dropdown.length; j++){
              if(!event.target.matches(dropdown[j])){
              var dropdownContent = dropdown[j].nextElementSibling;
              if(dropdownContent.style.display == "block"){
               dropdownContent.style.display = "none";
               }}  
}}
*/

</script>	
<script type="text/javascript">
            $('[data-mask]').each(function() {
    $(this).mask($(this).attr("data-mask"));
});
</script>
</body>

</html>