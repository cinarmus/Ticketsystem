<?php
$KategorieT = Core::$view->KategorieT;
$KategorieT_list = Core::$view->KategorieT_list;
?>
<a href="?task=KategorieT&id=<?=$KategorieT->id?>" data-ajax="false" class="ui-btn ui-icon-back ui-btn-icon-notext ui-corner-all" align="right">No text</a>
<form id="form_KategorieT" method="post" action="?task=KategorieT_edit&id=<?=$KategorieT->id?>" data-ajax="false" enctype="<?=$KategorieT::$enctype?>">
<div class="ui-field-contain">
<?php
$KategorieT->renderLabel("id");
$KategorieT->render("id");
$KategorieT->renderLabel("c_ts");
$KategorieT->render("c_ts");
$KategorieT->renderLabel("m_ts");
$KategorieT->render("m_ts");
$KategorieT->renderLabel("literal");
$KategorieT->render("literal");
?>
<label for="update">speichern:</label><button type="submit" name="update" id="update" value="1" >update</button>
</div>
</form>
