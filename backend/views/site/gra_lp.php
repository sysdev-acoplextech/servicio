<?php
use miloschuman\highcharts\SeriesDataHelper;
use mdm\admin\components\Helper;
use backend\models\Estatus;
use backend\models\ProductosV;
use backend\models\CondicionFinanciera;
use backend\models\TablaCuotasLplazo;
use backend\models\InteresLplazo; 
use miloschuman\highcharts\Highcharts;
$ar='';
    foreach ($model3 as $key => $value)
    {
     $rr=Estatus::find()->where(['id_estatus'=>$value->estatus_cartera])->one();
     if ($key==0) {
      $tt=',"sliced":true,"selected":true';
    }else
    {
      $tt='';
    }
    $ar.='{"name":"'.$rr->descrip_estatus.' ('.$value->id_condicion_financiera.')","y":'.$value->id_condicion_financiera.' '.$tt.'},';
  }
  $ar=substr( $ar, 0,-1) ;


?>
<h3 class="text-center">
       <strong>Estatus de las Solicitudes Largo Plazo</strong>
     </h3>
 
       <?php
       echo Highcharts::widget([
        'scripts' => [
         'highcharts-3d',
       ],
       'options'=>'{
        "colors": [ "#3cff33","#33fff9","#9c33ff","#77b273","#8c3bf4","#ee3bf4","#ff0000","#ff0000"],
        "chart": {
          "plotBackgroundColor": null,
          "plotBorderWidth": null,
          "plotShadow": false,
          "type": "pie",
          "options3d": {
           "enabled": true,
           "alpha": 45,
           "beta": 0
         }
         },
         "title": {
           "text": ""
           },
           "accessibility": {
            "point": {
             "valueSuffix": "%"
           }
           },
           "plotOptions": {
             "pie": {
              "allowPointSelect": true,
              "cursor": "pointer",
              "depth": 50,
              "dataLabels": {
               "enabled": false
               },
               "showInLegend": true
             }
             },
             "series": [{
               "name": "Solicitudes",
               "colorByPoint": true,
               "data": ['.$ar.']
               }]
             }'
           ]);
           ?> 
