<?php
$PrioritätT_list=Core::$view->PrioritätT_list;
$PrioritätT=Core::$view->PrioritätT;
?>
<div data-role="ui-bar ui-bar-a">
<h1>Übersichtsseite PrioritätT</h1>
</div>
<form>
<input id="filterTable-input" data-type="search">
</form>
<div class="overflowx">
<table data-role="table" id="tbl_PrioritätT" data-filter="true" data-input="#filterTable-input" class="ui-responsive" data-mode="columntoggle" data-column-btn-theme="b" data-column-btn-text="Spalten" data-column-popup-theme="a">
<thead>
<tr>
<?php $PrioritätT->renderHeader("id", "table"); ?>
<?php $PrioritätT->renderHeader("c_ts", "table"); ?>
<?php $PrioritätT->renderHeader("m_ts", "table"); ?>
<?php $PrioritätT->renderHeader("literal", "table"); ?>
</tr>
</thead>
<tbody>
<?php foreach($PrioritätT_list as $enumeration){
?>
<tr>
<?php $enumeration->render("id"); ?>
<?php $enumeration->render("c_ts"); ?>
<?php $enumeration->render("m_ts"); ?>
<?php $enumeration->render("literal"); ?>
<td>
<a href="?task=PrioritätT_edit&id=<?=$enumeration->id?>" data-ajax="false" data-role="button"  class="ui-btn ui-icon-pencil ui-btn-icon-notext ui-corner-all ui-btn-inline">edit</a>
<a href="?task=PrioritätT_delete&id=<?=$enumeration->id?>" data-ajax="false" data-role="button"  class="ui-btn ui-icon-delete ui-btn-icon-notext ui-corner-all ui-btn-inline" onclick="return confirm("Soll der Datensatz mit der ID: <?=$enumeration->id." wirklich gelöscht werden?"?>")">delete</a>
</td>
</tr>
<?php
        }
        ?>
</tbody>
</table>
</div>
<a href="?task=PrioritätT_new" class="ui-btn ui-btn-b ui-icon-plus ui-btn-icon-left" data-ajax="false">Neuanlegen</a><br>
<br>
