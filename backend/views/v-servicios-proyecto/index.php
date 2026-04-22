<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Cliente;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VServiciosProyectoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestión de pago de Clientes por Proyectos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vservicios-proyecto-index">
<br>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <div class="row">
        <div class="box box-purple">

            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        /*  'id_servicio',
            'fecha_registro',
            'id_tipo_vehiculo',
            'id_tipo_traslado_ruta',*/
                        [
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

                            'filter' => Select2::widget([
                                'data' => ArrayHelper::map(Cliente::find()->where(['id_tipo_cliente' => 2])->all(), 'id_cliente', 'nombre_apellido'),
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
                        'servicios',
                        //'cedula',
                        //'nombre_apellido',
                        //'telefono_principal',
                        //'telefono_alterno',
                        //'correo',
                        //'id_estado',
                        //'id_municipio',
                        //'id_parroquia',
                        //'direccion:ntext',
                        //'empresa',
                        //'id_referido',
                        //'lugar_contacto',
                        //'id_nos_conoce',
                        //'fecha_cumpleanos',
                        //'viaja_frecuente',
                        //'recibir_correo',
                        //'cliente_grato',
                        //'id_categoria',
                        //'id_proyecto',
                        //'nuevo',
                        //'fecha_servicio:ntext',
                        //'km_servicio',
                        //'monto',
                        //'id_conductor',
                        //'id_flota',
                        //'id_estatus',
                        //'observacion_inicial',
                        //'id_usuario',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' =>  '{view} {facturas}  ',
                            'contentOptions' => ['style' => 'width: 20px;'], // Ajusta el ancho aquí
                            'buttons' => [
                         
                                'view' => function ($url, $model) {
                                    $options = [
                                        'title' => 'Generar factura',
                                        'data-method' => 'post',
                                    ];
            
                                    return Html::a('<span class="btn btn-success glyphicon glyphicon-folder-open"></span>', [
                                        'view',
                                        'id' => $model['id_servicio'],
                                    ], $options);
                                },
                              
                                'facturas' => function ($url, $model) {
                                    $options = [
                                        'title' => 'Facturas por cliente',
                                        'data-method' => 'post',
                                    ];
                                        return Html::a('<span class=" btn btn-warning glyphicon glyphicon-th"></span>', [
                                            'facturas',
                                            'id_cliente' => $model['id_cliente'],
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