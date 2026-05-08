<?php
use miloschuman\highcharts\Highcharts;
use yii\helpers\{Html, Url, ArrayHelper};

$this->title = 'Panel Operativo CH GROUP';
$formato = function($valor) { return number_format($valor, 2, ',', '.'); };
?>

<div class="row">
    <div class="col-md-4">
        <div class="info-box bg-navy" style="border-radius: 15px;">
            <span class="info-box-icon"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">TASA DEL DÍA</span>
                <span class="info-box-number" style="font-size: 25px;"><?= $tasaDia ? $formato($tasaDia->valor) : '0,00' ?> Bs.</span>
                <span class="progress-description">Act: <?= $tasaDia ? date('d/m H:i', strtotime($tasaDia->fecha_hora)) : '--' ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="quick-actions-grid">
            <?= Html::a('<i class="fa fa-plus"></i><br>NUEVO', ['servicios/create'], ['class' => 'q-btn bg-green']) ?>
            <?= Html::a('<i class="fa fa-list"></i><br>SERVICIOS', ['servicios/index'], ['class' => 'q-btn bg-blue']) ?>
            <?= Html::a('<i class="fa fa-book"></i><br>TARIFARIO', ['tarifario/index'], ['class' => 'q-btn bg-orange']) ?>
            <?= Html::a('<i class="fa fa-users"></i><br>CLIENTES', ['cliente/index'], ['class' => 'q-btn bg-purple']) ?>
            <?= Html::a('<i class="fa fa-gears"></i><br>CONFIG', ['config/index'], ['class' => 'q-btn bg-gray']) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="small-box bg-yellow" style="border-radius: 12px;">
            <div class="inner"><h3><?= $serviciosAgendados ?></h3><p>Servicios Agendados</p></div>
            <div class="icon"><i class="fa fa-clock-o"></i></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-blue" style="border-radius: 12px;">
            <div class="inner"><h3><?= $serviciosConfirmados ?></h3><p>Confirmados / Listos</p></div>
            <div class="icon"><i class="fa fa-check-circle"></i></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-maroon" style="border-radius: 12px;">
            <div class="inner"><h3><?= $serviciosHoy ?></h3><p>Servicios para HOY</p></div>
            <div class="icon"><i class="fa fa-car"></i></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-green" style="border-radius: 12px;">
            <div class="inner"><h3><?= $pagosHoyCount ?></h3><p>Pagos Recibidos Hoy</p></div>
            <div class="icon"><i class="fa fa-credit-card"></i></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="box box-solid" style="border-radius: 15px;">
            <div class="box-header with-border"><h3 class="box-title">Evolución de Ingresos (6 Meses)</h3></div>
            <div class="box-body">
                <?= Highcharts::widget([
                    'options' => [
                        'chart' => ['type' => 'areaspline', 'height' => 300],
                        'title' => ['text' => ''],
                        'xAxis' => ['categories' => ArrayHelper::getColumn($salesData, 'month')],
                        'series' => [['name' => 'Monto Bs.', 'data' => ArrayHelper::getColumn($salesData, 'total_sales'), 'color' => '#00a65a']]
                    ]
                ]); ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="box box-solid" style="border-radius: 15px; min-height: 360px;">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-pie-chart text-green"></i> Pagos de Hoy</h3>
            </div>
            <div class="box-body">
                <?php if (!empty($tiposPagoHoy)): ?>
                    <table class="table table-condensed">
                        <thead>
                            <tr><th>Tipo</th><th class="text-right">Cant.</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tiposPagoHoy as $tpHoy): ?>
                            <tr>
                                <td><i class="fa fa-circle text-aqua"></i> <?= mb_strtoupper($tpHoy->tipo_pago) ?></td>
                                <td class="text-right"><strong><?= $tpHoy->id_servicio ?></strong></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="text-center text-muted" style="padding-top: 50px;">
                        <i class="fa fa-info-circle fa-2x"></i><br>No se han registrado<br>pagos el día de hoy.
                    </div>
                <?php endif; ?>
            </div>
            <div class="box-footer bg-gray-light" style="border-radius: 0 0 15px 15px;">
                <span class="pull-left">Total Mes:</span>
                <strong class="pull-right text-green">Bs. <?= $formato($montoMes) ?></strong>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-solid" style="border-radius: 15px;">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-users text-blue"></i> Actividad de Conductores del Mes</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <?php if (!empty($conductoresActivos)): ?>
                        <?php $max = $conductoresActivos[0]->total > 0 ? $conductoresActivos[0]->total : 1; ?>
                        
                        <?php foreach ($conductoresActivos as $c): ?>
                            <div class="col-md-4" style="margin-bottom: 20px;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div class="conductor-avatar">
                                        <?php 
                                        $fotoPath = ($c->foto) ? Yii::getAlias('@web')  . $c->foto : Yii::getAlias('@web') . '/img/default-user.png';
// Debug: Verificar la ruta de la imagen
                                        echo Html::img($fotoPath, [
                                            'class' => 'img-circle',
                                            'style' => 'width: 50px; height: 50px; object-fit: cover; border: 2px solid #3c8dbc;'
                                        ]);
                                        ?>
                                    </div>

                                    <div style="flex-grow: 1;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                            <strong style="font-size: 13px;"><?= mb_strtoupper($c->conductor) ?></strong>
                                            <span class="label bg-blue"><?= $c->total ?></span>
                                        </div>
                                        <div class="progress progress-xs" style="margin-bottom: 0; background: #eee;">
                                            <div class="progress-bar progress-bar-aqua" 
                                                 style="width: <?= ($c->total / $max) * 100 ?>%; border-radius: 10px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-md-12 text-center text-muted">No hay actividad este mes.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .conductor-avatar img {
        transition: transform 0.3s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .conductor-avatar img:hover {
        transform: scale(1.1);
    }
</style>

<style>
    .quick-actions-grid { display: flex; justify-content: space-between; gap: 8px; margin-bottom: 20px; }
    .q-btn {
        flex: 1; height: 85px; text-align: center; padding-top: 15px; border-radius: 15px;
        color: white !important; font-weight: bold; font-size: 10px; transition: 0.2s;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .q-btn:hover { transform: translateY(-3px); filter: brightness(1.1); }
    .q-btn i { font-size: 22px; margin-bottom: 5px; }
    .info-box-number { font-weight: bold; }
</style>