<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCss("
    .master-container { display: flex; gap: 20px; padding: 20px; background: #f0f2f5; }
    .main-form-card { flex: 3; background: white; border-radius: 15px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .sticky-panel { flex: 1; }
    .section-header { 
        background: #f8fafc; padding: 10px 15px; border-left: 4px solid #3498db; 
        margin-bottom: 20px; font-weight: bold; color: #2c3e50; text-transform: uppercase; font-size: 12px;
    }
    .form-section { margin-bottom: 30px; border: 1px solid #edf2f7; padding: 20px; border-radius: 12px; }
");

/** * IMPORTANTE: Obtenemos el ID del proyecto si el servicio ya lo tiene asignado 
 * para pasarlo al JS de inicialización.
 */
$proyectoIdExistente = $model->cliente_proyecto_id ?? 'null';
?>

<div class="master-container">
    <div class="main-form-card">
        <?php $form = ActiveForm::begin(['id' => 'master-update-form']); ?>

        <div class="form-section">
            <div class="section-header"><i class="fa fa-info-circle"></i> Información del Servicio</div>
            <?= $this->render('_step1', ['form' => $form, 'model' => $model]) ?>
        </div>

        <div class="form-section">
            <div class="section-header"><i class="fa fa-users"></i> Detalle de Pasajeros y Ruta</div>
            <?php 
            // PASAMOS LOS PASAJEROS GUARDADOS AL STEP 2 PARA QUE SE REPINTE EN EL UPDATE
            echo $this->render('_step2', [
                'form' => $form, 
                'model' => $model,
                'pasajerosGuardados' => $pasajerosGuardados ?? []
            ]) ?>
        </div>

        <div class="form-section" style="background: #fcfdfd;">
            <div class="section-header"><i class="fa fa-calculator"></i> Tarifas y Adicionales</div>
            <?= $this->render('_step3', [
                'form' => $form, 
                'model' => $model, 
                'variablesAdicionales' => $variablesAdicionales 
            ]) ?>
        </div>

        <div class="form-group text-right">
            <?= Html::submitButton('<i class="fa fa-save"></i> GUARDAR CAMBIOS TOTALES', [
                'class' => 'btn btn-success btn-lg',
                'style' => 'border-radius: 30px; padding: 15px 50px; font-weight: bold; box-shadow: 0 4px 10px rgba(46, 204, 113, 0.3);'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="sticky-panel">
        <div class="card-total" style="position: sticky; top: 20px; background: #1a2a3a; color: white; border-radius: 15px; padding: 25px;">
            <h4 style="margin-top: 0; font-size: 13px; color: #94a3b8; letter-spacing: 1px;">RESUMEN DE MODIFICACIÓN</h4>
            
            <div class="detail-row" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span>Monto Base:</span> <b id="lbl-base">0,00</b>
            </div>
            <div class="detail-row" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span>Recargos:</span> <b id="lbl-recargo" style="color: #f87171;">0,00</b>
            </div>
            <div class="detail-row" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span>Viáticos:</span> <b id="lbl-viatico">0,00</b>
            </div>
            <div class="detail-row" style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #334155;">
                <span>Variables:</span> <b id="lbl-extras">0,00</b>
            </div>
            
            <div class="total-display" style="padding-top: 15px; text-align: center;">
                <span style="display: block; font-size: 11px; color: #94a3b8;">TOTAL ESTIMADO</span>
                <div style="font-size: 32pt; font-weight: bold; color: #4ade80;">
                    <small style="font-size: 16pt;">$</small> <span id="lbl-total">0,00</span>
                </div>
            </div>

            <hr style="border-color: #334155;">
            <div id="mini-log" style="font-size: 11px; color: #64748b; font-style: italic;">
                Modo edición activo
            </div>
        </div>
    </div>
</div>

<?php
// 1. Valores puros del modelo
$montoTotalPuro   = (float)$model->monto; 
$recargoPuro      = (float)$model->monto_recargo; 
$viaticoPuro      = (float)$model->total_viatico; 

// 2. Sumar adicionales guardados para el cálculo de la base inicial
$sumaAdicionalesGuardados = 0;
if (isset($adicionalesModelos) && is_array($adicionalesModelos)) {
    foreach ($adicionalesModelos as $relacion) {
        $sumaAdicionalesGuardados += (float)$relacion->monto;
    }
}

// 3. FÓRMULA DE LA BASE: Total - Viáticos - Recargo - Adicionales
$basePura = $montoTotalPuro - $viaticoPuro - $recargoPuro - $sumaAdicionalesGuardados;

// 4. Formateos para la interfaz
$valBase    = number_format($basePura, 2, ',', '.');
$valRecargo = number_format($recargoPuro, 2, ',', '.');
$valViatico = number_format($viaticoPuro, 2, ',', '.');

$jsAdicionales = json_encode($adicionalesGuardados ?? []);

$this->registerJs("
    $(document).ready(function() {
        var seleccionados = {$jsAdicionales};

        function parseMoney(val) {
            if(!val) return 0;
            var clean = val.toString().replace(/\./g, '').replace(',', '.');
            return parseFloat(clean) || 0;
        }

        function formatMoney(n) {
            return n.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        window.recalcularTodo = function() {
            var base = parseMoney($('#monto-base').val());
            var recargo = parseMoney($('input[name*=\"[monto_recargo]\"]').val());
            var viatico = parseMoney($('input[name*=\"[viaticos]\"]').val() || $('input[name*=\"[total_viatico]\"]').val());
            
            var adicionalSum = 0;
            $('.adicional-card.active').each(function() {
                adicionalSum += parseFloat($(this).attr('data-monto')) || 0;
            });

            var totalCalculado = base + viatico + recargo + adicionalSum;
            var totalFormateado = formatMoney(totalCalculado);

            $('input[name*=\"[monto]\"]').not('#monto-base').val(totalFormateado);

            $('#lbl-base').text(formatMoney(base));
            $('#lbl-recargo').text(formatMoney(recargo));
            $('#lbl-viatico').text(formatMoney(viatico));
            $('#lbl-extras').text(formatMoney(adicionalSum));
            $('#lbl-total').text(totalFormateado);
        }

        setTimeout(function() {
            $('#monto-base').val('{$valBase}');
            
            var inputViatico = $('input[name*=\"[viaticos]\"]').length ? $('input[name*=\"[viaticos]\"]') : $('input[name*=\"[total_viatico]\"]');
            var inputRecargo = $('input[name*=\"[monto_recargo]\"]');
            
            if(inputViatico.val() == '' || inputViatico.val() == '0,00') inputViatico.val('{$valViatico}');
            if(inputRecargo.val() == '' || inputRecargo.val() == '0,00') inputRecargo.val('{$valRecargo}');

            if (seleccionados && seleccionados.length > 0) {
                seleccionados.forEach(function(id) {
                    var card = $('.adicional-card[data-id=\"' + id + '\"]');
                    if (card.length) {
                        card.addClass('active');
                        card.find('input[type=\"checkbox\"]').prop('checked', true);
                        card.find('.card-check i').removeClass('fa-circle-thin').addClass('fa-check-circle');
                    }
                });
            }
            
            recalcularTodo();
        }, 1300);

        $(document).on('keyup change', '#monto-base, input[name*=\"[monto_recargo]\"], input[name*=\"[viaticos]\"], input[name*=\"[total_viatico]\"]', function() {
            recalcularTodo();
        });

        $(document).on('click', '.adicional-card', function() {
            setTimeout(recalcularTodo, 150);
        });
    });
");
?>