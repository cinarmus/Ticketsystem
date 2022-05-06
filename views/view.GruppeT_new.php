<?php
$GruppeT = Core::$view->GruppeT;
$GruppeT_list = Core::$view->GruppeT_list ;
?>
<a href="?task=GruppeT" class="ui-btn ui-icon-back ui-btn-icon-notext ui-corner-all" align="right">No text</a>
<form id="form_GruppeT" method="post" action="?task=GruppeT_new" data-ajax="false" enctype="<?=$GruppeT::$enctype?>">
<div class="ui-field-contain">
<?php
$GruppeT = Core::$view->GruppeT;
$GruppeT->renderLabel("id");
$GruppeT->render("id");
$GruppeT->renderLabel("c_ts");
$GruppeT->render("c_ts");
$GruppeT->renderLabel("m_ts");
$GruppeT->render("m_ts");
$GruppeT->renderLabel("literal");
$GruppeT->render("literal");
?>
<label for="update">speichern:</label><button type="submit" onclick="BezHinweis()" name="update" id="update" value="1" >speichern</button>
</div>
</form>
<script>
</script>
