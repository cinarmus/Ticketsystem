<?php
$AbteilungT = Core::$view->AbteilungT;
$AbteilungT_list = Core::$view->AbteilungT_list ;
?>
<a href="?task=AbteilungT" class="ui-btn ui-icon-back ui-btn-icon-notext ui-corner-all" align="right">No text</a>
<form id="form_AbteilungT" method="post" action="?task=AbteilungT_new" data-ajax="false" enctype="<?=$AbteilungT::$enctype?>">
<div class="ui-field-contain">
<?php
$AbteilungT = Core::$view->AbteilungT;
$AbteilungT->renderLabel("id");
$AbteilungT->render("id");
$AbteilungT->renderLabel("c_ts");
$AbteilungT->render("c_ts");
$AbteilungT->renderLabel("m_ts");
$AbteilungT->render("m_ts");
$AbteilungT->renderLabel("literal");
$AbteilungT->render("literal");
?>
<label for="update">speichern:</label><button type="submit" onclick="BezHinweis()" name="update" id="update" value="1" >speichern</button>
</div>
</form>
<script>
</script>
