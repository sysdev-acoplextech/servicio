<?php

use backend\models\CondicionFlota;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var backend\models\CondicionFlotaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Condiciones de la Flota';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
    .btn-redondo { border-radius: 20px !important; }
    .box-body { font-size: 14px; }
    .table thead th { background-color: #f4f4f4; color: #333; }
    .badge-status { padding: 5px 10px; border-radius: 10px; font-size: 11px; }
");
?>

<div class="condicion-flota-index">

    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-12">
            <?= Html::a('<i class="fa fa-plus"></i><b> Nueva Condición</b>', ['create'], ['class' => 'btn btn-success btn-redondo']); ?>
            <?= Html::a('<i class="fa fa-refresh"></i>', ['index'], ['class' => 'btn btn-default btn-redondo', 'title' => 'Actualizar']); ?>
        </div>
    </div>

    <div class="box box-primary" style="border-radius: 15px;">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-list"></i> Listado de Condiciones</h3>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'summary' => "Mostrando <b>{begin}-{end}</b> de <b>{totalCount}</b> elementos",
                'tableOptions' => ['class' => 'table table-hover table-striped'],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 50px; text-align: center;'],
                    ],

                    // ID oculto o pequeño si es necesario
                    [
                        'attribute' => 'id',
                        'contentOptions' => ['style' => 'width: 80px; text-align: center;'],
                    ],

                    'nombre_condicion_flota',

                    [
                        'attribute' => 'estatus',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $clase = $model->estatus == 1 ? 'label-success' : 'label-danger';
                            $texto = $model->estatus == 1 ? 'ACTIVO' : 'INACTIVO';
                            return "<span class='label $clase badge-status'>$texto</span>";
                        },
                        'filter' => [1 => 'ACTIVO', 0 => 'INACTIVO'],
                        'contentOptions' => ['style' => 'width: 150px; text-align: center;'],
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Acciones',
                        'headerOptions' => ['style' => 'color:#337ab7; text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center; width: 120px;'],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fa fa-eye"></i>', $url, [
                                    'class' => 'btn btn-info btn-xs btn-redondo',
                                    'title' => 'Ver Detalle',
                                    'style' => 'margin-right: 3px; padding: 2px 8px;'
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<i class="fa fa-pencil"></i>', $url, [
                                    'class' => 'btn btn-warning btn-xs btn-redondo',
                                    'title' => 'Editar',
                                    'style' => 'margin-right: 3px; padding: 2px 8px;'
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fa fa-trash"></i>', $url, [
                                    'class' => 'btn btn-danger btn-xs btn-redondo',
                                    'title' => 'Eliminar',
                                    'padding' => '2px 8px;',
                                    'data' => [
                                        'confirm' => '¿Está seguro de que desea eliminar este elemento?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>