<?php
$title=Core::import("title");

$menu=Core::import("menu");
$class=Core::import("class");
$menuItems=Core::import("menuItems");
$menuLeadingItems=Core::import("menuLeadingItems");
$image=Core::import("image");

if($menu["heading"] == ""){
    $menu["heading"] = "Willkommen bei ".$title."!";
}
?>


<div class="dashboardwrapper">
<?=$image?>
<div class="hometitle">
  <span class="hometitle-span"><?=$menu["heading"];?></span>
  <hr class="hr-text" data-content="<?=$menu["text"];?>">
</div>

<ol class="articles lI">
<?php
if(array_key_exists(0, $menuLeadingItems)){
  foreach($menuLeadingItems as $key => $item){
    Menu::showMenuItem($item,$key, "dashboardMenu");
  }  
}
?>
</ol>

<ol class="articles fI" style="grid-template-columns:repeat(2,1fr)">    
<?php
if(isset($menuItems)){
  foreach($menuItems as $key => $item){
    Menu::showMenuItem($item,$key, "dashboardMenu");
  }  
}
?>
</ol>
</div>

<?php
$user = new user(); // Für Rendering der Elemente 
?>
<div class="login">
<label class="loginlabel">Login</label>
<form class="Nutzerdaten" method="post" action="?task=home" data-ajax="false" data-role="none">
  <input type="text" id="username" name="username" placeholder="Benutzername">
  <input type="password" id="password" name="password" placeholder="Passwort">
  <button class="button1" type="submit" name="login" id="login" value="1">Login</button>
</form>

<style>
    .loginlabel{
        text-align: center;
        font-family: fantasy;
        color: #495c94;
        font-size: x-large;
    }
    .input{
        display:inline-block;
        width: 100%;
        
    }
    .login{
        width:20%;
        margin-left: 40%;
        margin-right: 40%;
        display:inline-block;
    }
    /* funktioniert nicht, genau wie font size & top margin
    .button1{
        background-color: #495c94;
    }*/
    
    .button1{
        margin-bottom: 4%;
        width:25%;
        border-radius: 50px;
    }
</style>
</div>
