<?php
$PrioritätT = Core::$view->PrioritätT;
$PrioritätT_list = Core::$view->PrioritätT_list;
?>
<a href="?task=PrioritätT&id=<?=$PrioritätT->id?>" data-ajax="false" class="ui-btn ui-icon-back ui-btn-icon-notext ui-corner-all" align="right">No text</a>
<form id="form_PrioritätT" method="post" action="?task=PrioritätT_edit&id=<?=$PrioritätT->id?>" data-ajax="false" enctype="<?=$PrioritätT::$enctype?>">
<div class="ui-field-contain">
<?php
$PrioritätT->renderLabel("id");
$PrioritätT->render("id");
$PrioritätT->renderLabel("c_ts");
$PrioritätT->render("c_ts");
$PrioritätT->renderLabel("m_ts");
$PrioritätT->render("m_ts");
$PrioritätT->renderLabel("literal");
$PrioritätT->render("literal");
?>
<label for="update">speichern:</label><button type="submit" name="update" id="update" value="1" >update</button>
</div>
</form>
