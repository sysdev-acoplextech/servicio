<?php

use backend\models\Cliente;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\BaseTipoVehiculo;
use backend\models\Estatus;
use backend\models\ServicioPago;
use backend\models\TipoRuta;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ServiciosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Servicios';
$this->params['breadcrumbs'][] = $this->title;
?>


<?= $this->render('_indicadores_pagos', [
    'tipo' => 1,
]); ?>
<div class="servicios-index scroll-container">

    <div class="row">
        <div class="col-md-11">
            <?= Html::a('<span class="fa fa-list"></span><b> Todos los Registros</b>', ['index'], ['class' => 'btn btn-primary']); ?>
            <!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default2"><span class="fa fa-search-plus"></span>&nbsp; <b>Buscar</b>
            </button>-->
        </div>
        <div class="col-md-1">
            <p>
                <?= Html::a('Nuevo', ['create-seleccion'], ['class' => 'btn btn-success']) ?>
                <?php //echo Html::a('<button class="btn btn-info"><i class="glyphicon glyphicon-print""></i>  Exportar </button>', ['exportar'], ['title' => 'Exportar']); 
                ?>
            </p>
        </div>

    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

        <div class="box box-purple">

            <div class="box-body">
          
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'rowOptions' => function ($model, $index, $widget, $grid) {

                        $estatus = $model->id_estatus; // current date
                        switch ($model->id_estatus) {
                            case 6:
                                return ['class' => 'warning'];
                                break;

                            case 7:
                                return ['class' => 'success'];
                                break;
                        }
                    },

                    'columns' => [
                        //'id_servicio',
                        ['attribute' => 'id_servicio',
                        'contentOptions' => [ 'style' => 'width: 2%;' ],
                        ],

                        [
                            'attribute' => 'fecha_registro',
                            'contentOptions' => ['style' => 'width: 2%;'],
                            'value' => function ($model) {
                                $fecha_registro = date_create($model->fecha_registro);
                                return date_format($fecha_registro, 'd-m-Y');
                            },
                            'filter' =>  DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'fecha_registro',
                                'options' => ['placeholder' => 'Selecione Fecha...'],
                                'pluginOptions' => [
                                    'format' => 'dd-mm-yyyy',
                                    'autoclose' => true
                                ]
                            ]),
                            'format' => 'html',
                        ],

                        [
                            'attribute' => 'id_tipo_vehiculo',
                            'contentOptions' => ['style' => 'width: 2%;'],
                            'value' => function ($model) {
                                $tipo_vehiculo = BaseTipoVehiculo::find()->where(['id' => $model->id_tipo_vehiculo])->one();
                                if ($tipo_vehiculo) {
                                    return $tipo_vehiculo->nombre_tipo_vehiculo;
                                } else {
                                    return 'No Asociada';
                                }
                            },

                            'filter' => Select2::widget([
                                'data' => ArrayHelper::map(BaseTipoVehiculo::find()->all(), 'id', 'nombre_tipo_vehiculo'),
                                'model' => $searchModel,
                                'attribute' => 'id_tipo_vehiculo',
                                'pluginLoading' => false,
                                'value' => null,
                                //'theme' => Select2::THEME_MATERIAL,
                                'options' => ['placeholder' => 'Seleccione...'],
                                'pluginOptions' => [
                                    'multiple' => false,
                                    'allowClear' => true,
                                ]
                            ]),
                        ],
                        /* [
                            'attribute' => 'id_tipo_ruta',
                            'contentOptions' => [ 'style' => 'width: 5%;' ],
                            'value' => function ($model) {
                                $tipo_ruta = TipoRuta::find()->where(['id' => $model->id_tipo_ruta])->one();
                                if ($tipo_ruta) {
                                    return $tipo_ruta->nombre_ruta;
                                } else {
                                    return 'No Asociada';
                                }
                            },

                            'filter' => Select2::widget([
                                'data' => ArrayHelper::map(TipoRuta::find()->all(), 'id', 'nombre_ruta'),
                                'model' => $searchModel,
                                'attribute' => 'id_tipo_traslado_ruta',
                                'pluginLoading' => false,
                                'value' => null,
                                //'theme' => Select2::THEME_MATERIAL,
                                'options' => ['placeholder' => 'Seleccione...'],
                                'pluginOptions' => [
                                    'multiple' => false,
                                    'allowClear' => true,
                                ]
                            ]),
                        ],*/
                        [
                            'attribute' => 'id_cliente',
                            'contentOptions' => ['style' => 'width: 10%;'],
                            'value' => function ($model) {
                                $cliente = Cliente::find()->where(['id_cliente' => $model->id_cliente])->one();
                                if ($cliente) {
                                    $callout = 'info';
                                    $ms = '';
                                    $cadena1 = '';
                                    $cadena2 = '';

                                    if ($cliente->nuevo==1) {
                                        $ms = 'Nuevo';
                                        $callout = 'green';
                                        $cadena1='<br> <small class="label bg-' . $callout . '">' . $ms . '</small>';
                                    }else{
                                        $ms = 'Habitual';
                                        $callout = 'orange';
                                        $cadena1='<br> <small class="label bg-' . $callout . '">' . $ms . '</small>';
                                    }
                                    
                                    if ($cliente->cliente_grato==1) {
                                        $ms = 'No Grato';
                                        $callout = 'red';
                                        $cadena2='<small class="label bg-' . $callout . '">' . $ms . '</small>';
                                    }

                                return $cliente->nombre_apellido . $cadena1 . $cadena2 ;
                                } else {
                                    return 'No Asociada';
                                }
                                




                            },

                            'filter' => Select2::widget([
                                'data' => ArrayHelper::map(Cliente::find()->all(), 'id_cliente', 'nombre_apellido'),
                                'model' => $searchModel,
                                'attribute' => 'id_cliente',
                                'pluginLoading' => false,
                                'value' => null,
                                //'theme' => Select2::THEME_MATERIAL,
                                'options' => ['placeholder' => 'Seleccione...'],
                                'pluginOptions' => [
                                    'multiple' => false,
                                    'allowClear' => true,
                                ]
                            ]), 'format' => 'html',
                        ],
                        [
                            'attribute' => 'fecha_servicio',
                            'contentOptions' => ['style' => 'width: 2%;'],
                            'value' => function ($model) {
                                $fecha_servicio = date_create($model->fecha_servicio);
                                return date_format($fecha_servicio, 'd-m-Y');
                            },
                            'filter' =>  DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'fecha_servicio',
                                'options' => ['placeholder' => 'Selecione Fecha...'],
                                'pluginOptions' => [
                                    'format' => 'dd-mm-yyyy',
                                    'autoclose' => true
                                ]
                            ]),
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'km_servicio',
                            'contentOptions' => ['style' => 'width: 10%; text-align: right;'],
                        ],
                        [
                            'attribute' => 'monto',
                            'contentOptions' => ['style' => 'width: 10%; text-align: right;'],
                        ],
                        //'id_conductor',
                        //'id_flota',
                        [
                            'attribute' => 'id_estatus',
                            'contentOptions' => ['style' => 'width: 2%;'],
                            'value' => function ($model) {
                                $estatus = Estatus::find()->where(['id' => $model->id_estatus])->one();
                                if ($estatus) {
                                    return $estatus->estatus;
                                } else {
                                    return 'S/E';
                                }
                            },

                            'filter' => Select2::widget([
                                'data' => ArrayHelper::map(Estatus::find()->where(['id' => [4, 5, 6, 7, 8]])->all(), 'id', 'estatus'),
                                'model' => $searchModel,
                                'attribute' => 'id_estatus',
                                'pluginLoading' => false,
                                'value' => null,
                                //'theme' => Select2::THEME_MATERIAL,
                                'options' => ['placeholder' => 'Seleccione...'],
                                'pluginOptions' => [
                                    'multiple' => false,
                                    'allowClear' => true,
                                ]
                            ]),
                        ],
                        //'observacion_inicial',
                        //'id_usuario',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' =>  '{update} {view} {agendar} {pagar} {imagen} {concretado}',
                            'contentOptions' => ['style' => 'width: 20px;'], // Ajusta el ancho aquí
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $options = [
                                        'title' => 'Actualizar',
                                        'data-method' => 'post',
                                    ];

                                    return Html::a('<span class="btn btn-primary glyphicon glyphicon-pencil"></span>', $url . '&pro=0', $options);
                                },

                                'imagen' => function ($url, $model) {
                                    $options = [
                                        'title' => 'Generar información',
                                        'data-method' => 'post',
                                    ];

                                    switch ($model->id_estatus) {
                                        case 9:
                                            return Html::a('<span class="btn btn-success glyphicon glyphicon-camera"></span>', $url . '&pro=0', $options);
                                    }
                                },

                                'view' => function ($url, $model) {
                                    $options = [
                                        'title' => 'Ver',
                                        'data-method' => 'post',
                                    ];

                                    return Html::a('<span class="btn btn-success glyphicon glyphicon-eye-open"></span>', [
                                        'view',
                                        'id' => $model['id_servicio'],
                                    ], $options);
                                },


                                'agendar' => function ($url, $model) {
                                    $options = [
                                        'title' => 'Agendar Servicio',
                                        'data-method' => 'post',
                                    ];

                                    switch ($model->id_estatus) {
                                        case 7:
                                            return Html::a('<span class=" btn btn-warning glyphicon glyphicon-check"></span>', [
                                                'agendar',
                                                'id' => $model['id_servicio'],
                                            ], $options);
                                    }
                                },

                                'pagar' => function ($url, $model) {
                                    $options = [
                                        'title' => 'Pagar Servicio',
                                        'data-method' => 'post',
                                    ];
                                    switch ($model->id_estatus) {
                                        case 5:
                                            return Html::a('<span class=" btn btn-primary glyphicon glyphicon-credit-card"></span>', [
                                                'pagar',
                                                'id' => $model['id_servicio'],
                                            ], $options);
                                            break;
                                        case 7:
                                            return Html::a('<span class=" btn btn-primary glyphicon glyphicon-credit-card"></span>', [
                                                'pagar',
                                                'id' => $model['id_servicio'],
                                            ], $options);
                                            break;
                                        case 6:
                                            return Html::a('<span class=" btn btn-primary glyphicon glyphicon-credit-card"></span>', [
                                                'pagar',
                                                'id' => $model['id_servicio'],
                                            ], $options);
                                            break;
                                    }
                                },

                                'concretado' => function ($url, $model) {
                                    $options = [
                                        'title' => 'Servicio Concretado',
                                        'data-method' => 'post',
                                    ];
                                    $forma_pago = ServicioPago::find()->where(['id_servicio' => $model['id_servicio']])
                                        ->one();
                                        
                                    if ( (empty($forma_pago['id_metodo']) == 4) 
                                    || ( ($model['id_estatus'] == 7))  ){

                                        switch ($model->id_estatus) {
                                            case 4:

                                                return Html::a('<span class=" btn btn-danger glyphicon glyphicon-screenshot"></span>', ['concretar',
                                                'id' => $model['id_servicio'],],  $options,[
                                                    'data' => [
                                                        'confirm' => '¿Estás seguro de que deseas concretar el servicio?',
                                                        'method' => 'post', // Cambia a 'get' si es necesario
                                                    ],
                                                ], $options);


                                            break;
                                            case 7:

                                                return Html::a('<span class=" btn btn-danger glyphicon glyphicon-screenshot"></span>', ['concretar',
                                                'id' => $model['id_servicio'],], $options, [
                                                    'data' => [
                                                        'confirm' => '¿Estás seguro de que deseas concretar el servicio?',
                                                        'method' => 'post', // Cambia a 'get' si es necesario
                                                    ],
                                                ],);


                                            break;
                                        }
                                    }
                                },

                            ],
                        ],
                    ],
                ]); ?>
            
            </div>
        

    </div>
</div>