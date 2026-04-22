<?php

use backend\models\BaseTipoCliente;
use backend\models\Categoria;
use backend\models\CategoriaCliente;
use backend\models\GeoEstado;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ClienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cliente-index">

<div class="row">
        <div class="col-md-11">
            <?= Html::a('<span class="fa fa-list"></span><b> Todos los Registros</b>', ['index'], ['class' => 'btn btn-primary']); ?>
            <!-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default2"><span class="fa fa-search-plus"></span>&nbsp; <b>Buscar</b>
            </button>-->
        </div>
        <div class="col-md-1">
            <p>
                <?= Html::a('Nuevo', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="box box-purple">

            <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id_cliente',
            [
                'attribute' => 'id_tipo_cliente',
                'contentOptions' => [ 'style' => 'width: 10%;' ],
                'value' => function ($model) {
                    $tipo_cliente = BaseTipoCliente::find()->where(['id' => $model->id_tipo_cliente])->one();
                    if ($tipo_cliente) {
                        return $tipo_cliente->nombre_tipo_cliente;
                    } else {
                        return 'No Asociada';
                    }
                },

                'filter' => Select2::widget([
                    'data' => ArrayHelper::map(BaseTipoCliente::find()->all(), 'id', 'nombre_tipo_cliente'),
                    'model' => $searchModel,
                    'attribute' => 'id_tipo_cliente',
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
                'attribute' => 'cedula',
                'contentOptions' => ['style' => 'width:10px;'],
                'value' => function ($model) {
                    if ($model->cedula) {
                        return $model->cedula;
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'attribute' => 'nombre_apellido',
                'value' => function ($model) {
                  
                    $callout = 'info';
                    $ms = '';
                    $cadena1 = '';
                    $cadena2 = '';

                    if ($model->nuevo==1) {
                        $ms = 'Nuevo';
                        $callout = 'green';
                        $cadena1='<br> <small class="label bg-' . $callout . '">' . $ms . '</small>';
                    }
                    

                    if ($model->cliente_grato==1) {
                        $ms = 'No Grato';
                        $callout = 'red';
                        $cadena2='<small class="label bg-' . $callout . '">' . $ms . '</small>';
                    }


                    return $model->nombre_apellido . $cadena1 . $cadena2;
                },
             
                'format' => 'html',
            ],
            //'rif',
            //'razon_social',
            [
                'attribute' => 'telefono_principal',
                'contentOptions' => ['style' => 'width:20px;']
            ],
            //'telefono_alterno',
            [
                'attribute' => 'correo',
                'contentOptions' => ['style' => 'width:20px;'],
                'value' => function ($model) {
                    if ($model->correo) {
                        return $model->correo;
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'attribute' => 'id_estado',
                'contentOptions' => [ 'style' => 'width: 20%;' ],
                'value' => function ($model) {
                    $estado = GeoEstado::find()->where(['id' => $model->id_estado])->one();
                    if ($estado) {
                        return $estado->nombre;
                    } else {
                        return '-';
                    }
                },

                'filter' => Select2::widget([
                    'data' => ArrayHelper::map(GeoEstado::find()->all(), 'id', 'nombre'),
                    'model' => $searchModel,
                    'attribute' => 'id_estado',
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
            [
                'attribute' => 'id_categoria',
                'value' => function ($model) {
                    $condicion = CategoriaCliente::find()->where(['id_categoria' => $model->id_categoria])->one();
                    if ($condicion) {
                        return $condicion->nombre_categoria;
                    } else {
                        return 'S/C';
                    }
                },

                'filter' => Select2::widget([
                    'data' => ArrayHelper::map(CategoriaCliente::find()->all(), 'id_categoria', 'nombre_categoria'),
                    'model' => $searchModel,
                    'attribute' => 'id_categoria',
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
            //'id_proyecto',
            //'id_usuario',
            //'fecha_registro',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' =>  '{update} {delete} {view} ',
                'buttons' =>[

                    'update' => function ($url, $model) {
                        $options = [
                            'title' => 'Modificar',
                            'data-method' => 'post',
                        ];

                        return Html::a('<span class="btn btn-warning glyphicon glyphicon-pencil"></span>', [
                            'update',
                            'id' => $model['id_cliente'],
                        ], $options);
                    },
                    'view' => function ($url, $model) {
                        $options = [
                            'title' => 'Ver',
                            'data-method' => 'post',
                        ];

                        return Html::a('<span class="btn btn-success glyphicon glyphicon-eye-open"></span>', [
                            'view',
                            'id' => $model['id_cliente'],
                        ], $options);
                    },
                  
                    'delete' =>function($url, $model)
                    {
                      $options = [
                        'title' => 'Eliminar',
                        'data-confirm' =>   '¿Está seguro que desea eliminar este registro?',
                        'data-method' => 'post',
                      ];
                      return Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', $url.'&pro=0', $options);
                    },
                   
                ],
            ],
        ],
    ]); ?>


</div>
</div>
</div>
