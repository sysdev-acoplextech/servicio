<?php

use backend\models\BaseMarca;
use backend\models\BaseTipoVehiculo;
use backend\models\CondicionFlota;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FlotaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Control de Flota';

// JS ÚNICO Y REFORZADO PARA EL MODAL
$this->registerJs("
    $(document).off('click', '.showModalButton').on('click', '.showModalButton', function(){
        var modal = $('#modal-flota');
        var url = $(this).attr('value');
        
        if (url) {
            modal.find('#modalContent').html('<div style=\"padding:40px; text-align:center;\"><i class=\"fa fa-spinner fa-spin fa-3x\" style=\"color:#EA4C2D\"></i><br><br>Cargando información...</div>');
            modal.find('#modalContent').load(url);
            modal.modal('show');
        }
    });
");
?>

<style>
    /* --- REGLAS DE DISEÑO DEL MODAL (RECTO Y BORDE BLANCO) --- */
    #modal-flota .modal-content {
        border-radius: 0px !important; /* Completamente recto */
        border: 4px solid #FFFFFF !important; /* Borde blanco grueso */
        background-color: #F8FAFC;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    }
    #modal-flota .modal-header {
        background-color: #1B242D !important;
        border-bottom: none;
        border-radius: 0px !important;
        padding: 20px;
    }
    /* X del modal siempre blanca */
    #modal-flota .close {
        color: #FFFFFF !important;
        opacity: 1 !important;
        text-shadow: none;
        font-size: 30px;
    }

    /* --- ESTILOS GENERALES (BOTONES REDONDEADOS) --- */
    .btn, .ficha-grande, .ficha-flotante {
        border-radius: 15px !important;
    }
    .ficha-flotante {
        transition: transform 0.3s ease, box-shadow 0.3s ease !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05) !important;
    }
    .ficha-flotante:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }
    .table-body input {
        border-radius: 10px !important;
        border: 1px solid #f0f0f0;
    }
</style>

