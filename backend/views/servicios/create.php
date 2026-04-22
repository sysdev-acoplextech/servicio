<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

$this->title = 'Gestión de Servicios';

$this->registerCss("
    .service-wrapper { display: flex; gap: 20px; padding: 15px; background: #f4f7f6; }
    .form-container { flex: 3; background: white; border-radius: 15px; padding: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .summary-sticky { flex: 1; }
    .card-total { 
        position: sticky; top: 20px; background: #2c3e50; color: white; 
        border-radius: 15px; padding: 25px; border-left: 5px solid #2ecc71;
    }
    .total-big { font-size: 28pt; font-weight: bold; color: #2ecc71; margin: 10px 0; border-top: 1px solid #34495e; padding-top: 10px; }
    .detail-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 13px; color: #bdc3c7; }
    .detail-row b { color: white; font-size: 14px; }
    
    /* Tabs personalizadas */
    .nav-tabs-custom .nav-tabs { border-bottom: 2px solid #ecf0f1; margin-bottom: 20px; }
    .nav-tabs-custom .nav-tabs > li > a { border-radius: 10px 10px 0 0; font-weight: bold; color: #7f8c8d; }
    .nav-tabs-custom .nav-tabs > li.active > a { border-top: 3px solid #3498db; color: #2c3e50 !important; }
    
    #lbl-base, #lbl-recargo, #lbl-viatico, #lbl-extras, #lbl-total { transition: all 0.3s ease; }
");
?>

<div class="service-wrapper">
    <div class="form-container nav-tabs-custom">
        <?php $form = ActiveForm::begin(['id' => 'servicio-form']); ?>
        
        <?= Tabs::widget([
            'items' => [
                [
                    'label' => '<i class="fa fa-car"></i> 1. Datos del Servicio',
                    'content' => $this->render('_step1', ['form' => $form, 'model' => $model]),
                    'active' => true,
                    'encode' => false,
                ],
                [
                    'label' => '<i class="fa fa-users"></i> 2. Pasajeros',
                    'content' => $this->render('_step2', ['form' => $form, 'model' => $model]),
                    'encode' => false,
                ],
                [
                    'label' => '<i class="fa fa-plus-circle"></i> 3. Variables y Pago',
                    'content' => $this->render('_step3', ['form' => $form, 'model' => $model]),
                    'encode' => false,
                ],
            ],
        ]); ?>

        <div class="form-group" style="margin-top: 25px; text-align: right;">
            <?= Html::submitButton('<i class="fa fa-save"></i> GUARDAR SERVICIO', [
                'class' => 'btn btn-primary', 
                'style' => 'border-radius: 20px; padding: 12px 40px; font-weight: bold;'
            ]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="summary-sticky">
        <div class="card-total">
            <h4 style="margin-top: 0; font-size: 14px; color: #95a5a6; letter-spacing: 1px;">RESUMEN DE MONTOS</h4>
            
            <div class="detail-row">
                <span>Monto Base:</span> 
                <b id="lbl-base">0,00</b>
            </div>
            
            <div class="detail-row">
                <span>Recargo Horario:</span> 
                <b id="lbl-recargo" style="color: #e74c3c;">0,00</b>
            </div>

            <div class="detail-row">
                <span>Viáticos:</span> 
                <b id="lbl-viatico">0,00</b>
            </div>
            
            <div class="detail-row">
                <span>Adicionales:</span> 
                <b id="lbl-extras">0,00</b>
            </div>
            
            <div class="total-big">
                <small style="font-size: 14pt;">$</small> <span id="lbl-total">0,00</span>
            </div>
            
            <hr style="border-color: #34495e; margin: 15px 0;">
            <small style="color: #7f8c8d; font-style: italic; display: block; line-height: 1.2;">
                * Los montos se actualizan en tiempo real según sus selecciones.
            </small>
        </div>
    </div>
</div>

<?php
$this->registerJs("
// 1. LECTURA: Maneja puntos de miles y coma decimal
function getFloatValue(selector) {
    var val = $(selector).val() || '0';
    var cleanVal = val.toString().replace(/\./g, '').replace(',', '.');
    return parseFloat(cleanVal) || 0;
}

// 2. FORMATO: Devuelve 1.000,00
function formatNumber(num) {
    return num.toLocaleString('de-DE', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

// 3. FUNCIÓN MAESTRA
function updateLiveSummary() {
    var base = getFloatValue('#monto-base');
    var recargo = getFloatValue('#monto-recargo');
    var viatico = getFloatValue('#monto-viatico');
    
    var adicionales = 0;
    $('.adicional-card.active').each(function() {
        adicionales += parseFloat($(this).data('monto')) || 0;
    });
    
    var total = base + recargo + viatico + adicionales;

    // Actualizar Labels del card derecho
    $('#lbl-base').text(formatNumber(base));
    $('#lbl-recargo').text(formatNumber(recargo));
    $('#lbl-viatico').text(formatNumber(viatico));
    $('#lbl-extras').text(formatNumber(adicionales));
    $('#lbl-total').text(formatNumber(total));

    // Sincronizar con el input real oculto del Step 3
    var totalFormatted = formatNumber(total);
    if($('#monto-total-final').val() !== totalFormatted) {
        $('#monto-total-final').val(totalFormatted);
    }
}

// --- ESCUCHADORES ACTIVOS ---

// Detectar cambios manuales
$(document).on('keyup change blur input', '#monto-base, #monto-recargo, #monto-viatico', function() {
    updateLiveSummary();
});

// Detectar cambios por JavaScript (Como cuando Step3 pone el precio de la ruta)
var originalVal = $.fn.val;
$.fn.val = function(value) {
    var res = originalVal.apply(this, arguments);
    if (arguments.length > 0 && (this.is('#monto-base') || this.is('#monto-recargo') || this.is('#monto-viatico'))) {
        updateLiveSummary();
    }
    return res;
};

// Detectar selección de Adicionales
$(document).on('click', '.adicional-card', function() {
    setTimeout(updateLiveSummary, 50);
});

// Inicio
$(document).ready(function() {
    updateLiveSummary();
});
");
?>