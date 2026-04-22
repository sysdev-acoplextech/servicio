<?php

use backend\models\DetalleFactura;
use backend\models\Estatus;
use backend\models\Tasadia;
use backend\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\Cliente;

/* @var $this yii\web\View */
/* @var $model backend\models\Servicios */

$this->title = "Resumen de Facturas por Cliente: " . $model->nombre_apellido . " (" . $model->cedula . ")";
$this->params['breadcrumbs'][] = ['label' => 'Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerJsFile('@web/js/solicitudes.js');
?>

<div class="servicios-view">
   

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-10">
            <?= Html::a('<span class="fa fa-list"></span><b> Todos los Registros</b>', ['facturas', 'id_cliente'=>$model->id_cliente], ['class' => 'btn btn-primary']); ?>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default2"><span class="fa fa-search-plus"></span>&nbsp; <b>Buscar</b>
            </button>
        </div>
        
    </div>
    <div class="row">
        <div class="box box-purple">

            <div class="box-body">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'id_detallefactura',
                        'num_factura',
                        [
                            'attribute' => 'fecha_factura',
                            'contentOptions' => ['style' => 'width: 2%;'],
                            'value' => function ($model) {
                                $fecha_registro = date_create($model->fecha_factura);
                                return date_format($fecha_registro, 'd-m-Y');
                            },
                            'filter' =>  DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'fecha_factura',
                                'options' => ['placeholder' => 'Selecione Fecha...'],
                                'pluginOptions' => [
                                    'format' => 'dd-mm-yyyy',
                                    'autoclose' => true
                                ]
                            ]),
                            'format' => 'html',
                        ],
                        /*[
                            'attribute' => 'id_cliente',
                            'contentOptions' => ['style' => 'width: 20%;'],
                            'value' => function ($model) {
                                $cliente = Cliente::find()->where(['id_cliente' => $model->id_cliente])->one();
                                if ($cliente) {
                                    return $cliente->nombre_apellido;
                                } else {
                                    return 'No Asociada';
                                }
                            },

                        ],*/
                        [
                            'attribute' => 'monto_facturado',
                            'format' => ['decimal', 2],
                            'contentOptions' => ['style' => 'width: 10%; text-align: right;'],
                        ],
                        //'id_servicios',
                        //'subtotal',
                        //'iva',
                        [
                            'attribute' => 'tasa_dia',
                            'format' => ['decimal', 2],
                            'contentOptions' => ['style' => 'width: 10%; text-align: right;'],
                        ],
                        //'fecha_emision',
                        [
                            'attribute' => 'monto_bs',
                            'format' => ['decimal', 2],
                            'contentOptions' => ['style' => 'width: 10%; text-align: right;'],
                        ],
                        'observacion',
                        'pagada:boolean',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' =>  '{update} {view} {agendar} {pagar} {imagen}',
                            'contentOptions' => ['style' => 'width: 20px;'], // Ajusta el ancho aquí
                            'buttons' => [
                               
                                'view' => function ($url, $model) {
                                    $options = [
                                        'title' => 'Ver',
                                        'data-method' => 'post',
                                    ];
            
                                    return Html::a('<span class="btn btn-success glyphicon glyphicon-eye-open"></span>', [
                                        'view',
                                        'id' =>  $model['id_detallefactura'],
                                    ], $options);
                                },


                               
                              
                                'pagar' => function ($url, $model) {
                                    $options = [
                                        'title' => 'Reportar Pago de fectura',
                                        'data-method' => 'post',
                                        'data-toggle'=>"modal",
                                        'data-target'=>"#modal-info",
                                    ];
                          
                                            return Html::a('<span class=" btn btn-primary glyphicon glyphicon-credit-card"></span>', [
                                                'pagar',
                                                'id' => $model['id_detallefactura'],
                                               

                                            ], $options);

                                              
                                                                           
                                },

                            ],
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>
<?php
echo $this->render('../detalle-factura/_search', ['model' => $searchModel, 'ruta' => 'facturas']);
?>
<?php
echo $this->render('reportepago', ['model' => $model]); 
?>