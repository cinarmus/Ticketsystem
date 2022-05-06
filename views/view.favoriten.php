<?php
$Favoriten_list=Core::$view->Favoriten_list;
$Favoriten=Core::$view->Favoriten;
$Favoriten = new Favoriten();
?>

<table style="width: 80%; margin-left: auto; margin-right: auto; margin-top:80px" data-role="table" id="tbl_Artikel" data-filter="true" data-input="#filterTable-input" class="ui-responsive">
    <thead>
    <tr>
        <th style="font-size: 20px"><?php $Favoriten->renderHeader("task_label"); ?></th>
        <th style="font-size: 20px">Umbenennen</th>
        <th style="width: 150px;"></th>
    </tr>
    </thead>
    <tbody>

    <?php foreach($Favoriten_list as $klasse){
        ?>
        <tr>
            <?php $klasse->render("task_label"); ?>
            <td >
                <form id="favoriten_edit" method="post" action="?task=favoriten_edit&id=<?=$klasse->id?>" data-ajax="false">
                    <input id="name_edit" name="name_edit" value="" >
                    </input>
            </td>
            <td >
                <button class="ui-btn ui-icon-edit ui-btn-icon-notext ui-corner-all ui-btn-inline" type="submit" name="save" id="update" value="1" >show</button>
                </form>
                <a href="?task=favoriten_delete&id=<?=$klasse->id?>" data-ajax="false" data-role="button"  class="ui-btn ui-icon-delete ui-btn-icon-notext ui-corner-all ui-btn-inline">show</a>
                <a href="?task=<?=$klasse->task?>&id=<?=$klasse->datensatz_id?>" data-ajax="false" data-role="button"  class="ui-btn ui-icon-arrow-r ui-btn-icon-notext ui-corner-all ui-btn-inline">show</a>
            </td>
        </tr>
        <?php
    }
    if(count($Favoriten_list)<1){
        ?> <tr><td colspan="3"><br>Hier ist Platz für Ihre Favoriten, um schneller durch die Anwendung zu navigieren.<br></td></tr> <?php
    }
    ?>
    </tbody>
</table>