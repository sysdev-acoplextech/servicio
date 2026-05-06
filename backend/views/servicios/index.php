<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\Cliente;
use backend\models\FormaPago;
use backend\models\PasajeroServicio;
use backend\models\BaseTipoVehiculo;

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
        transition: transform 0.2s; position: relative;
    }
    .card-servicio:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0,0,0,0.05); }
    
    /* Tags de Estatus (Derecha) */
    .card-tag { 
        position: absolute; top: 15px; right: 15px; padding: 4px 12px; 
        border-radius: 8px; font-size: 10px; font-weight: 800; text-transform: uppercase;
    }
    .tag-confirmado { background: #DCFCE7; color: #166534; }
    .tag-pendiente { background: #FEF3C7; color: #92400E; }

    /* Tags de Pago (Izquierda) */
    .pay-tag {
        position: absolute; top: 15px; left: 15px; padding: 4px 10px; 
        border-radius: 8px; font-size: 9px; font-weight: 800; text-transform: uppercase;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .pay-total { background: #10B981; color: white; }
    .pay-parcial { background: #3B82F6; color: white; }
    .pay-deuda { background: #EF4444; color: white; }

    .card-header-s { padding: 35px 20px 15px 20px; border-bottom: 1px solid #F1F5F9; }
    .card-client { font-size: 16px; font-weight: 800; color: #1E293B; display: block; }
    .card-id { color: #EA4C2D; font-weight: 900; font-size: 12px; }

    .card-body-s { padding: 20px; }
    .card-info-row { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; color: #475569; font-size: 13px; }
    .card-info-row i { color: #EA4C2D; width: 15px; }

    #calendar { background: #fff; padding: 20px; border-radius: 20px; border: 1px solid #E2E8F0; }
    .btn-filter-dropdown {
        border-radius: 15px; padding: 10px 20px; font-weight: bold; 
        background: #F1F5F9; border: 1px solid #E2E8F0; color: #64748B;
    }
    .btn-filter-dropdown:hover { background: #E2E8F0; }
    .dropdown-menu { border-radius: 15px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1); padding: 10px; }
    .dropdown-menu > li > a { border-radius: 8px; padding: 8px 20px; font-weight: 600; }
");

$this->registerJs("
    $('.btn-view').click(function() {
        const view = $(this).data('view');
        $('.btn-view').removeClass('active');
        $(this).addClass('active');
        $('.view-content').hide();
        $('#view-' + view).fadeIn();
        if(view === 'calendar') { calendar.render(); }
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

                <div class="dropdown" style="display: inline-block; margin-right: 5px;">
                    <button class="btn btn-default dropdown-toggle btn-filter-dropdown" type="button" data-toggle="dropdown">
                        <i class="fa fa-filter"></i> Filtrar <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-header">ESTATUS</li>
                        <li><?= Html::a('Todos los servicios', ['index']) ?></li>
                        <li class="divider"></li>
                        <li><?= Html::a('⭐ Hoy', ['index', 'ServiciosSearch[fecha_servicio]' => date('Y-m-d')]) ?></li>
                        <li><?= Html::a('⏳ Agendados', ['index', 'ServiciosSearch[id_estatus]' => 5]) ?></li>
                        <li><?= Html::a('✅ Confirmados', ['index', 'ServiciosSearch[id_estatus]' => 11]) ?></li>
                        <li><?= Html::a('🔄 En Proceso', ['index', 'ServiciosSearch[id_estatus]' => 9]) ?></li>
                        <li class="dropdown-header">ESTATUS DE PAGO</li>
                        <li><?= Html::a('💰 Pagados Total', ['index', 'ServiciosSearch[id_estatus]' => 7]) ?></li>
                        <li><?= Html::a('💸 Con Deuda', ['index', 'ServiciosSearch[id_estatus]' => 6]) ?></li>
                    </ul>
                </div>
                <?= Html::a('<i class="fa fa-calculator"></i> CÁLCULO RÁPIDO', ['cotizacion-rapida/create'], [
                    'class' => 'btn btn-info',
                    'style' => 'border-radius:15px; padding: 10px 20px; font-weight:bold; background: #3B82F6; border:none; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);'
                ]) ?>
                <?= Html::a('<i class="fa fa-plus"></i> NUEVO SERVICIO', ['create'], [
                    'class' => 'btn btn-success',
                    'style' => 'border-radius:15px; padding: 10px 25px; font-weight:bold; background: #10B981; border:none;'
                ]) ?>
            </div>
        </div>
    </div>

    <!-- VISTA TARJETAS -->
    <div id="view-grid" class="view-content">
        <div class="grid-servicios">
            <?php foreach ($dataProvider->getModels() as $model): 
                $cli = Cliente::findOne($model->id_cliente);
                $fp = FormaPago::findOne($model->id_forma_pago);
                
                // --- DEFINICIÓN DE ESTATUS ---
                $esConfirmado = ($model->id_estatus == 11); 
                $esPagoTotalStatus = ($model->id_estatus == 7);
                $pasajero = PasajeroServicio::find()->where(['id_servicio' => $model->id_servicio])->one();

                // --- LÓGICA DE ETIQUETAS DE PAGO ---
                $payTagHtml = '';
                $faltante = $model->faltante;
                $montoTotal = $model->monto;

                if ($esPagoTotalStatus) {
                    // PRIORIDAD: Si el estatus es 7, es Pago Total sí o sí
                    $payTagHtml = '<div class="pay-tag pay-total"><i class="fa fa-check"></i> Pago Total</div>';
                } else {
                    // Lógica para el resto de los estatus
                    if ($model->id_forma_pago == 2) {
                        // Transferencia / Pago Móvil
                        if ($faltante <= 0 && !is_null($faltante)) {
                            $payTagHtml = '<div class="pay-tag pay-total"><i class="fa fa-check"></i> Pago Total</div>';
                        } else {
                            $payTagHtml = '<div class="pay-tag pay-deuda"><i class="fa fa-warning"></i> Pago Parcial</div>';
                        }
                    } elseif ($model->id_forma_pago == 4) {
                        // Efectivo
                        $payTagHtml = '<div class="pay-tag pay-parcial" style="background:#f39c12;"><i class="fa fa-money"></i> Pago en Servicio</div>';
                    } elseif ($model->id_forma_pago == 3) {
                        // Crédito
                        $payTagHtml = '<div class="pay-tag" style="background:#95a5a6; color:white;"><i class="fa fa-university"></i> Crédito</div>';
                    } else {
                        if ($faltante <= 0 && !is_null($faltante)) {
                            $payTagHtml = '<div class="pay-tag pay-total"><i class="fa fa-check"></i> Pago Total</div>';
                        } else {
                            $payTagHtml = '<div class="pay-tag pay-deuda"><i class="fa fa-hourglass-start"></i> Esperando Pago</div>';
                        }
                    }
                }
            ?>
                <div class="card-servicio">
                    <!-- Estatus de Pago (Izquierda) -->
                    <?= $payTagHtml ?>

                    <!-- Estatus de Servicio (Derecha) -->
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

                        <div style="display: flex; justify-content: space-between; gap: 10px; margin-bottom: 8px;">
                            <div class="card-info-row" style="margin-bottom: 0; flex: 1;">
                                <i class="fa fa-money"></i> 
                                <span style="font-size: 0.9em;">Pago: <?= $fp ? $fp->descripcion : 'N/A' ?></span>
                            </div>
                            <div class="card-info-row" style="margin-bottom: 0; flex: 1; border-left: 1px solid #eee; padding-left: 10px;">
                                <i class="fa fa-car"></i> 
                                <span style="font-size: 0.9em;">
                                    Vehículo: 
                                    <?php 
                                    $tipoVehiculo = BaseTipoVehiculo::findOne($model->id_tipo_vehiculo);
                                    echo $tipoVehiculo ? $tipoVehiculo->nombre_tipo_vehiculo : 'N/A';
                                    ?>
                                </span>
                            </div>
                        </div>

                        <?php if ($pasajero && !empty($pasajero->google_map)): 
                            $query = trim($pasajero->google_map);
                            $urlMaps = "https://www.google.com/maps/search/?api=1&query=" . rawurlencode($query);
                        ?>
                            <a href="<?= $urlMaps ?>" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="btn btn-xs" 
                            style="display: block; width: 100%; margin-bottom: 15px; background: #0EA5E9; color: white; font-weight: 800; font-size: 10px; border-radius: 20px; border: none; padding: 8px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                            <i class="fa fa-map-o"></i> ABRIR RUTA EN MAPS
                            </a>
                        <?php endif; ?>

                        <div class="card-info-row">
                            <i class="fa fa-arrow-circle-left "></i> 
                            <span>Origen: <?= $pasajero ? $pasajero->origen : 'N/A' ?></span>
                        </div>
                        <div class="card-info-row">
                            <i class="fa fa-arrow-circle-right "></i> 
                            <span>Destino: <?= $pasajero ? $pasajero->destino : 'N/A' ?></span>
                        </div>
                        
                        <!-- Barra de progreso visual -->
                        <?php if (($esConfirmado || $esPagoTotalStatus) && $model->id_forma_pago != 3 && $montoTotal > 0): 
                            $porcentaje = $esPagoTotalStatus ? 100 : ((($montoTotal - $faltante) / $montoTotal) * 100);
                        ?>
                        <div class="progress" style="height: 4px; margin-top: 10px; margin-bottom: 10px; background: #eee; border-radius: 2px;">
                            <div class="progress-bar" style="width: <?= $porcentaje ?>%; background: #00a65a;"></div>
                        </div>
                        <?php endif; ?>

                        <div style="margin-top: 15px; display: flex; gap: 8px;">
                            <?= Html::a('Ver Detalles', ['view', 'id' => $model->id_servicio], [
                                'class' => 'btn btn-default btn-sm', 
                                'style' => 'border-radius:10px; flex:1; font-weight:700;'
                            ]) ?>

                            <?= Html::a('<i class="fa fa-money"></i>', ['pagar', 'id' => $model->id_servicio], [
                                'class' => 'btn btn-success btn-sm', 
                                'title' => 'Registrar Pago',
                                'style' => 'border-radius:10px; background:#10B981; border:none; color:white; padding: 5px 12px;'
                            ]) ?>

                            <?= Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id_servicio], [
                                'class' => 'btn btn-info btn-sm', 
                                'title' => 'Editar Servicio',
                                'style' => 'border-radius:10px; background:#3B82F6; border:none; color:white; padding: 5px 12px;'
                            ]) ?>

                            <?= Html::a('<i class="fa fa-user-plus"></i>', ['agendar', 'id' => $model->id_servicio], [
                                'class' => 'btn btn-primary btn-sm',
                                'title' => 'Agregar Conductor',
                                'style' => 'border-radius:10px; background:#6366F1; border:none; color:white; padding: 5px 12px;'
                            ]) ?>

                            <?= Html::a('<i class="fa fa-whatsapp"></i>', ['view', 'id' => $model->id_servicio], [
                                'class' => 'btn btn-success btn-sm', 
                                'style' => 'border-radius:10px; background:#25D366; border:none;'
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- VISTA LISTA -->
    <div id="view-list" class="view-content" style="display: none;">
        <div class="control-panel" style="padding: 0; overflow: hidden;">
            <table class="table" style="margin-bottom: 0;">
                <thead style="background: #F8FAFC;">
                    <tr style="color: #64748B; font-size: 11px; text-transform: uppercase;">
                        <th class="text-center">ID</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Forma de Pago</th>
                        <th class="text-right">Monto</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataProvider->getModels() as $model): ?>
                        <tr>
                            <td class="text-center"><b>#<?= $model->id_servicio ?></b></td>
                            <td><b><?= Cliente::findOne($model->id_cliente)->nombre_apellido ?? 'N/A' ?></b></td>
                            <td><?= Yii::$app->formatter->asDate($model->fecha_servicio, 'medium') ?></td>
                            <td><?= FormaPago::findOne($model->id_forma_pago)->descripcion ?? 'N/A' ?></td>
                            <td class="text-right"><b>$ <?= number_format($model->monto, 2, ',', '.') ?></b></td>
                            <td class="text-right">
                                <?= Html::a('<i class="fa fa-eye"></i>', ['view', 'id' => $model->id_servicio], ['class' => 'btn btn-xs btn-default', 'style' => 'border-radius:8px;']) ?>
                                <?= Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id_servicio], ['class' => 'btn btn-xs btn-info', 'style' => 'border-radius:8px; margin-left:5px;']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="view-calendar" class="view-content" style="display: none;">
        <div id="calendar"></div>
    </div>

</div>