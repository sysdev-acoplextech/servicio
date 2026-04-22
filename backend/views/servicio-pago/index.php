<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use backend\models\BaseTipoVehiculo;
use backend\models\Estatus;
use backend\models\Cliente;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ServicioPagoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestión de Pagos de Servicios por Proyecto';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="servicio-pago-index">

<div class="row">
    <div class="col-md-11">
        <?= Html::a('<span class="fa fa-list"></span><b> Todos los Registros</b>', ['index'], ['class' => 'btn btn-primary']); ?>

    </div>

</div>
</br>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <div class="row">
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
                             'id_servicio',

                        [
                            'attribute' => 'fecha_registro',
                            'contentOptions' => [ 'style' => 'width: 2%;' ],
                            'value' => function ($model) {
                              $fecha_registro=date_create($model->fecha_registro); 
                              return date_format($fecha_registro, 'd-m-Y');
                            }, 
                            'filter' =>  DatePicker::widget([
                              'model' => $searchModel, 
                              'attribute' => 'fecha_registro',
                              'options' => ['placeholder' => 'Selecione Fecha...'],
                              'pluginOptions' => [
                                'format' => 'dd-mm-yyyy',
                                'autoclose'=>true
                              ]
                            ]),
                            'format' => 'html',
                          ],

                        [
                            'attribute' => 'id_tipo_vehiculo',
                            'contentOptions' => [ 'style' => 'width: 2%;' ],
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
                            'contentOptions' => [ 'style' => 'width: 20%;' ],
                            'value' => function ($model) {
                                $cliente = Cliente::find()->where(['id_cliente' => $model->id_cliente])->one();
                                if ($cliente) {
                                    return $cliente->nombre_apellido;
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
                            ]),
                        ],
                        [
                            'attribute' => 'fecha_servicio',
                            'contentOptions' => [ 'style' => 'width: 2%;' ],
                            'value' => function ($model) {
                              $fecha_servicio=date_create($model->fecha_servicio); 
                              return date_format($fecha_servicio, 'd-m-Y');
                            }, 
                            'filter' =>  DatePicker::widget([
                              'model' => $searchModel, 
                              'attribute' => 'fecha_servicio',
                              'options' => ['placeholder' => 'Selecione Fecha...'],
                              'pluginOptions' => [
                                'format' => 'dd-mm-yyyy',
                                'autoclose'=>true
                              ]
                            ]),
                            'format' => 'html',
                          ],
                       /* [
                            'attribute' => 'km_servicio',
                            'contentOptions' => ['style' => 'width: 10%; text-align: right;'],
                        ],*/
                        [
                            'attribute' => 'monto',
                            'contentOptions' => ['style' => 'width: 10%; text-align: right;'],
                        ],
                        //'id_conductor',
                        //'id_flota',
                        [
                            'attribute' => 'id_estatus',
                            'contentOptions' => [ 'style' => 'width: 2%;' ],
                            'value' => function ($model) {
                                $estatus = Estatus::find()->where(['id' => $model->id_estatus])->one();
                                if ($estatus) {
                                    return $estatus->estatus;
                                } else {
                                    return 'S/E';
                                }
                            },

                            'filter' => Select2::widget([
                                'data' => ArrayHelper::map(Estatus::find()->all(), 'id', 'estatus'),
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
                            'template' =>  '{update} {view} {agendar} {pagar} {imagen}',
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
                                        case 7:
                                            return Html::a('<span class="btn btn-danger glyphicon glyphicon-camera"></span>', $url . '&pro=0', $options);
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
                                        case 4:
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
                                        
                                    }  
                                },

                            ],
                        ],
                    ],
                ]); ?>


            </div>
        </div>
    </div>
</div>