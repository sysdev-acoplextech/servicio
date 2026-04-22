<?php

use backend\models\Moneda;
use backend\models\VariablesServicio;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ListaPrecioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lista Precios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lista-precio-index">

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

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <div class="box box-purple">

        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id_lista',
                    [
                        'attribute' => 'id_variable',
                        'contentOptions' => [ 'style' => 'width: 2%;' ],
                        'value' => function ($model) {
                            $tipo_variable = VariablesServicio::find()->where(['id_variable' => $model->id_variable])->one();
                            if ($tipo_variable) {
                                return $tipo_variable->nombre_variable;
                            } else {
                                return 'No Asociada';
                            }
                        },

                        'filter' => Select2::widget([
                            'data' => ArrayHelper::map(VariablesServicio::find()->all(), 'id_variable', 'nombre_variable'),
                            'model' => $searchModel,
                            'attribute' => 'id_variable',
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
                    'monto',
                    [
                        'attribute' => 'id_moneda',
                        'contentOptions' => [ 'style' => 'width: 2%;' ],
                        'value' => function ($model) {
                            $tipo_moneda = Moneda::find()->where(['id_moneda' => $model->id_moneda])->one();
                            if ($tipo_moneda) {
                                return $tipo_moneda->nombre_moneda;
                            } else {
                                return 'No Asociada';
                            }
                        },

                        'filter' => Select2::widget([
                            'data' => ArrayHelper::map(Moneda::find()->where(['idestatus'=>TRUE])->all(), 'id_moneda', 'nombre_moneda'),
                            'model' => $searchModel,
                            'attribute' => 'id_moneda',
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
                        'class' => 'yii\grid\ActionColumn',
                        'template' =>  '{update}',
                        'buttons' => [

                            'update' => function ($url, $model) {
                                $options = [
                                    'title' => 'Modificar',
                                    'data-method' => 'post',
                                ];

                                return Html::a('<span class="btn btn-warning glyphicon glyphicon-pencil"></span>', [
                                    'update',
                                    'id' => $model['id_variable'],
                                ], $options);
                            },

                            'delete' => function ($url, $model) {
                                $options = [
                                    'title' => 'Eliminar',
                                    'data-confirm' =>   '¿Está seguro que desea eliminar este registro?',
                                    'data-method' => 'post',
                                ];
                                return Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', $url . '&pro=0', $options);
                            },

                        ],
                    ],
                ],
            ]); ?>


        </div>
    </div>
</div>