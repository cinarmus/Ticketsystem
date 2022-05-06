<?php
$januar = Core::import("januar");
$februar = Core::import("februar");
$märz = Core::import("märz");
$april = Core::import("april");
$mai = Core::import("mai");
$juni = Core::import("juni");
$juli = Core::import("juli");
$august = Core::import("august");
$september = Core::import("september");
$oktober = Core::import("oktober");
$november = Core::import("november");
$dezember = Core::import("dezember");
$Favoriten=new Favoriten();
$icon=$Favoriten->find_task("visits",$_SESSION['uid']);
if ($icon =="plus"){
    $hover = "hinzufügen";
}else{
    $hover = "entfernen";
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
</head>

<body id="page-top">

<div id="content">
    <div class="container-fluid">
        <div class="row d-xl-flex justify-content-xl-center">
            <div class="col-xl-9">
                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary font-weight-bold m-0">Visits Overview</h6>
                        <div class="tooltip_hs">
                            <a href="?task=favoriten&db_task=visits&icon=<?=$icon?>" data-ajax="false" data-role="button"  class="ui-btn ui-icon-<?=$icon?> ui-btn-icon-notext ui-corner-all ui-btn-inline">show</a>
                            <span style="font-size: 15px" class="tooltiptext">Favorit <?=$hover?></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area"><canvas
                                data-bs-chart="{&quot;type&quot;:&quot;line&quot;,&quot;data&quot;:{&quot;labels&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;,&quot;Jul&quot;,&quot;Aug&quot;,&quot;Sep&quot;,&quot;Okt&quot;,&quot;Nov&quot;,&quot;Dez&quot;],


&quot;datasets&quot;:[{&quot;label&quot;:&quot;Visits&quot;,&quot;fill&quot;:true,&quot;data&quot;:[&quot;<?=$januar?>&quot;,&quot;<?=$februar?>&quot;,&quot;<?=$märz?>&quot;,&quot;<?=$april?>&quot;,&quot;<?=$mai?>&quot;,&quot;<?=$juni?>&quot;,&quot;<?=$juli?>&quot;,&quot;<?=$august?>&quot;,&quot;<?=$september?>&quot;,&quot;<?=$oktober?>&quot;,&quot;<?=$november?>&quot;,&quot;<?=$dezember?>&quot;],


&quot;backgroundColor&quot;:&quot;rgba(78, 115, 223, 0.05)&quot;,&quot;borderColor&quot;:&quot;rgba(78, 115, 223, 1)&quot;}]},&quot;options&quot;:{&quot;maintainAspectRatio&quot;:false,&quot;legend&quot;:{&quot;display&quot;:false},&quot;title&quot;:{},&quot;scales&quot;:{&quot;xAxes&quot;:[{&quot;gridLines&quot;:{&quot;color&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;zeroLineColor&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;drawBorder&quot;:false,&quot;drawTicks&quot;:false,&quot;borderDash&quot;:[&quot;2&quot;],&quot;zeroLineBorderDash&quot;:[&quot;2&quot;],&quot;drawOnChartArea&quot;:false},&quot;ticks&quot;:{&quot;fontColor&quot;:&quot;#858796&quot;,&quot;padding&quot;:20}}],&quot;yAxes&quot;:[{&quot;gridLines&quot;:{&quot;color&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;zeroLineColor&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;drawBorder&quot;:false,&quot;drawTicks&quot;:false,&quot;borderDash&quot;:[&quot;2&quot;],&quot;zeroLineBorderDash&quot;:[&quot;2&quot;]},&quot;ticks&quot;:{&quot;fontColor&quot;:&quot;#858796&quot;,&quot;padding&quot;:20}}]}}}"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/chart.min.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="assets/js/theme.js"></script>
</body>

</html>