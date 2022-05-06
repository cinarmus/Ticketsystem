<?php
$StatusT = Core::$view->StatusT;
$StatusT_list = Core::$view->StatusT_list ;
?>
<a href="?task=StatusT" class="ui-btn ui-icon-back ui-btn-icon-notext ui-corner-all" align="right">No text</a>
<form id="form_StatusT" method="post" action="?task=StatusT_new" data-ajax="false" enctype="<?=$StatusT::$enctype?>">
<div class="ui-field-contain">
<?php
$StatusT = Core::$view->StatusT;
$StatusT->renderLabel("id");
$StatusT->render("id");
$StatusT->renderLabel("c_ts");
$StatusT->render("c_ts");
$StatusT->renderLabel("m_ts");
$StatusT->render("m_ts");
$StatusT->renderLabel("literal");
$StatusT->render("literal");
?>
<label for="update">speichern:</label><button type="submit" onclick="BezHinweis()" name="update" id="update" value="1" >speichern</button>
</div>
</form>
<script>
</script>
