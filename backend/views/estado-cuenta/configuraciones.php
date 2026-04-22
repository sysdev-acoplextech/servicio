<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $cuentasActivas backend\models\CuentasBancarias[] */
/* @var $disponibleTotal float */
/* @var $disponibleTotalUsd float */
/* @var $pendientesConciliar int */

$this->title = 'Gestión Bancaria y Tesorería';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
    /* Regla: Contenedores rectos y botones redondeados */
    .box { border-radius: 0px !important; border-top: 3px solid #605ca8; }
    .info-box { border-radius: 0px !important; min-height: 100px; }
    .info-box-icon { border-radius: 0px !important; }
    
    .btn-modulo { 
        border-radius: 25px !important; 
        font-weight: bold; 
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .btn-modulo:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
    
    .text-monto { font-family: 'monospace'; font-weight: bold; }

    .table tbody tr:hover {
        background: #F1F5F9 !important;
        transform: scale(1.01);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
");
?>

<div class="gestion-bancaria-index">

    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-12">
            <div class="box box-solid" style="background-color: #f4f4f5; border: 1px solid #ddd;">
                <div class="box-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <?= Html::a('<i class="fa fa-university"></i> Cuentas Bancarias', ['cuentas-bancarias/index'], ['class' => 'btn btn-primary btn-block btn-modulo']) ?>
                        </div>
                        <div class="col-md-3">
                            <?= Html::a('<i class="fa fa-file-text-o"></i> Estado de Cuenta', ['estado-cuenta/index'], ['class' => 'btn btn-info btn-block btn-modulo']) ?>
                        </div>
                        <div class="col-md-3">
                            <?= Html::a('<i class="fa fa-exchange"></i> Movimientos', ['relacion-movimientos/index'], ['class' => 'btn btn-warning btn-block btn-modulo']) ?>
                        </div>
                        <div class="col-md-3">
                            <?= Html::a('<i class="fa fa-lock"></i> Cierre Diario', ['cierre-diario/create'], ['class' => 'btn btn-danger btn-block btn-modulo']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">SALDO TOTAL (VES)</span>
                    <span class="info-box-number text-monto">
                        <?= number_format($disponibleTotal, 2, ',', '.') ?>
                    </span>
                    <div class="progress"><div class="progress-bar" style="width: 70%"></div></div>
                    <span class="progress-description">Actualizado hoy: <?= date('d-m-Y') ?></span>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-dollar"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">SALDO TOTAL (USD)</span>
                    <span class="info-box-number text-monto">
                        <?= number_format($disponibleTotalUsd, 2, ',', '.') ?>
                    </span>
                    <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                    <span class="progress-description">Cuentas en Divisas</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">PEND. CONCILIAR</span>
                    <span class="info-box-number text-monto">
                        <?= number_format($pendientesConciliar, 0, ',', '.') ?>
                    </span>
                    <div class="progress"><div class="progress-bar" style="width: 40%"></div></div>
                    <span class="progress-description">Movimientos sin procesar</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">ÚLTIMO CIERRE</span>
                    <span class="info-box-number"><?= date('d-m-Y', strtotime("-1 day")) ?></span>
                    <span class="progress-description">Estado: <b class="label label-success">Cuadrado</b></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
       <div class="col-md-7">
            <div class="card-bancaria-disponibilidad" style="background: #FFFFFF; border-radius: 25px !important; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: none; overflow: hidden;">
                <div style="padding: 25px 30px; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center;">
                    <h5 style="margin: 0; font-weight: bold; color: #1B242D;">
                        <i class="fa fa-bank" style="color: #98C1D9; margin-right: 10px;"></i> Disponibilidad en Cuentas
                    </h5>
                    <span class="badge" style="background: #F1F5F9; color: #64748B; border-radius: 8px; padding: 5px 12px; font-size: 8pt;">
                        <?= count($cuentasActivas) ?> CUENTAS ACTIVAS
                    </span>
                </div>

                <div class="table-responsive" style="padding: 10px 20px 20px 20px;">
                    <table class="table" style="border-collapse: separate; border-spacing: 0 8px;">
                        <thead>
                            <tr style="color: #94A3B8; font-size: 8.5pt; text-transform: uppercase; letter-spacing: 1px;">
                                <th style="border: none; padding: 15px;">Banco</th>
                                <th style="border: none; padding: 15px;">Número de Cuenta</th>
                                <th style="border: none; padding: 15px; text-align: right;">Saldo Disponible</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cuentasActivas as $cuenta): ?>
                                <tr style="background: #F8FAFC; transition: 0.3s;">
                                    <td style="border: none; padding: 15px; border-radius: 12px 0 0 12px;">
                                        <b style="color: #1B242D;">
                                            <?= $cuenta->banco ? Html::encode($cuenta->banco->nom_banco) : 'S/N' ?>
                                        </b>
                                    </td>
                                    <td style="border: none; padding: 15px; color: #64748B; font-family: monospace;">
                                        <?= Html::encode($cuenta->numero_cuenta) ?>
                                    </td>
                                    <td style="border: none; padding: 15px; border-radius: 0 12px 12px 0; text-align: right;">
                                        <span style="font-weight: bold; color: #10B981; font-size: 11pt;">
                                            <?= number_format($cuenta->saldo, 2, ',', '.') ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (empty($cuentasActivas)): ?>
                                <tr>
                                    <td colspan="3" class="text-center" style="padding: 40px; color: #CBD5E1;">
                                        <i class="fa fa-info-circle fa-2x"></i><br>No hay cuentas registradas
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div style="padding: 15px 30px; background: #F8FAFC; border-top: 1px solid #F1F5F9; text-align: right;">
                    <small style="color: #94A3B8; font-weight: bold;">
                        TOTAL CONSOLIDADO (VES): 
                        <span style="color: #1B242D; margin-left: 10px; font-size: 10pt;">
                            <?= number_format($disponibleTotal, 2, ',', '.') ?>
                        </span>
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-tasks"></i> Tareas de Control</h3>
                </div>
                <div class="box-body">
                    <ul class="todo-list">
                        <li>
                            <span class="handle"><i class="fa fa-ellipsis-v"></i></span>
                            <span class="text">Verificar egresos del día sin referencia</span>
                            <small class="label label-danger"><i class="fa fa-clock-o"></i> Crítico</small>
                        </li>
                        <li>
                            <span class="handle"><i class="fa fa-ellipsis-v"></i></span>
                            <span class="text">Conciliar transferencias de <?= count($cuentasActivas) ?> cuentas</span>
                            <small class="label label-info"><i class="fa fa-clock-o"></i> Pendiente</small>
                        </li>
                    </ul>
                </div>
                <div class="box-footer text-center">
                    <?= Html::a('Realizar Cierre de Caja/Banco', ['cierre-diario/create'], ['class' => 'btn btn-danger btn-sm btn-modulo']) ?>
                </div>
            </div>
        </div>
    </div>
</div>