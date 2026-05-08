<?php
use backend\models\Pasajero;
use backend\models\PasajeroServicio;
use backend\models\Conductor;
use backend\models\VFlota;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model backend\models\Servicios */

$paxs = PasajeroServicio::find()->where(['id_servicio' => $model->id_servicio])->all();

// Datos del Conductor y Vehículo según tu tabla 'conductor'
$conductor = !empty($model->id_conductor) ? Conductor::findOne($model->id_conductor) : null;
$vehiculo = !empty($model->id_flota) ? VFlota::findOne(['id_flota' => $model->id_flota]) : null;

// Preparación de texto para WhatsApp
$textoWhatsapp = "🚐 *HOJA DE RUTA - CH GROUP*\n";
$textoWhatsapp .= "📅 " . mb_strtoupper(Yii::$app->formatter->asDate($model->fecha_servicio, 'php:l d/m/Y')) . "\n\n";

foreach ($paxs as $idx => $p) {
    $p_info = Pasajero::findOne($p->id_pasajero);
    $n = $idx + 1;
    $textoWhatsapp .= "*RUTA {$n}* - {$p->hora}\n";
    $textoWhatsapp .= "👤 {$p_info->nombre_apellido}\n";
    $textoWhatsapp .= "📍 Origen: {$p->origen}\n";
    $textoWhatsapp .= "🏁 Destino: {$p->destino}\n\n";
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<div class="servicio-voucher-container">

    <div class="row no-print" style="margin-bottom: 20px; padding: 20px; display: flex; justify-content: flex-end; gap: 10px;">
        <?= Html::a('<i class="fa fa-arrow-left"></i> Regresar', ['index'], ['class' => 'btn btn-default btn-flat', 'style' => 'border-radius:25px;']) ?>
        
        <button type="button" onclick="descargarVoucher()" class="btn btn-info btn-flat" style="border-radius:25px; font-weight:bold; padding: 10px 20px;">
            <i class="fa fa-download"></i> 1. Descargar Ficha
        </button>

        <?php if ($conductor): 
            $tel = preg_replace('/[^0-9]/', '', $conductor->telefono_principal); 
            if ($tel): ?>
            <a href="https://api.whatsapp.com/send?phone=<?= $tel ?>&text=<?= urlencode($textoWhatsapp) ?>" 
               target="_blank" 
               class="btn btn-success btn-flat" 
               style="border-radius:25px; background-color:#25D366; border:none; font-weight:bold; padding: 10px 20px; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);">
                <i class="fa fa-whatsapp"></i> 2. Enviar al Conductor
            </a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div id="voucher-area" class="voucher-premium-card">
        
        <div class="v-header-modern">
            <div class="v-logo-box">
                <img src="<?= Url::to('@web/img/CH_LOGO.png', true) ?>" class="v-logo-img">
            </div>
            <div class="v-title-box">
                <div class="v-main-tag">ORDEN DE SERVICIO OPERATIVA</div>
                <div class="v-date-tag"><?= mb_strtoupper(Yii::$app->formatter->asDate($model->fecha_servicio, 'php:l d/m/Y')) ?></div>
            </div>
            <div class="v-id-box">
                #<?= $model->id_servicio ?>
            </div>
        </div>

        <div class="v-driver-premium">
            <div class="v-driver-cell">
                <label>CONDUCTOR</label>
                <span><?= $conductor ? mb_strtoupper($conductor->nombres . ' ' . $conductor->apellidos) : 'PENDIENTE' ?></span>
            </div>
            <div class="v-driver-cell">
                <label>TELÉFONO</label>
                <span><?= $conductor ? $conductor->telefono_principal : '---' ?></span>
            </div>
            <div class="v-driver-cell">
                <label>VEHÍCULO / PLACA</label>
                <span><?= $vehiculo ? mb_strtoupper($vehiculo->nombre_marca . " [" . $vehiculo->placa . "]") : '---' ?></span>
            </div>
        </div>

        <div class="v-body-table">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">RT</th>
                        <th style="width: 180px;">PASAJERO</th>
                        <th style="width: 90px; text-align: center;">HORA</th>
                        <th style="width: 280px;">ORIGEN</th>
                        <th style="width: 280px;">DESTINO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($paxs as $index => $p): 
                        $p_info = Pasajero::findOne($p->id_pasajero);
                    ?>
                    <tr>
                        <td class="text-center bold-orange"><?= $index + 1 ?></td>
                        <td class="bold-dark">
                            <?= $p_info ? mb_strtoupper($p_info->nombre_apellido) : 'N/A' ?>
                            <div style="font-size: 10px; color: #64748B; margin-top: 3px;">
                                <i class="fa fa-phone"></i> <?= $p_info->telefono ?? 'S/N' ?>
                            </div>
                        </td>
                        <td class="text-center bold-dark" style="font-size: 14px;">
                            <?= date('h:i A', strtotime($p->hora)) ?>
                        </td>
                        <td class="cell-location">
                            <i class="fa fa-map-marker text-blue"></i> <?= mb_strtoupper($p->origen) ?>
                            <?php if(!empty($p->referencia_origen)): ?>
                                <div class="loc-ref"><?= mb_strtoupper($p->referencia_origen) ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="cell-location">
                            <i class="fa fa-flag-checkered text-green"></i> <?= mb_strtoupper($p->destino) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="v-bottom-section">
            <?php if (!empty($model->observaciones)): ?>
                <div class="v-obs-premium">
                    <label>OBSERVACIONES DEL SERVICIO:</label>
                    <p><?= mb_strtoupper($model->observaciones) ?></p>
                </div>
            <?php endif; ?>

            <div class="v-footer-premium">
                CH GROUP TRASLADOS • SERVICIO EJECUTIVO • GENERADO: <?= date('d/m/Y H:i') ?>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estructura Base - Recta */
    .voucher-premium-card {
        width: 1100px; /* Un poco más ancho para las columnas separadas */
        margin: 0 auto;
        background: #FFFFFF;
        border: 4px solid #1B242D;
        font-family: 'Segoe UI', Tahoma, sans-serif;
    }

    /* Header */
    .v-header-modern { display: flex; align-items: center; background: #FFFFFF; padding: 20px 30px; border-bottom: 2px solid #1B242D; }
    .v-logo-img { height: 60px; }
    .v-title-box { flex-grow: 1; padding-left: 25px; border-left: 2px solid #EEE; margin-left: 25px; }
    .v-main-tag { font-size: 13px; font-weight: 800; color: #EA4C2D; letter-spacing: 2px; }
    .v-date-tag { font-size: 20px; font-weight: 900; color: #1B242D; }
    .v-id-box { background: #1B242D; color: #FFF; padding: 8px 20px; font-size: 22px; font-weight: 900; }

    /* Barra Conductor */
    .v-driver-premium { display: grid; grid-template-columns: 1.2fr 0.8fr 1fr; background: #1B242D; color: #FFF; }
    .v-driver-cell { padding: 12px 25px; border-right: 1px solid #334155; }
    .v-driver-cell:last-child { border-right: none; }
    .v-driver-cell label { display: block; font-size: 9px; color: #EA4C2D; font-weight: 800; margin-bottom: 2px; }
    .v-driver-cell span { font-size: 14px; font-weight: 700; }

    /* Tabla */
    .table-premium { width: 100%; border-collapse: collapse; }
    .table-premium th {
        background: #F1F5F9;
        color: #1B242D;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 12px 15px;
        border-bottom: 2px solid #1B242D;
        border-right: 1px solid #CBD5E1;
        text-align: left;
    }
    .table-premium td {
        padding: 12px 15px;
        border-bottom: 1px solid #E2E8F0;
        border-right: 1px solid #F1F5F9;
        font-size: 12px;
        vertical-align: top;
    }
    .table-premium th:last-child, .table-premium td:last-child { border-right: none; }

    .bold-orange { color: #EA4C2D; font-weight: 900; font-size: 15px; }
    .bold-dark { color: #1B242D; font-weight: 800; }
    .text-center { text-align: center; }
    
    /* Ubicaciones */
    .cell-location { font-weight: 700; color: #1B242D; line-height: 1.3; }
    .text-blue { color: #3B82F6; margin-right: 4px; }
    .text-green { color: #10B981; margin-right: 4px; }
    .loc-ref { font-size: 10px; color: #64748B; font-weight: 400; margin-top: 4px; border-top: 1px solid #EEE; padding-top: 2px; }

    /* Footer */
    .v-bottom-section { border-top: 2px solid #1B242D; }
    .v-obs-premium { padding: 15px 25px; background: #FFF; border-bottom: 1px solid #E2E8F0; }
    .v-obs-premium label { font-size: 10px; font-weight: 900; color: #EA4C2D; display: block; margin-bottom: 4px; }
    .v-obs-premium p { font-size: 12px; font-weight: 700; color: #1B242D; margin: 0; }

    .v-footer-premium { padding: 12px; text-align: center; background: #1B242D; color: #94A3B8; font-size: 10px; font-weight: 700; }

    @media print { .no-print { display: none; } }
</style>

<script>
function descargarVoucher() {
    const element = document.getElementById('voucher-area');
    html2canvas(element, { 
        scale: 2.5, 
        useCORS: true,
        backgroundColor: "#FFFFFF"
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'FichaOperativa_<?= $model->id_servicio ?>.png';
        link.href = canvas.toDataURL("image/png");
        link.click();
    });
}
</script>