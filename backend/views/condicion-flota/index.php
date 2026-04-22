<?php

use backend\models\CuentasBancarias;
use backend\models\CategoriaGastos;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use backend\models\User;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var backend\models\EstadoCuentaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Estado de Cuenta';
$this->params['breadcrumbs'][] = $this->title;

// Registro de scripts para el Modal y SweetAlert
$this->registerJs("
    $(document).on('click', '.btn-categorizar', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var modal = $('#modal-flota');
        $('#modalHeaderTitle').html('<i class=\"fa fa-tag\"></i> Categorizar Movimiento');
        modal.find('#modalContent').html('<div class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-3x\"></i><br>Cargando...</div>');
        modal.modal('show').find('#modalContent').load(url);
    });
");

$this->registerCss("
    .btn-redondo { border-radius: 20px !important; }
    .box-body { font-size: 13px; }
    .table thead th a { color: inherit !important; }
");
?>

<div class="estado-cuenta-index">

    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-10">
            <?= Html::a('<span class="fa fa-list"></span><b> Todos los Registros</b>', ['index'], ['class' => 'btn btn-primary']); ?>
            <?= Html::a('<span class="fa fa-upload"></span><b> Subir Archivo</b>', ['subir-txt'], ['class' => 'btn btn-warning']); ?>
        </div>
        <div class="col-md-2 text-right">
             </div>
    </div>

    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title text-danger"><i class="fa fa-exclamation-triangle"></i> Eliminación Masiva para Recarga</h3>
        </div>
        <div class="box-body">
            <?= Html::beginForm(['eliminar-por-dia'], 'post') ?>
            <div class="row">
                <div class="col-md-4">
                    <label>Fecha de Transacción</label>
                    <?= DatePicker::widget([
                        'name' => 'fecha_eliminar',
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']
                    ]); ?>
                </div>
                <div class="col-md-4">
                    <label>Cuenta Bancaria</label>
                    <?= Select2::widget([
                        'name' => 'cuenta_eliminar',
                        'data' => ArrayHelper::map(CuentasBancarias::find()->all(), 'numero_cuenta', 'numero_cuenta'),
                        'options' => ['placeholder' => 'Seleccione...'],
                    ]); ?>
                </div>
                <div class="col-md-4" style="margin-top: 25px;">
                    <?= Html::submitButton('<i class="fa fa-trash"></i> Borrar y Preparar Carga', [
                        'class' => 'btn btn-danger btn-block',
                        'data-confirm' => '¿Está seguro de eliminar los registros del día seleccionado?',
                    ]) ?>
                </div>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>

    <div class="box box-purple">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function ($model) {
                    if (!empty($model->id_categoria)) {
                        return ['style' => 'background-color: #d1ecf1 !important; border-left: 5px solid #0c5460;'];
                    }
                    return ($model->tipo_transaccion === '-') ? ["class" => "bg-gray-light"] : [];
                },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    
                    [
                        'attribute' => 'fecha_transaccion',
                        'format' => ['date', 'php:d-m-Y'],
                    ],
                    'referencia',
                    [
                        'attribute' => 'monto',
                        'contentOptions' => ['style' => 'text-align: right; font-weight: bold;'],
                        'value' => function ($model) {
                            // Aplicando formato: 1.250,50
                            return number_format($model->monto, 2, ',', '.');
                        },
                    ],
                    'numero_cuenta',
                    [
                        'attribute' => 'id_categoria',
                        'label' => 'Categoría',
                        'value' => function ($model) {
                            return $model->categoriaGasto ? $model->categoriaGasto->nombre_categoria : '(Sin asignar)';
                        },
                        'filter' => ArrayHelper::map(CategoriaGastos::find()->all(), 'id_categoria_gasto', 'nombre_categoria'),
                    ],
                    
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Acciones',
                        'template' => '{view} {categorizar}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="btn btn-info btn-xs btn-redondo fa fa-eye"></span>', $url, ['title' => 'Ver']);
                            },
                            'categorizar' => function ($url, $model) {
                                $noConciliado = ($model->conciliado == 0 || $model->conciliado === null);
                                if ($model->tipo_transaccion == '-' && $noConciliado) {
                                    return Html::a('<span class="btn btn-warning btn-xs btn-redondo fa fa-tag"></span>', 
                                        ['categorizar', 'id' => $model->idestado_cuenta], [
                                        'class' => 'btn-categorizar',
                                        'title' => 'Categorizar',
                                        'data-pjax' => '0',
                                    ]);
                                }
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>