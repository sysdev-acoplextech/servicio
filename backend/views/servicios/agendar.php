<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

// Detectamos si ya tiene una asignación manual (conductor y flota guardados)
// o si es una asignación simple por combo.
$esManual = (!empty($model->id_conductor) && !empty($model->id_flota));
?>

<?php
$this->registerCss("
    .ticket-container { max-width: 550px; margin: 20px auto; background: #fff; border-radius: 20px; border: 1px solid #E2E8F0; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
    .ticket-header { background: #1B242D; color: #fff; padding: 20px; text-align: center; }
    .ticket-body { padding: 25px; position: relative; }
    
    #carga-trabajo-container {
        background: #F8FAFC; border-radius: 15px; padding: 15px; margin-bottom: 20px;
        border-left: 4px solid #EA4C2D; display: none;
    }
    .info-mini-ticket { background: #fff; padding: 8px 12px; border-radius: 10px; margin-top: 8px; font-size: 11px; font-weight: 700; border: 1px solid #E2E8F0; display: flex; justify-content: space-between; }

    .form-control { border-radius: 12px !important; height: 45px; font-weight: 600; border: 1.5px solid #CBD5E1; }
    .btn-assign { background: #10B981; color: white; border-radius: 15px !important; font-weight: 800; width: 100%; padding: 14px; border: none; margin-top: 20px; cursor: pointer; }
    
    .mode-switch { display: flex; gap: 10px; margin-bottom: 20px; background: #F1F5F9; padding: 5px; border-radius: 12px; }
    .btn-mode { flex: 1; border: none; padding: 10px; border-radius: 8px; font-size: 11px; font-weight: 800; color: #64748B; background: transparent; cursor: pointer; }
    .btn-mode.active { background: #fff; color: #1B242D; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }

    .manual-selects { border: 1px dashed #CBD5E1; padding: 20px; border-radius: 15px; background: #fafafa; }
");

$this->registerJs("
    // Función para manejar el cambio de vista
    function switchMode(mode) {
        $('.btn-mode').removeClass('active');
        $('.btn-mode[data-mode=\"' + mode + '\"]').addClass('active');

        if(mode == 'manual') {
            $('.field-servicios-id_flota').hide();
            $('.manual-selects').show();
        } else {
            $('.field-servicios-id_flota').show();
            $('.manual-selects').hide();
        }
    }

    // Al cargar la página, verificar si ya tiene datos asignados
    $(document).ready(function() {
        let hasConductor = $('#select-conductor-manual').val();
        let hasFlotaManual = $('#select-flota-manual').val();
        let hasFlotaCombo = $('#servicios-id_flota').val();

        // Si ya tiene conductor asignado manualmente, activamos modo manual
        if (hasConductor && hasFlotaManual) {
            switchMode('manual');
            consultarCarga(hasConductor, 'conductor');
        } else if (hasFlotaCombo) {
            switchMode('combo');
            consultarCarga(hasFlotaCombo, 'flota');
        }
    });

    $('.btn-mode').click(function() {
        switchMode($(this).data('mode'));
    });

    function consultarCarga(id, tipo) {
        if(!id) {
            $('#carga-trabajo-container').fadeOut();
            return;
        }
        $.get('" . Url::to(['get-servicios-conductor']) . "', {
            id: id, 
            tipo: tipo, 
            fecha: '" . $model->fecha_servicio . "'
        }, function(data) {
            $('#carga-trabajo-list').html(data.html);
            $('#carga-trabajo-container').fadeIn();
        });
    }

    $('#servicios-id_flota').on('change', function() { consultarCarga($(this).val(), 'flota'); });
    $('#select-conductor-manual').on('change', function() { consultarCarga($(this).val(), 'conductor'); });
");
?>

<div class="ticket-container">
    <div class="ticket-header">
        <span class="service-id-badge" style="background:#EA4C2D; padding:5px 12px; border-radius:20px; font-weight:800;">SERVICIO #<?= $model->id_servicio ?></span>
        <h4 style="margin-top:12px; font-weight:800;">REVISAR ASIGNACIÓN</h4>
    </div>

    <div class="ticket-body">
        <div class="mode-switch">
            <button type="button" class="btn-mode active" data-mode="combo">VÍNCULO FIJO</button>
            <button type="button" class="btn-mode" data-mode="manual">ASIGNACIÓN LIBRE</button>
        </div>

        <?php $form = ActiveForm::begin(['id' => 'form-despacho']); ?>

        <div id="carga-trabajo-container">
            <label style="font-size:10px; color:#94A3B8; text-transform:uppercase; font-weight: 800;">Carga actual del conductor:</label>
            <div id="carga-trabajo-list"></div>
        </div>

        <?= $form->field($model, 'id_flota')->dropDownList($listaFlota, [
            'prompt' => 'Seleccione Unidad/Conductor...',
            'class' => 'form-control',
            'id' => 'servicios-id_flota'
        ])->label('Unidad Operativa Asignada') ?>

        <div class="manual-selects" style="display:none;">
            <?= $form->field($model, 'id_conductor')->dropDownList($listaConductores, [
                'id' => 'select-conductor-manual',
                'prompt' => '¿Quién conduce?',
                'class' => 'form-control'
            ])->label('Conductor') ?>
            
            <?= $form->field($model, 'id_flota')->dropDownList($listaTodasFlotas, [
                'id' => 'select-flota-manual',
                'prompt' => '¿En qué vehículo?',
                'class' => 'form-control',
                'style' => 'font-size: 12px;'
            ])->label('Unidad Física') ?>
        </div>

        <?= Html::submitButton('<i class="fa fa-save"></i> ACTUALIZAR DESPACHO', ['class' => 'btn-assign']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>