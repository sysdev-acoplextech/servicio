<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TarifarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tarifarios';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
    .tarifario-index { padding: 20px; background-color: #F8FAFC; min-height: 100vh; }
    
    .card-moderna {
        background: #FFFFFF; 
        border-radius: 25px !important; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.02); 
        border: 1px solid #F1F5F9;
        overflow: hidden;
        padding: 20px;
    }

    .btn-modulo { 
        border-radius: 25px !important; 
        font-weight: bold; 
        text-transform: uppercase; 
        transition: 0.3s;
        padding: 10px 25px;
        border: none;
    }

    /* Personalización del GridView */
    .table { border-collapse: separate; border-spacing: 0 10px; }
    .table thead th { 
        border: none !important; 
        color: #94A3B8; 
        font-size: 8pt; 
        text-transform: uppercase; 
        letter-spacing: 1px;
    }
    .table tbody tr { background: #FFFFFF; box-shadow: 0 2px 5px rgba(0,0,0,0.01); transition: 0.2s; }
    .table tbody tr:hover { background: #F1F5F9 !important; transform: scale(1.002); }
    .table td { border: none !important; vertical-align: middle !important; padding: 15px !important; }
    .table tr td:first-child { border-radius: 15px 0 0 15px; }
    .table tr td:last-child { border-radius: 0 15px 15px 0; }

    /* Buscador del grid */
    .filters input {
        border-radius: 10px !important;
        border: 1px solid #E2E8F0 !important;
        padding: 8px !important;
        font-size: 9pt;
    }
");
?>
<div class="tarifario-index">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <p class="text-muted">Gestión de rutas y costos operativos</p>
        </div>
        <div class="btn-group">
            <?= Html::a('<i class="fa fa-file-pdf-o"></i> PDF GLOBAL', ['export-pdf'], [
                'class' => 'btn btn-info btn-modulo',
                'style' => 'background: #6366F1; margin-right: 10px; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);',
                'target' => '_blank'
            ]) ?>
            <?= Html::a('<i class="fa fa-plus"></i> NUEVO TARIFARIO', ['create'], [
                'class' => 'btn btn-success btn-modulo',
                'style' => 'background: linear-gradient(135deg, #10B981 0%, #059669 100%); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);'
            ]) ?>
        </div>
    </div>

    <div class="card-moderna">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table'],
            'summary' => '<div style="color: #94A3B8; font-size: 8pt; margin-bottom: 10px;">Mostrando {begin} - {end} de {totalCount} tarifarios</div>',
            'columns' => [
                [
                    'attribute' => 'id_tarifario',
                    'label' => 'ID',
                    'headerOptions' => ['style' => 'width: 80px;'],
                    'contentOptions' => ['style' => 'font-weight: bold; color: #6366F1;'],
                ],
                [
                    'attribute' => 'descripcion',
                    'headerOptions' => ['style' => 'letter-spacing: 1px;'],
                    'value' => function ($model) {
                        return Html::tag('span', $model->descripcion, ['style' => 'font-weight: 600; color: #334155; font-size: 10.5pt;']);
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Rutas',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        $count = count($model->detalles);
                        return Html::tag('span', $count, [
                            'class' => 'label',
                            'style' => 'background: #F1F5F9; color: #475569; border-radius: 8px; padding: 5px 10px;'
                        ]);
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Acciones',
                    'headerOptions' => ['class' => 'text-center', 'style' => 'width: 200px;'],
                    'contentOptions' => ['class' => 'text-center'],
                    'template' => '{view} {update} {delete}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<i class="fa fa-eye"></i>', $url, [
                                'class' => 'btn btn-link text-primary',
                                'title' => 'Ver Detalle',
                                'style' => 'font-size: 12pt;'
                            ]);
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<i class="fa fa-pencil"></i>', $url, [
                                'class' => 'btn btn-link text-warning',
                                'title' => 'Editar',
                                'style' => 'font-size: 12pt;'
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<i class="fa fa-trash"></i>', $url, [
                                'class' => 'btn btn-link text-danger',
                                'title' => 'Eliminar',
                                'style' => 'font-size: 12pt;',
                                'data' => [
                                    'confirm' => '¿Está seguro de eliminar este tarifario?',
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