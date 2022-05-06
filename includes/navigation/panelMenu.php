<div data-role="panel" id="menupanel" data-position="<?=$position?>" data-display="<?=$appearance?>" data-theme="<?=$theme?>">

<h3><?=$heading?></h3>
<p><?=$text?></p>

<?php
Menu::showMenu($menu);
?>

</div>