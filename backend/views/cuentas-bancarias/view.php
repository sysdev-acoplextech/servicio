<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CuentasBancarias */

$this->title = $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Cuentas Bancarias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
    .cuentas-view-container {
        padding: 30px;
        background-color: #F8FAFC;
        min-height: 100vh;
    }
    .ficha-detalle {
        background: #FFFFFF;
        border-radius: 25px !important;
        box-shadow: 0 15px 40px rgba(0,0,0,0.05) !important;
        border: none !important;
        padding: 40px;
        margin-top: 20px;
    }
    .btn-redondo {
        border-radius: 15px !important;
        padding: 12px 25px;
        font-weight: bold;
        transition: 0.3s;
        border: none;
    }
    .btn-redondo:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .label-detalle {
        color: #64748B;
        font-size: 8pt;
        text-transform: uppercase;
        font-weight: bold;
        letter-spacing: 1.2px;
        margin-bottom: 6px;
    }
    .valor-detalle {
        font-size: 12pt;
        color: #1B242D;
        font-weight: 600;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
    }
    .valor-detalle i {
        margin-right: 10px;
        color: #94A3B8;
    }
    .saldo-header {
        font-size: 35pt;
        font-weight: bold;
        color: #10B981;
        font-family: 'Averta', sans-serif;
        letter-spacing: -1px;
        line-height: 1;
    }
    .tag-tipo {
        background: #1B242D;
        color: #FFF;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 9pt;
        font-weight: bold;
    }
");
?>

<div class="cuentas-view-container">

    <div class="row" style="display: flex; align-items: center;">
        <div class="col-md-7">
            <p style="color: #94A3B8; font-size: 11pt; margin-top: 5px;">Gestión de activos financieros / ID #<?= $model->id_cuentas ?></p>
        </div>
        <div class="col-md-5 text-right">
            <?= Html::a('<i class="fa fa-pencil"></i> EDITAR CUENTA', ['update', 'id' => $model->id_cuentas], [
                'class' => 'btn btn-primary btn-redondo',
                'style' => 'background-color: #1B242D;'
            ]) ?>
            
            <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id_cuentas], [
                'class' => 'btn btn-redondo',
                'style' => 'background-color: #FEE2E2; color: #EF4444; margin-left: 10px;',
                'data' => [
                    'confirm' => '¿Está seguro de que desea eliminar esta cuenta bancaria?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="ficha-detalle">
        <div class="row">
            
            <div class="col-md-6" style="border-right: 1px solid #F1F5F9; padding-right: 40px;">
                
                <div class="label-detalle">Institución Financiera</div>
                <div class="valor-detalle">
                    <i class="fa fa-university"></i> 
                    <?= $model->banco ? $model->banco->nom_banco : '<span class="text-danger">Banco no vinculado</span>' ?>
                </div>

                <div class="label-detalle">Número de Cuenta Interbancario</div>
                <div class="valor-detalle" style="font-family: 'Courier New', monospace; font-size: 14pt; color: #EA4C2D;">
                    <?= $model->numero_cuenta ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="label-detalle">Tipo de Cuenta</div>
                        <div class="valor-detalle">
                            <span class="tag-tipo">
                                <?= $model->tipoCuenta ? $model->tipoCuenta->nombre_tipo_cuenta : 'NO DEFINIDO' ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="label-detalle">Estatus</div>
                        <div class="valor-detalle">
                            <?= $model->estatus == 1 
                                ? '<span style="color: #10B981;"><i class="fa fa-check-circle"></i> OPERATIVA</span>' 
                                : '<span style="color: #EF4444;"><i class="fa fa-pause-circle"></i> SUSPENDIDA</span>' 
                            ?>
                        </div>
                    </div>
                </div>

                <div class="label-detalle">Descripción / Alias</div>
                <div class="valor-detalle" style="font-weight: 400; color: #64748B;">
                    <?= $model->descripcion ?>
                </div>
            </div>

            <div class="col-md-6" style="padding-left: 50px;">
                
                <div class="label-detalle">Saldo Disponible</div>
                <div class="saldo-header">
                    <?= number_format($model->saldo, 2, ',', '.') ?>
                    <small style="font-size: 14pt; color: #94A3B8; font-weight: normal;">
                        <?= $model->tipoMoneda ? $model->tipoMoneda->cod_moneda : '' ?>
                    </small>
                </div>

                <div class="row" style="margin-top: 30px;">
                    <div class="col-md-6">
                        <div class="label-detalle">Fecha Apertura Saldo</div>
                        <div class="valor-detalle">
                            <i class="fa fa-calendar"></i> 
                            <?= $model->fecha_saldo_inicial ? date("d-m-Y", strtotime($model->fecha_saldo_inicial)) : '---' ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="label-detalle">Divisa Base</div>
                        <div class="valor-detalle">
                            <i class="fa fa-money"></i> 
                            <?= $model->tipoMoneda ? $model->tipoMoneda->moneda : 'N/A' ?>
                        </div>
                    </div>
                </div>

                <div style="background: #F8FAFC; padding: 25px; border-radius: 20px; border: 1px solid #F1F5F9; margin-top: 15px;">
                    <div class="label-detalle" style="font-size: 7.5pt; color: #94A3B8; margin-bottom: 12px;">Registro de Auditoría</div>
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <div style="background: #1B242D; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                            <i class="fa fa-user" style="color: white; font-size: 10pt;"></i>
                        </div>
                        <div style="font-size: 10pt; color: #1B242D;">
                            <b>Usuario Responsable:</b><br>
                            <span style="color: #64748B;"><?= $model->id_usuario ? strtoupper($model->usuario->username) : 'SISTEMA AUTOMÁTICO' ?></span>
                        </div>
                    </div>
                    <div style="font-size: 9pt; color: #64748B; border-top: 1px solid #EEE; padding-top: 10px; margin-top: 5px;">
                        <i class="fa fa-clock-o"></i> Registrado el <b><?= date("d-m-Y", strtotime($model->fecha_registro)) ?></b> a las <b><?= date("g:i A", strtotime($model->hora)) ?></b>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="text-center" style="margin-top: 35px;">
        <?= Html::a('<i class="fa fa-arrow-left"></i> VOLVER AL PANEL DE CUENTAS', ['index'], [
            'style' => 'color: #94A3B8; font-weight: bold; text-decoration: none; font-size: 10pt; letter-spacing: 0.5px;'
        ]) ?>
    </div>

</div>