<div class="flota-index" style="padding: 25px; background-color: #F8FAFC; min-height: 100vh;">

    <div class="row" style="margin-bottom: 25px; display: flex; align-items: center;">
        <div class="col-md-6">
            <h1 style="color: #1B242D; font-weight: bold; margin:0;"><?= Html::encode($this->title) ?></h1>
            <p style="color: #64748B; font-size: 11pt;">Gestión operativa de la flota y estatus legal.</p>
        </div>
        <div class="col-md-6 text-right">
            <?= Html::a('<i class="fa fa-refresh"></i>', ['index'], ['class' => 'btn btn-default', 'style' => 'padding:12px 18px; margin-right:5px; border:none; background:#FFF; box-shadow: 0 4px 6px rgba(0,0,0,0.05)']) ?>
            <?= Html::button('<i class="fa fa-plus-circle"></i> NUEVA UNIDAD', [
                'value' => Url::to(['create']),
                'class' => 'showModalButton',
                'style' => 'padding: 15px 25px; font-weight: bold; border: none; background-color: #EA4C2D; color: white; box-shadow: 0 4px 12px rgba(234, 76, 45, 0.2);'
            ]) ?>
            <?= Html::a('<i class="fa fa-file-excel-o"></i> EXPORTAR', ['exportar'], [
                'class' => 'btn',
                'style' => 'background-color: #1B242D; color: white; padding: 15px 20px; font-weight: bold; margin-left:5px;'
            ]) ?>
        </div>
    </div>

    <div class="row" style="margin-bottom: 40px;">
        <div class="col-md-3">
            <div class="ficha-grande ficha-flotante" style="background-color: #1B242D; padding: 25px; color: white;">
                <span style="color: #98C1D9; font-weight: bold; font-size: 9pt;">TOTAL UNIDADES</span>
                <div style="font-size: 28pt; font-weight: bold; margin-top: 10px;"><?= $dataProvider->getTotalCount() ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="ficha-grande ficha-flotante" style="background-color: #10B981; padding: 25px; color: white;">
                <span style="font-weight: bold; font-size: 9pt;">OPERATIVOS</span>
                <div style="font-size: 28pt; font-weight: bold; margin-top: 10px;"><?= \backend\models\Flota::find()->where(['id_condicion' => 1])->count() ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="ficha-grande ficha-flotante" style="background-color: #98C1D9; padding: 25px; color: #1B242D;">
                <span style="font-weight: bold; font-size: 9pt;">TERCERIZADOS</span>
                <div style="font-size: 28pt; font-weight: bold; margin-top: 10px;"><?= \backend\models\Flota::find()->where(['tercerizado' => 1])->count() ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="ficha-grande ficha-flotante" style="background-color: #EA4C2D; padding: 25px; color: white;">
                <span style="font-weight: bold; font-size: 9pt;">RCV VENCIDOS</span>
                <div style="font-size: 28pt; font-weight: bold; margin-top: 10px;"><?= \backend\models\Flota::find()->where(['<', 'fecha_vencimiento_rcv', date('Y-m-d')])->count() ?></div>
            </div>
        </div>
    </div>

    <div class="ficha-grande" style="border: none; overflow: hidden; background: #FFFFFF; box-shadow: 0 15px 40px rgba(0,0,0,0.05); border-radius: 25px !important;">
        <div style="padding: 25px 30px; border-bottom: 1px solid #F1F5F9;">
            <h3 style="margin:0; font-weight: bold; color: #1B242D;">Inventario Vehicular</h3>
        </div>

        <div style="padding: 20px;">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-hover table-body', 'style' => 'border-collapse: separate; border-spacing: 0 10px;'],
                'layout' => "{items}\n<div class='text-center'>{pager}</div>",
                'columns' => [
                    [
                        'attribute' => 'foto1',
                        'label' => '',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $img = $model->foto1 ? $model->foto1 : 'web/img/imagen_vacio.png';
                            return Html::img('/servicio/backend/' . $img, [
                                'style' => 'width: 55px; height: 55px; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.1);'
                            ]);
                        },
                    ],
                    [
                        'attribute' => 'placa',
                        'contentOptions' => ['style' => 'vertical-align: middle; font-weight: bold; color: #1B242D; border:none;'],
                    ],
                    [
                        'attribute' => 'id_condicion',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $cond = CondicionFlota::findOne($model->id_condicion);
                            $color = ($model->id_condicion == 1) ? '#10B981' : '#F59E0B';
                            return "<span style='color:$color; font-weight:bold;'><i class='fa fa-circle'></i> " . ($cond ? $cond->nombre_condicion_flota : 'N/A') . "</span>";
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {foto} {asignacion} {estatus}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::button('<i class="fa fa-pencil"></i>', [
                                    'value' => Url::to(['update', 'id' => $model->id, 'pro' => 0]),
                                    'class' => 'showModalButton',
                                    'style' => 'border-radius: 10px; border: none; background: #F1F5F9; color: #1B242D; padding: 8px 12px; margin-right: 5px;'
                                ]);
                            },
                            'foto' => function ($url, $model) {
                                return Html::button('<i class="fa fa-picture-o"></i>', [
                                    'value' => Url::to(['galeria', 'id' => $model->id]),
                                    'class' => 'showModalButton',
                                    'style' => 'border-radius: 10px; border: none; background: #F1F5F9; color: #98C1D9; padding: 8px 12px;'
                                ]);
                            },
                            'asignacion' => function ($url, $model) {
                                return Html::button('<i class="fa fa-external-link"></i>', [
                                    'value' => Url::to(['asignacion', 'id' => $model->id]),
                                    'class' => 'showModalButton',
                                    'style' => 'border-radius: 10px; border: none; background: #1B242D; color: #FFF; padding: 8px 12px; margin-left:5px;'
                                ]);
                            },
                            'estatus' => function ($url, $model) {
                                return Html::button('<i class="fa fa-heartbeat"></i>', [
                                    'value' => Url::to(['cambiar-estatus', 'id' => $model->id]),
                                    'class' => 'showModalButton',
                                    'title' => 'Cambiar Estatus Operativo',
                                    'style' => 'border-radius: 10px; border: none; background: #F1F5F9; color: #10B981; padding: 8px 12px; margin-left:5px;'
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>



<?php
// MODAL REFORMADO SEGÚN REGLAS: RECTO Y BORDE BLANCO
Modal::begin([
    'id' => 'modal-flota',
    'size' => 'modal-lg',
    'header' => '<h4 style="color: #FFF; margin:0; font-weight: bold; letter-spacing: 1px;">GESTIÓN OPERATIVA DE UNIDAD</h4>',
]);
echo "<div id='modalContent' style='min-height:200px;'></div>";
Modal::end();
?>