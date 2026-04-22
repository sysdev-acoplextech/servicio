<?php

use backend\models\BaseMarca;
use backend\models\BaseModelo;
use backend\models\BaseTipoVehiculo;
use backend\models\CondicionFlota;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\grid\CheckboxColumn;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\TipoServicioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Flota';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flota-index">

    <div class="row">
        <div class="col-md-10">
            <?= Html::a('<span class="fa fa-list"></span><b> Todos los Registros</b>', ['index'], ['class' => 'btn btn-primary']); ?>
            <!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default2"><span class="fa fa-search-plus"></span>&nbsp; <b>Buscar</b>
            </button>-->
        </div>
        <div class="col-md-2">
            <p>
                <?= Html::a('Nuevo', ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::a('<button class="btn btn-info"><i class="glyphicon glyphicon-print""></i>  Exportar </button>', ['exportar'], ['title' => 'Exportar']); ?>
            </p>
        </div>

    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <div class="row">
        <div class="box box-purple">

            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'rowOptions' => function ($model, $index, $widget, $grid) {

                        $fecha_actual = date("Y-m-d"); // current date

                        if (strtotime($fecha_actual) > strtotime($model->fecha_vencimiento_rcv)) {

                            return ['class' => 'danger'];
                        }

                        $fecha_semana = date("Y-m-d", strtotime($model->fecha_vencimiento_rcv . "- 7 days"));
                        $start_date = strtotime($fecha_semana);
                        $date_to_check = strtotime($model->fecha_vencimiento_rcv);
                        $end_date = strtotime($fecha_actual);

                        if ($date_to_check >= $start_date && $date_to_check <= $end_date) {
                            $ms = 'Se vencerá próximamaente';
                            $callout = 'yellow';
                            return ['class' => 'warning'];
                        }
                    },
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'class' => 'kartik\grid\ExpandRowColumn',
                            'width' => '50px',
                            'expandTitle' => 'Ver Detalles',
                            'collapseTitle' => 'Ocultar',
                            'collapseIcon' => ' <span class="fa fa-minus-square"></span>',
                            'expandIcon' => '<span class="fa fa-plus-square"></span>',
                            'value' => function ($model, $key, $index, $column) {
                              return GridView::ROW_COLLAPSED;
                            },
                            'detail' => function ($model, $key, $index, $column) {
                              return Yii::$app->controller->renderPartial('view', ['model' => $model]);
                            },
                            'headerOptions' => ['class' => 'kartik-sheet-style'] ,
                            'expandOneOnly' => true
                          ],
                     
                  
                        // 'id',
                        [
                            'attribute' => 'foto1',
                            'format' => 'raw',
                            'value' => function ($model) {

                                if ($model->foto1)
                                    $img = $model->foto1;
                                else
                                    $img = 'web/img/imagen_vacio.png';

                                return Html::img('/chgroup/backend/' . $img, ['width' => 50, 'height' => 50]);
                            },
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
                                'attribute' => 'id',
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
                            'attribute' => 'id_marca',
                            'contentOptions' => [ 'style' => 'width: 2%;' ],
                            'value' => function ($model) {
                                $marca = BaseMarca::find()->where(['id' => $model->id_marca])->one();
                                if ($marca) {
                                    return $marca->nombre_marca;
                                } else {
                                    return 'No Asociada';
                                }
                            },

                            'filter' => Select2::widget([
                                'data' => ArrayHelper::map(BaseMarca::find()->all(), 'id', 'nombre_marca'),
                                'model' => $searchModel,
                                'attribute' => 'id_marca',
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
                            'attribute' => 'id_modelo',
                            'value' => function ($model) {
                                $modelo = BaseModelo::find()->where(['id' => $model->id_modelo])->one();
                                if ($modelo) {
                                    return $modelo->nombre_modelo;
                                } else {
                                    return 'No Asociada';
                                }
                            },

                            'filter' => Select2::widget([
                                'data' => ArrayHelper::map(BaseModelo::find()->all(), 'id', 'nombre_modelo'),
                                'model' => $searchModel,
                                'attribute' => 'id',
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
                        'color',
                        [
                            'attribute' => 'id_condicion',
                            'value' => function ($model) {
                                $condicion = CondicionFlota::find()->where(['id' => $model->id_condicion])->one();
                                if ($condicion) {
                                    return $condicion->nombre_condicion_flota;
                                } else {
                                    return 'No Asociada';
                                }
                            },

                            'filter' => Select2::widget([
                                'data' => ArrayHelper::map(CondicionFlota::find()->all(), 'id', 'nombre_condicion_flota'),
                                'model' => $searchModel,
                                'attribute' => 'id',
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
                        'tercerizado:boolean',

                        'placa',
                        //'id_estado',
                        //'id_municipio',
                        //'id_parroquia',
                        'asignado:boolean',
                        //'gerencia',
                        //'nombre_gerente',
                        //'fecha_asignacion',
                        //'fecha_registro',
                        //'id_usuario',
                        [
                            'attribute' => 'fecha_vencimiento_rcv',
                            'value' => function ($model) {

                                $callout = 'info';
                                $ms = '';

                                $fecha_vigencia = date_create($model->fecha_vencimiento_rcv);

                                $fecha_actual = date("Y-m-d"); // current date
                                $fecha_semana = date("Y-m-d", strtotime($model->fecha_vencimiento_rcv . "- 7 days")); // subtract 1 day

                                $fecha_dia = date("Y-m-d", strtotime($model->fecha_vencimiento_rcv . "- 2 days")); // subtract 1 day

                                $fecha_limite = date("Y-m-d", strtotime($model->fecha_vencimiento_rcv . "- 1 days")); // subtract 1 day

                                //Validacion de una semana fecha
                                $date_to_check = strtotime($model->fecha_vencimiento_rcv);
                                $end_date = strtotime($fecha_actual);

                                $start_date = strtotime($fecha_semana);

                                if ($date_to_check >= $start_date && $date_to_check <= $end_date) {
                                    $ms = 'Se vencerá';
                                    $callout = 'yellow';
                                }

                                if (strtotime($fecha_actual) > strtotime($model->fecha_vencimiento_rcv)) {
                                    $ms = 'Vencido RCV';
                                    $callout = 'red';
                                }

                                return date_format($fecha_vigencia, 'd-m-Y') . '<br> <small class="label bg-' . $callout . '">' . $ms . '</small>';
                            },
                            'filter' =>  DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'fecha_vencimiento_rcv',
                                'options' => ['placeholder' => 'Selecione Fecha...'],
                                'pluginOptions' => [
                                    'format' => 'dd-mm-yyyy',
                                    'autoclose' => true
                                ]
                            ]),
                            'format' => 'html',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' =>  '{update} {delete} {foto} {asignacion}',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $options = [
                                        'title' => 'Actualizar',
                                        'data-method' => 'post',
                                    ];
                                    return Html::a('<span class="btn btn-primary glyphicon glyphicon-pencil"></span>', $url . '&pro=0', $options);
                                },

                                'delete' => function ($url, $model) {
                                    $options = [
                                        'title' => 'Eliminar',
                                        'data-confirm' =>   '¿Está seguro que desea eliminar este registro?',
                                        'data-method' => 'post',
                                    ];
                                    return Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', $url . '&pro=0', $options);
                                },

                                'foto' => function ($url, $model) {
                                    $options = [
                                        'title' => 'Galería de la Flota',
                                        'data-method' => 'post',
                                    ];

                                    return Html::a('<span class=" btn btn-info glyphicon glyphicon-picture"></span>', [
                                        'galeria',
                                        'id' => $model['id'],
                                    ], $options);
                                },

                                'asignacion' => function ($url, $model) {
                                    $options = [
                                        'title' => 'Asignación de la Flota',
                                        'data-method' => 'post',
                                    ];

                                    return Html::a('<span class=" btn btn-success glyphicon glyphicon-modal-window"></span>', [
                                        'asignacion',
                                        'id' => $model['id'],
                                    ], $options);
                                },

                            ],
                        ],
                    ],
                ]); ?>


            </div>
        </div>


        <?php
        echo $this->render('_search', ['model' => $searchModel, 'ruta' => 'index']);
        ?>