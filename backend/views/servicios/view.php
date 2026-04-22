<?php
use backend\models\Cliente;
use backend\models\Pasajero;
use backend\models\PasajeroServicio;
use backend\models\FormaPago; // Asegúrate de tener este modelo
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model backend\models\Servicios */

$cli = Cliente::findOne($model->id_cliente);
$nombreCliente = mb_strtoupper($cli ? $cli->nombre_apellido : 'CONSORCIO RAGNAR');
$paxs = PasajeroServicio::find()->where(['id_servicio' => $model->id_servicio])->all();

// Lógica para la forma de pago vinculada a la tabla
$fp = FormaPago::findOne($model->id_forma_pago);
$formaPagoDesc = $fp ? mb_strtoupper($fp->descripcion) : 'POR DEFINIR';

// Determinamos color del badge de pago basado en palabras clave
$esCredito = (stripos($formaPagoDesc, 'CREDITO') !== false || stripos($formaPagoDesc, 'PREPAGO') !== false);
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<div class="servicio-voucher-container">

    <div class="row no-print" style="margin-bottom: 20px; padding: 20px;">
        <div class="col-xs-12 text-right">
            <?= Html::a('<i class="fa fa-arrow-left"></i> Regresar', ['index'], ['class' => 'btn btn-default btn-flat', 'style' => 'border-radius:25px;']) ?>
            
            <button type="button" onclick="descargarVoucher()" class="btn btn-success btn-flat" style="border-radius:25px; background-color:#25D366; border:none; font-weight:bold; padding: 10px 20px; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);">
                <i class="fa fa-whatsapp"></i> Descargar para WhatsApp
            </button>
        </div>
    </div>

    <div id="voucher-area" class="voucher-modern-card">
        
        <div class="v-header">
            <img src="<?= Url::to('@web/img/CH_LOGO.png', true) ?>" class="v-logo">
            <div class="v-title-box">
                <span class="v-tag">VOUCHER DE TRASLADO</span>
                <span class="v-id">#<?= $model->id_servicio ?></span>
            </div>
        </div>

        <div class="v-top-content">
            <div class="v-info-group">
                <label class="v-label">CLIENTE / EMPRESA</label>
                <p class="v-client-name"><?= $nombreCliente ?></p>
            </div>
            
            <div class="v-info-group text-right">
                <label class="v-label">FORMA DE PAGO</label>
                <div class="payment-badge <?= $esCredito ? 'pago-pre' : 'pago-sitio' ?>">
                    <i class="fa <?= $esCredito ? 'fa-check-circle' : 'fa-money' ?>"></i>
                    <?= $formaPagoDesc ?>
                </div>
            </div>
        </div>

        <div class="v-date-bar">
            <i class="fa fa-calendar-check-o"></i> 
            <span><?= mb_strtoupper(Yii::$app->formatter->asDate($model->fecha_servicio, 'php:l d/m/Y')) ?></span>
        </div>

        <div class="v-body">
            <?php foreach ($paxs as $index => $p): 
                $p_info = Pasajero::findOne($p->id_pasajero);
            ?>
                <div class="pax-item">
                    <div class="pax-badge">
                        <span>Ruta <?= $index + 1 ?></span>
                        <span class="v-time"><i class="fa fa-clock-o"></i> <?= date('h:i A', strtotime($p->hora)) ?></span>
                    </div>
                    
                    <div class="pax-content">
                        <p class="pax-main-name">
                            <i class="fa fa-user-circle"></i> <?= $p_info ? mb_strtoupper($p_info->nombre_apellido) : 'N/A' ?>
                        </p>
                        
                        <div class="v-path">
                            <div class="path-node">
                                <div class="node-dot start"></div>
                                <div class="node-data">
                                    <label>ORIGEN:</label>
                                    <p><?= mb_strtoupper($p->origen) ?></p>
                                </div>
                            </div>
                            <div class="path-line"></div>
                            <div class="path-node">
                                <div class="node-dot end"></div>
                                <div class="node-data">
                                    <label>DESTINO:</label>
                                    <p><?= mb_strtoupper($p->destino) ?></p>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($p->google_map)): ?>
                        <div class="v-maps-box">
                            <div class="maps-icon"><i class="fa fa-map-marker"></i></div>
                            <div class="maps-info">
                                <label>LINK / DIRECCIÓN GOOGLE MAPS:</label>
                                <p><?= $p->google_map ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="v-footer">
            <p>CH GROUP TRASLADOS • SERVICIO EJECUTIVO</p>
            <p style="font-size: 9px; opacity: 0.5; margin-top: 5px;">GENERADO EL <?= date('d/m/Y H:i') ?></p>
        </div>
    </div>
