<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\Cliente;
use backend\models\FormaPago;
use backend\models\PasajeroServicio;
use backend\models\BaseTipoVehiculo;
use backend\models\Conductor;
use backend\models\VFlota;

// Librerías: FullCalendar
$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js');

$this->registerCss("
    .servicios-index { padding: 25px; background-color: #F8FAFC; min-height: 100vh; }
    
    .control-panel { 
        background: #fff; border-radius: 20px; padding: 20px; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #E2E8F0; margin-bottom: 20px;
    }

    .view-switcher { background: #F1F5F9; border-radius: 12px; padding: 5px; display: inline-flex; gap: 5px; }
    .view-switcher .btn-view {
        border-radius: 8px; border: none; padding: 8px 16px; font-weight: 700; color: #64748B;
        background: transparent; transition: 0.3s;
    }
    .view-switcher .btn-view.active { background: #fff; color: #1B242D; box-shadow: 0 2px 6px rgba(0,0,0,0.05); }

    .grid-servicios { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }
    
    .card-servicio {
        background: #fff; border-radius: 20px; border: 1px solid #E2E8F0; overflow: hidden;
        transition: transform 0.2s; position: relative; padding-top: 5px;
    }
    .card-servicio:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0,0,0,0.05); }
    
    .card-ruta-pendiente { border: 2px solid #F59E0B !important; }
    .tag-ruta-alerta { 
        position: absolute; top: 45px; right: 15px; background: #EF4444; color: white; 
        padding: 2px 8px; border-radius: 6px; font-size: 9px; font-weight: 800;
        animation: pulse-red 2s infinite;
    }

    @keyframes pulse-red {
        0% { opacity: 1; } 50% { opacity: 0.5; } 100% { opacity: 1; }
    }

    .card-tag { 
        position: absolute; top: 15px; right: 15px; padding: 4px 12px; 
        border-radius: 8px; font-size: 10px; font-weight: 800; text-transform: uppercase;
    }
    .tag-confirmado { background: #DCFCE7; color: #166534; }
    .tag-pendiente { background: #FEF3C7; color: #92400E; }

    .pay-tag {
        position: absolute; top: 15px; left: 15px; padding: 4px 10px; 
        border-radius: 8px; font-size: 9px; font-weight: 800; text-transform: uppercase;
        z-index: 11;
    }
    .pay-total { background: #10B981; color: white; }
    .pay-parcial { background: #3B82F6; color: white; }
    .pay-deuda { background: #EF4444; color: white; }

    /* Ajuste de etiqueta de despacho para evitar solapamiento */
    .dispatch-tag {
        position: absolute; top: 15px; left: 115px; padding: 4px 10px; 
        border-radius: 8px; font-size: 9px; font-weight: 800; text-transform: uppercase;
        z-index: 10;
    }
    .dispatch-assigned { background: #E0F2FE; color: #0369A1; border: 1px solid #bae6fd; }
    .dispatch-none { background: #FFF1F2; color: #E11D48; border: 1px dashed #FECDD3; }

    .card-header-s { padding: 35px 20px 15px 20px; border-bottom: 1px solid #F1F5F9; }
    .card-client { font-size: 16px; font-weight: 800; color: #1E293B; display: block; }
    .card-id { color: #EA4C2D; font-weight: 900; font-size: 12px; }

    .card-body-s { padding: 20px; }
    .card-info-row { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; color: #475569; font-size: 13px; }
    .card-info-row i { color: #EA4C2D; width: 15px; }

    .card-driver-info {
        margin-top: 10px; padding-top: 10px; border-top: 1px dashed #E2E8F0;
        display: flex; align-items: center; gap: 10px;
    }
    .driver-avatar {
        width: 30px; height: 30px; background: #1B242D; color: white; 
        border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px;
    }

    #calendar { background: #fff; padding: 20px; border-radius: 20px; border: 1px solid #E2E8F0; display: none; }
");

$this->registerJs("
    $('.btn-view').click(function() {
        const view = $(this).data('view');
        $('.btn-view').removeClass('active');
        $(this).addClass('active');
        $('.view-content, #calendar').hide();
        if(view === 'calendar') { 
            $('#calendar').fadeIn();
            calendar.render(); 
        } else {
            $('#view-' + view).fadeIn();
        }
    });

    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay' },
        events: " . json_encode($eventosCalendario) . ",
        eventClick: function(info) {
            window.location.href = '" . Url::to(['view']) . "?id=' + info.event.id;
        }
    });
");
?>

<div class="servicios-index">

    <div class="control-panel">
        <div class="row" style="display: flex; align-items: center;">
            <div class="col-md-4">
                <h3 style="margin: 0; font-weight: 800; color: #1B242D;">Logística de Servicios</h3>
            </div>
            <div class="col-md-4 text-center">
                <div class="view-switcher">
                    <button class="btn-view active" data-view="grid"><i class="fa fa-th-large"></i> Tarjetas</button>
                    <button class="btn-view" data-view="list"><i class="fa fa-list"></i> Lista</button>
                    <button class="btn-view" data-view="calendar"><i class="fa fa-calendar"></i> Agenda</button>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <?= Html::a('<i class="fa fa-plus"></i> NUEVO SERVICIO', ['create'], [
                    'class' => 'btn btn-success',
                    'style' => 'border-radius:15px; padding: 10px 25px; font-weight:bold; background: #10B981; border:none;'
                ]) ?>
            </div>
        </div>
    </div>

    <div id="view-grid" class="view-content">
        <div class="grid-servicios">
            <?php foreach ($dataProvider->getModels() as $model): 
                $cli = Cliente::findOne($model->id_cliente);
                $fp = FormaPago::findOne($model->id_forma_pago);
                $esConfirmado = ($model->id_estatus == 11); 
                $esPagoTotalStatus = ($model->id_estatus == 7);
                $pasajero = PasajeroServicio::find()->where(['id_servicio' => $model->id_servicio])->one();

                $conductor = !empty($model->id_conductor) ? Conductor::findOne($model->id_conductor) : null;
                $vehiculo = !empty($model->id_flota) ? VFlota::findOne(['id_flota' => $model->id_flota]) : null;

                $tieneRuta = ($pasajero && !empty($pasajero->origen) && !empty($pasajero->destino));
                $alertaRuta = ($esConfirmado && !$tieneRuta);

                $payTagHtml = '';
                $faltante = $model->faltante;
                $montoTotal = $model->monto;

                if ($esConfirmado || $esPagoTotalStatus) {
                    if ($esPagoTotalStatus || ($faltante <= 0 && !is_null($faltante))) {
                        $payTagHtml = '<div class="pay-tag pay-total"><i class="fa fa-check"></i> Pago Total</div>';
                    } elseif ($faltante > 0 && $faltante < $montoTotal) {
                        $payTagHtml = '<div class="pay-tag pay-parcial"><i class="fa fa-warning"></i> Pago Parcial</div>';
                    } else {
                        $payTagHtml = '<div class="pay-tag pay-deuda"><i class="fa fa-hourglass-start"></i> Deuda</div>';
                    }
                } else {
                    $payTagHtml = '<div class="pay-tag pay-deuda" style="background:#94a3b8;"><i class="fa fa-clock-o"></i> Agendado</div>';
                }
            ?>
                <div class="card-servicio <?= $alertaRuta ? 'card-ruta-pendiente' : '' ?>">
                    <?= $payTagHtml ?>
                    
                    <div class="dispatch-tag <?= $conductor ? 'dispatch-assigned' : 'dispatch-none' ?>">
                        <i class="fa <?= $conductor ? 'fa-id-card' : 'fa-user-times' ?>"></i> 
                        <?= $conductor ? 'Asignado' : 'Sin Chofer' ?>
                    </div>

                    <?php if ($alertaRuta): ?>
                        <div class="tag-ruta-alerta"><i class="fa fa-exclamation-triangle"></i> RUTA PENDIENTE</div>
                    <?php endif; ?>

                    <div class="card-tag <?= ($esConfirmado || $esPagoTotalStatus) ? 'tag-confirmado' : 'tag-pendiente' ?>">
                        <?= $esPagoTotalStatus ? 'Completado' : ($esConfirmado ? 'Confirmado' : 'Agendado') ?>
                    </div>

                    <div class="card-header-s">
                        <span class="card-id">#<?= $model->id_servicio ?></span>
                        <span class="card-client"><?= $cli ? mb_strtoupper($cli->nombre_apellido) : 'CONSUMIDOR FINAL' ?></span>
                    </div>

                    <div class="card-body-s">
                        <div class="card-info-row">
                            <i class="fa fa-calendar"></i> 
                            <b><?= Yii::$app->formatter->asDate($model->fecha_servicio, 'medium') ?></b>
                        </div>

                        <div style="display: flex; justify-content: space-between; gap: 10px; margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; gap: 8px; flex: 1;">
                                <i class="fa fa-money" style="color: #EA4C2D;"></i> 
                                <span style="font-size: 11px; font-weight: 600;"><?= $fp ? mb_strtoupper($fp->descripcion) : 'N/A' ?></span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; flex: 1; border-left: 1px solid #eee; padding-left: 10px;">
                                <i class="fa fa-car" style="color: #EA4C2D;"></i> 
                                <span style="font-size: 11px; font-weight: 600;">
                                    <?php 
                                    $tipoVehiculo = BaseTipoVehiculo::findOne($model->id_tipo_vehiculo);
                                    echo $tipoVehiculo ? mb_strtoupper($tipoVehiculo->nombre_tipo_vehiculo) : 'N/A';
                                    ?>
                                </span>
                            </div>
                        </div>

                         <?php if ($pasajero && !empty($pasajero->google_map)): 
                            $query = trim($pasajero->google_map);
                            $urlMaps = "https://www.google.com/maps/search/?api=1&query=" . rawurlencode($query);
                        ?>
                            <a href="<?= $urlMaps ?>" target="_blank" rel="noopener noreferrer" class="btn btn-xs" 
                               style="display: block; width: 100%; margin-bottom: 15px; background: #0EA5E9; color: white; font-weight: 800; font-size: 10px; border-radius: 20px; border: none; padding: 8px; text-align: center;">
                                <i class="fa fa-map-o"></i> ABRIR RUTA EN MAPS
                            </a>
                        <?php endif; ?>

                        <div class="card-info-row">
                            <i class="fa fa-arrow-circle-left"></i> 
                            <span style="font-size: 11px; <?= empty($pasajero->origen) ? 'color:#EF4444; font-weight:bold;' : '' ?>">
                                Origen: <?= ($pasajero && !empty($pasajero->origen)) ? $pasajero->origen : 'SIN ASIGNAR' ?>
                            </span>
                        </div>
                        <div class="card-info-row">
                            <i class="fa fa-arrow-circle-right"></i> 
                            <span style="font-size: 11px; <?= empty($pasajero->destino) ? 'color:#EF4444; font-weight:bold;' : '' ?>">
                                Destino: <?= ($pasajero && !empty($pasajero->destino)) ? $pasajero->destino : 'SIN ASIGNAR' ?>
                            </span>
                        </div>

                        <div class="card-driver-info">
                            <div class="driver-avatar">
                                <i class="fa <?= $conductor ? 'fa-user' : 'fa-user-secret' ?>"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-size: 11px; font-weight: 800; color: #1E293B;">
                                    <?= $conductor ? mb_strtoupper($conductor->nombres . ' ' . $conductor->apellidos) : 'CHOFER POR ASIGNAR' ?>
                                </div>
                                <?php if ($vehiculo): ?>
                                    <div style="font-size: 9px; color: #EA4C2D; font-weight: 700;">
                                        <i class="fa fa-bus"></i> <?= $vehiculo->placa ?> | <?= $vehiculo->nombre_marca ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div style="margin-top: 15px; display: flex; gap: 5px; flex-wrap: wrap;">
                            <?= Html::a('<i class="fa fa-eye"></i>', ['view', 'id' => $model->id_servicio], ['class' => 'btn btn-default btn-sm', 'style' => 'border-radius:10px; font-weight:700; padding: 5px 12px;']) ?>
                            
                            <?php if ($cli && $cli->telefono_principal): ?>
                                <?= Html::a('<i class="fa fa-whatsapp"></i>', "https://api.whatsapp.com/send?phone=" . preg_replace('/[^0-9]/', '', $cli->telefono_principal), [
                                    'class' => 'btn btn-success btn-sm', 
                                    'target' => '_blank',
                                    'style' => 'border-radius:10px; background:#25D366; border:none; color:white; padding: 5px 12px;'
                                ]) ?>
                            <?php endif; ?>

                            <?php if (!$esConfirmado && !$esPagoTotalStatus): ?>
                                <?= Html::a('<i class="fa fa-check"></i>', ['confirmar', 'id' => $model->id_servicio], [
                                    'class' => 'btn btn-warning btn-sm',
                                    'style' => 'border-radius:10px; background:#F59E0B; border:none; color:white; padding: 5px 12px;',
                                    'data' => ['confirm' => '¿Confirmar servicio?', 'method' => 'post'],
                                ]) ?>
                            <?php endif; ?>

                            <?= Html::a('<i class="fa fa-money"></i>', ['pagar', 'id' => $model->id_servicio], ['class' => 'btn btn-success btn-sm', 'style' => 'border-radius:10px; background:#10B981; border:none; color:white; padding: 5px 12px;']) ?>
                            <?= Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id_servicio], ['class' => 'btn btn-info btn-sm', 'style' => 'border-radius:10px; background:#3B82F6; border:none; color:white; padding: 5px 12px;']) ?>
                            
                            <?= Html::a('<i class="fa fa-user-plus"></i>', ['agendar', 'id' => $model->id_servicio], [
                                'class' => 'btn btn-primary btn-sm', 
                                'style' => 'border-radius:10px; background:' . ($conductor ? '#0369A1' : '#6366F1') . '; border:none; color:white; padding: 5px 12px;',
                                'title' => $conductor ? 'Cambiar Asignación' : 'Asignar Chofer'
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="calendar"></div>
</div>