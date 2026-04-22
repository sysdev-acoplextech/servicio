<?php

use backend\models\BaseTipoVehiculo;
use backend\models\Cliente;
use backend\models\Pasajero;
use backend\models\PasajeroServicio;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Servicios */

$this->title = "Voucher de Servicio #" . $model->id_servicio;
?>

<div class="servicio-voucher">

    <div class="row no-print" style="margin-bottom: 20px;">
        <div class="col-xs-12 text-right">
            <?= Html::a('<i class="fa fa-arrow-left"></i> Regresar', ['index'], ['class' => 'btn btn-default btn-flat']) ?>
            <button class="btn btn-primary btn-flat" onclick="window.print();"><i class="fa fa-print"></i> Imprimir Ficha</button>
        </div>
    </div>

    <div class="voucher-container">
        
        <table class="table-voucher-header">
            <tr>
                <td rowspan="3" class="logo-container" style="width: 15%;">
                    <img src="../web/img/CH_LOGO.png" alt="CH GROUP" style="width: 100px;">
                </td>
                <td class="header-title">SERVICIOS DE TRASLADOS CH GROUP</td>
            </tr>
            <tr>
                <td class="header-subtitle">
                    <?php 
                        $cli = Cliente::findOne($model->id_cliente);
                        echo mb_strtoupper($cli ? $cli->nombre_apellido : 'CONSORCIO RAGNAR'); 
                    ?>
                </td>
            </tr>
            <tr>
                <td class="header-date">
                    <?= Yii::$app->formatter->asDate($model->fecha_servicio, 'php:l: d/m/Y') ?>
                </td>
            </tr>
        </table>

        <table class="table-voucher-body">
            <thead>
                <tr>
                    <th style="width: 5%;">RUTA</th>
                    <th style="width: 20%;">NOMBRE</th>
                    <th style="width: 15%;">TELÉFONO</th>
                    <th style="width: 10%;">HORA</th>
                    <th style="width: 25%;">ORIGEN</th>
                    <th style="width: 25%;">DESTINO</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $paxs = PasajeroServicio::find()->where(['id_servicio' => $model->id_servicio])->all();
                foreach ($paxs as $index => $p): 
                    $p_info = Pasajero::findOne($p->id_pasajero);
                ?>
                    <tr>
                        <td align="center"><b><?= $index + 1 ?></b></td>
                        <td>
                            <b><?= $p_info ? $p_info->nombre_apellido : 'N/A' ?></b><br>
                            <small>1 Pasajero.</small><br>
                            <small>1 Maleta.</small> </td>
                        <td align="center"><?= $p_info ? $p_info->telefono : '--' ?></td>
                        <td align="center"><?= date('h:i a', strtotime($p->hora)) ?></td>
                        <td><?= $p->origen ?></td>
                        <td><?= $p->destino ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="6" style="height: 30px; background: #fff;"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Estilos para imitar la ficha de la imagen */
    .voucher-container {
        background-color: #fff;
        padding: 0;
        font-family: Arial, sans-serif;
        color: #000;
    }

    .table-voucher-header, .table-voucher-body {
        width: 100%;
        border-collapse: collapse;
        border: 2px solid #000;
    }

    .table-voucher-header td {
        border: 1px solid #000;
        padding: 5px;
        text-align: center;
        vertical-align: middle;
    }

    .header-title { font-weight: bold; font-size: 18px; }
    .header-subtitle { font-weight: bold; font-size: 16px; }
    .header-date { font-weight: bold; font-size: 15px; text-transform: capitalize; }

    .table-voucher-body th {
        background-color: #fff;
        border: 1px solid #000;
        padding: 4px;
        font-size: 12px;
        text-align: center;
    }

    .table-voucher-body td {
        border: 1px solid #000;
        padding: 8px;
        font-size: 13px;
        vertical-align: top;
    }

    .logo-container {
        border: 2px solid #000 !important;
    }

    @media print {
        .no-print { display: none; }
        .voucher-container { border: none; }
        body { background: #fff; }
    }
</style>