</div>

<script>
function descargarVoucher() {
    const element = document.getElementById('voucher-area');
    html2canvas(element, {
        scale: 3, // Alta calidad
        useCORS: true,
        backgroundColor: "#FFFFFF"
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'Voucher_<?= $model->id_servicio ?>.png';
        link.href = canvas.toDataURL("image/png");
        link.click();
    });
}
</script>

<style>
    .voucher-modern-card {
        width: 650px;
        margin: 0 auto;
        background: #FFFFFF;
        font-family: 'Segoe UI', Tahoma, sans-serif;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }

    .v-header { background: #1B242D; padding: 25px 35px; display: flex; justify-content: space-between; align-items: center; }
    .v-logo { height: 45px; }
    .v-tag { color: #EA4C2D; font-weight: 800; font-size: 10px; letter-spacing: 2px; display: block; text-align: right; }
    .v-id { color: #FFF; font-size: 32px; font-weight: 900; line-height: 1; }

    .v-top-content { padding: 25px 35px; background: #F8FAFC; display: flex; justify-content: space-between; align-items: center; }
    .v-label { font-size: 10px; color: #64748B; font-weight: 800; letter-spacing: 0.5px; margin-bottom: 5px; display: block; }
    .v-client-name { font-size: 19px; font-weight: 800; color: #1E293B; margin: 0; }
    
    .payment-badge { padding: 6px 14px; border-radius: 8px; font-size: 11px; font-weight: 800; display: inline-flex; align-items: center; gap: 8px; }
    .pago-pre { background: #DCFCE7; color: #166534; }
    .pago-sitio { background: #FEF3C7; color: #92400E; }

    .v-date-bar { background: #1E293B; color: #FFF; padding: 12px 35px; font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 10px; }
    .v-date-bar i { color: #EA4C2D; }

    .v-body { padding: 25px 35px; }
    .pax-item { margin-bottom: 25px; border-radius: 18px; border: 1px solid #E2E8F0; overflow: hidden; }
    .pax-badge { background: #F1F5F9; padding: 10px 20px; font-size: 11px; font-weight: 800; display: flex; justify-content: space-between; }
    .v-time { color: #EA4C2D; font-size: 13px; }
    
    .pax-content { padding: 20px; }
    .pax-main-name { font-size: 18px; font-weight: 800; color: #1E293B; margin-bottom: 15px; }

    /* RUTA */
    .v-path { position: relative; padding-left: 10px; margin-bottom: 20px; }
    .path-line { position: absolute; left: 15px; top: 15px; bottom: 15px; width: 1px; border-left: 2px dashed #CBD5E1; }
    .path-node { position: relative; padding-left: 30px; margin-bottom: 12px; }
    .node-dot { position: absolute; left: 0px; top: 4px; width: 12px; height: 12px; border-radius: 50%; background: #FFF; border: 3px solid; z-index: 2; }
    .node-dot.start { border-color: #3B82F6; }
    .node-dot.end { border-color: #10B981; }
    .node-data p { font-size: 13px; font-weight: 600; color: #475569; margin: 0; }

    /* CAJA DE GOOGLE MAPS DENTRO DEL PASAJERO */
    .v-maps-box { 
        background: #F8FAFC; 
        border: 1px solid #EA4C2D; 
        border-radius: 12px; 
        padding: 12px; 
        display: flex; 
        gap: 12px; 
        align-items: center;
    }
    .maps-icon { color: #EA4C2D; font-size: 20px; }
    .maps-info p { font-size: 11px; color: #1E293B; font-weight: 700; margin: 0; word-break: break-all; }

    .v-footer { background: #1B242D; padding: 20px; text-align: center; color: #94A3B8; font-size: 11px; font-weight: 700; }
    
    @media print { .no-print { display: none; } }
</style>