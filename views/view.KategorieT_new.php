<?php
$KategorieT = Core::$view->KategorieT;
$KategorieT_list = Core::$view->KategorieT_list ;
?>
<a href="?task=KategorieT" class="ui-btn ui-icon-back ui-btn-icon-notext ui-corner-all" align="right">No text</a>
<form id="form_KategorieT" method="post" action="?task=KategorieT_new" data-ajax="false" enctype="<?=$KategorieT::$enctype?>">
<div class="ui-field-contain">
<?php
$KategorieT = Core::$view->KategorieT;
$KategorieT->renderLabel("id");
$KategorieT->render("id");
$KategorieT->renderLabel("c_ts");
$KategorieT->render("c_ts");
$KategorieT->renderLabel("m_ts");
$KategorieT->render("m_ts");
$KategorieT->renderLabel("literal");
$KategorieT->render("literal");
?>
<label for="update">speichern:</label><button type="submit" onclick="BezHinweis()" name="update" id="update" value="1" >speichern</button>
</div>
</form>
<script>
</script>
