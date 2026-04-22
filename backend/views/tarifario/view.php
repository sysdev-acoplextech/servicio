<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Tarifario */

$this->title = $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Tarifarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerCss("
    .tarifario-view { padding: 20px; background-color: #F8FAFC; min-height: 100vh; }
    
    .card-moderna {
        background: #FFFFFF; 
        border-radius: 25px !important; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.02); 
        border: 1px solid #F1F5F9;
        margin-bottom: 25px;
        overflow: hidden;
    }

    .btn-modulo { 
        border-radius: 25px !important; 
        font-weight: bold; 
        text-transform: uppercase; 
        transition: 0.3s;
        padding: 10px 20px;
        border: none;
    }

    .table-detalle thead th {
        background: #F8FAFC;
        color: #94A3B8;
        font-size: 8pt;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 15px !important;
        border: none !important;
    }

    .table-detalle td {
        padding: 15px !important;
        vertical-align: middle !important;
        border-top: 1px solid #F1F5F9 !important;
    }

    .text-monto { font-family: 'monospace'; font-weight: bold; color: #1E293B; font-size: 11pt; }

    /* Estilo para el indicador de viático */
    .badge-viatico {
        padding: 5px 12px;
        border-radius: 12px;
        font-size: 7.5pt;
        font-weight: bold;
    }
");
?>

<div class="tarifario-view">

    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-8">
            <h2 style="font-weight: bold; color: #1B242D; margin: 0;"><?= Html::encode($this->title) ?></h2>
            <p class="text-muted">ID de Tarifario: #<?= $model->id_tarifario ?></p>
        </div>
        <div class="col-md-4 text-right">
            <?= Html::a('<i class="fa fa-pencil"></i> EDITAR', ['update', 'id' => $model->id_tarifario], [
                'class' => 'btn btn-primary btn-modulo',
                'style' => 'background: #6366F1;'
            ]) ?>
            <?= Html::a('<i class="fa fa-trash"></i> ELIMINAR', ['delete', 'id' => $model->id_tarifario], [
                'class' => 'btn btn-danger btn-modulo',
                'style' => 'background: #EF4444; margin-left: 10px;',
                'data' => [
                    'confirm' => '¿Está seguro de que desea eliminar este tarifario?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card-moderna">
                <div style="padding: 25px;">
                    <h5 style="font-weight: bold; color: #1B242D; margin-bottom: 20px;">Detalles del Maestro</h5>
                    <hr>
                    <label style="color: #94A3B8; font-size: 8pt; text-transform: uppercase;">Descripción</label>
                    <p style="font-size: 12pt; font-weight: 500; color: #334155;"><?= $model->descripcion ?></p>
                    
                    <div style="margin-top: 20px; background: #F1F5F9; padding: 15px; border-radius: 15px;">
                        <small style="color: #64748B;">
                            <i class="fa fa-info-circle"></i> Este tarifario agrupa todas las rutas y precios definidos para este segmento de servicio.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card-moderna">
                <div style="padding: 20px 25px; border-bottom: 1px solid #F1F5F9;">
                    <b style="color: #1E293B;">RUTAS Y PRECIOS REGISTRADOS</b>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-detalle" style="margin-bottom: 0;">
                        <thead>
                            <tr>
                                <th>Ruta / Itinerario</th>
                                <th class="text-center" width="120">Viático</th>
                                <th class="text-right" width="150">Sedan (VES)</th>
                                <th class="text-right" width="150">Camioneta (VES)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($model->detalles): ?>
                                <?php foreach ($model->detalles as $detalle): ?>
                                    <tr>
                                        <td>
                                            <b style="color: #334155;"><?= Html::encode($detalle->rutas) ?></b>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($detalle->inc_viatico): ?>
                                                <span class="badge-viatico" style="background: #DCFCE7; color: #166534;">
                                                    <i class="fa fa-check"></i> SÍ
                                                </span>
                                            <?php else: ?>
                                                <span class="badge-viatico" style="background: #F1F5F9; color: #94A3B8;">
                                                    NO
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-right text-monto">
                                            <?= number_format($detalle->sedan, 2, ',', '.') ?>
                                        </td>
                                        <td class="text-right text-monto">
                                            <?= number_format($detalle->camioneta, 2, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted" style="padding: 40px !important;">
                                        No hay rutas registradas para este tarifario.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>