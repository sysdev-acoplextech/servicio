<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\User;

/** @var yii\web\View $this */
/** @var backend\models\FinancieroEstadoCuenta $model */

$this->title = 'Referencia: ' . $model->referencia;

$this->registerCss("
    .view-wrapper { padding: 30px; background-color: #F8FAFC; min-height: 100vh; }
    
    .card-detalle {
        background: #FFFFFF;
        border-radius: 25px !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03) !important;
        border: none !important;
        overflow: hidden;
        margin-bottom: 25px;
    }

    .card-detalle .card-header {
        background: #1B242D !important;
        color: white;
        padding: 20px 25px;
        border: none;
    }

    /* Botones Redondeados */
    .btn-redondo {
        border-radius: 20px !important;
        font-weight: bold;
        padding: 8px 20px;
        transition: 0.3s;
    }

    /* Estilo de la Tabla DetailView */
    .table-view th { 
        background-color: #F8FAFC; 
        color: #64748B; 
        text-transform: uppercase; 
        font-size: 8pt; 
        letter-spacing: 1px;
        width: 35%;
        padding: 15px 25px !important;
    }
    .table-view td { padding: 15px 25px !important; vertical-align: middle; color: #1B242D; font-weight: 500; }
    
    .monto-destacado {
        font-family: 'Averta', monospace;
        font-size: 18pt;
        font-weight: bold;
    }
");
?>

<div class="view-wrapper">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 style="color: #1B242D; font-weight: bold; margin: 0;"><?= Html::encode($this->title) ?></h1>
            <p style="color: #94A3B8; margin-top: 5px;">Detalle completo del movimiento bancario registrado.</p>
        </div>
        <div>
            <?= Html::a('<i class="fa fa-arrow-left"></i>', ['index'], ['class' => 'btn btn-default btn-redondo shadow-sm', 'style' => 'background: white; border: 1px solid #E2E8F0; color: #64748B;']) ?>
            <?= Html::a('<i class="fa fa-edit"></i> EDITAR', ['update', 'id' => $model->idestado_cuenta], ['class' => 'btn btn-primary btn-redondo shadow-sm', 'style' => 'background: #1B242D; border: none;']) ?>
            
            <?php if ($model->tipo_transaccion === '-'): ?>
                <?= Html::a('<i class="fa fa-tag"></i> RECATEGORIZAR', ['categorizar', 'id' => $model->idestado_cuenta], [
                    'class' => 'btn btn-warning btn-redondo shadow-sm',
                    'style' => 'color: #1B242D;'
                ]) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card-detalle">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fa fa-university"></i> Movimiento Bancario</h5>
                </div>
                <div class="card-body p-0">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-view mb-0'],
                        'attributes' => [
                            [
                                'attribute' => 'numero_cuenta',
                                'label' => 'Cuenta Bancaria',
                                'value' => $model->numero_cuenta,
                            ],
                            'referencia',
                            [
                                'attribute' => 'fecha_transaccion',
                                'format' => ['date', 'php:d-m-Y'],
                            ],
                            [
                                'attribute' => 'monto',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $color = ($model->tipo_transaccion == '+') ? '#10B981' : '#EF4444';
                                    $monto_formateado = number_format($model->monto, 2, ',', '.');
                                    return Html::tag('span', $monto_formateado . ' <small>USD</small>', [
                                        'class' => 'monto-destacado',
                                        'style' => "color: $color;"
                                    ]);
                                },
                            ],
                            [
                                'attribute' => 'id_categoria',
                                'label' => 'Categoría',
                                'format' => 'raw',
                                'visible' => ($model->tipo_transaccion === '-'),
                                'value' => function ($model) {
                                    if ($model->categoriaGasto) {
                                        return '<span class="badge" style="background: #E0E7FF; color: #4338CA; padding: 8px 15px; border-radius: 8px;">' . 
                                               '<i class="fa fa-tag"></i> ' . $model->categoriaGasto->nombre_categoria . '</span>';
                                    }
                                    return '<span class="text-muted" style="font-style: italic;">Sin asignar</span>';
                                },
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card-detalle">
                <div class="card-header" style="background: #64748B !important;">
                    <h5 class="mb-0"><i class="fa fa-shield"></i> Auditoría y Control</h5>
                </div>
                <div class="card-body p-0">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-view mb-0'],
                        'attributes' => [
                            [
                                'attribute' => 'idestado_cuenta',
                                'label' => 'ID Interno',
                            ],
                            [
                                'attribute' => 'conciliado',
                                'format' => 'raw',
                                'value' => $model->conciliado 
                                    ? '<span style="color: #10B981;"><i class="fa fa-check-circle"></i> Conciliado</span>' 
                                    : '<span style="color: #F59E0B;"><i class="fa fa-clock-o"></i> Pendiente por Conciliar</span>',
                            ],
                            [
                                'attribute' => 'operador',
                                'value' => function ($model) {
                                    $user = User::findOne($model->operador);
                                    return $user ? strtoupper($user->username) : 'SISTEMA';
                                },
                            ],
                            [
                                'label' => 'Fecha Registro',
                                'value' => date("d-m-Y", strtotime($model->fecha_registro)) . ' / ' . $model->hora,
                            ],
                        ],
                    ]) ?>
                </div>
            </div>

            <?php if (!$model->conciliado): ?>
                <div style="background: #FFFBEB; border-radius: 20px; padding: 20px; border: 1px solid #FEF3C7; color: #92400E; display: flex; align-items: center;">
                    <i class="fa fa-info-circle" style="font-size: 20pt; margin-right: 15px;"></i>
                    <p style="margin: 0; font-size: 9pt; font-weight: 500;">
                        Este registro fue cargado mediante archivo externo y está a la espera de conciliación definitiva.
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>