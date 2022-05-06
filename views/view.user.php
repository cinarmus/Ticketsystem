<?php $user = Core::import("user");
    /* @var $user user */
      $edit = Core::import("edit")?>

<form id="form_user" method="post" action="" data-ajax="false" enctype="multipart/form-data" data-role="none" autocomplete="off"> 

<?php
$user->render("id"); // wird standardmäßig immer ausgeblendet
if($edit === true){
$user->renderLabel("Kennung");
?> <div style="margin-top: .5em;display: inline-block;"> <?php $user->render("Kennung"); ?> </div> <?php
}else{
$user->render("Kennung");
}
$user->render("Passwort");
$user->render("Gruppe");
$user->render("roleid");
$user->render("c_ts");
$user->render("m_ts");

if($edit === true){?>
<button data-ajax="false" type="submit" name="Update" id="updateButton" value="1" >Update</button>
<?php }else{ ?>
<button data-ajax="false" type="submit" name="registrieren" id="registrieren" value="1" >Registrieren</button>
<?php } ?>

</form>