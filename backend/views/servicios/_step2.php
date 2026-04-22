<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use backend\models\Pasajero;

$dataPasajeros = ArrayHelper::map(Pasajero::find()->all(), 'id_pasajero', 'nombre_apellido');
$urlRutas = Url::to(['servicios/get-rutas-pasajero']);
$urlDatosPasajero = Url::to(['servicios/get-datos-pasajero']); 

$this->registerCss("
    .pasajero-row { 
        background: #F1F5F9; 
        border-radius: 15px; 
        padding: 15px; 
        margin-bottom: 15px; 
        border: 1px solid #E2E8F0;
        position: relative;
    }
    .btn-remove { 
        position: absolute; right: -10px; top: -10px; 
        border-radius: 50%; width: 25px; height: 25px; padding: 0; 
        line-height: 25px; text-align: center; z-index: 10;
        background: #ef4444; border: none; color: white;
    }
    .add-pasajero-container {
        border: 2px dashed #CBD5E1; border-radius: 15px; padding: 20px;
        text-align: center; cursor: pointer; transition: all 0.3s;
    }
    .add-pasajero-container:hover { background: #F8FAFC; border-color: #3498db; }
    
    .ruta-sugerida {
        display: inline-block;
        background: #fff;
        border: 1px solid #3498db;
        color: #3498db;
        padding: 3px 10px;
        border-radius: 20px;
        margin-top: 8px;
        margin-right: 5px;
        font-size: 11px;
        cursor: pointer;
        transition: 0.2s;
    }
    .ruta-sugerida:hover { background: #3498db; color: #fff; }
");
?>

<div id="pasajeros-container" style="margin-top: 20px;">
    <h4 style="color: #475569; font-size: 14pt; margin-bottom: 20px;">
        <i class="fa fa-users"></i> Listado de Pasajeros
    </h4>

    <div class="pasajero-row" id="p-row-0">
        <div class="row">
            <div class="col-md-3">
                <label class="control-label">Pasajero</label>
                <?= Select2::widget([
                    'name' => 'Pasajeros[0][id_pasajero]',
                    'data' => $dataPasajeros,
                    'options' => [
                        'placeholder' => 'Buscar...',
                        'class' => 'select-pasajero-ajax',
                        'data-index' => 0,
                        'id' => 's2-0'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        'tokenSeparators' => [',', ';'],
                    ],
                ]) ?>
            </div>
            <div class="col-md-2">
                <label class="control-label">Teléfono</label>
                <?= Html::textInput('Pasajeros[0][telefono]', '', [
                    'id' => 'telefono-0',
                    'class' => 'form-control', 
                    'placeholder' => 'Ej: 0412...',
                    'style' => 'border-radius: 8px;'
                ]) ?>
            </div>
            <div class="col-md-3">
                <label class="control-label">Ruta Origen</label>
                <?= Html::textInput('Pasajeros[0][origen]', '', [
                    'id' => 'origen-0',
                    'class' => 'form-control', 
                    'style' => 'border-radius: 8px;'
                ]) ?>
            </div>
            <div class="col-md-4">
                <label class="control-label">Ruta Destino</label>
                <?= Html::textInput('Pasajeros[0][destino]', '', [
                    'id' => 'destino-0',
                    'class' => 'form-control', 
                    'style' => 'border-radius: 8px;'
                ]) ?>
            </div>
        </div>

        <div class="row" style="margin-top: 10px;">
            <div class="col-md-9">
                <label class="control-label"><i class="fa fa-map-marker" style="color: #db4437;"></i> Enlace Google Maps</label>
                <?= Html::textInput('Pasajeros[0][google_map]', '', [
                    'id' => 'google_map-0',
                    'class' => 'form-control', 
                    'placeholder' => 'Pegue el link aquí...',
                    'style' => 'border-radius: 8px; border-left: 3px solid #db4437;'
                ]) ?>
            </div>
            <div class="col-md-3">
                <label class="control-label">Hora</label>
                <?= Html::input('time', 'Pasajeros[0][hora]', '', [
                    'class' => 'form-control campo-hora-dinamico',
                    'style' => 'border-radius: 8px;'
                ]) ?>
            </div>
        </div>
        <div id="rutas-recientes-0" style="margin-top: 5px;"></div>
    </div>
</div>

<div class="add-pasajero-container" id="btn-add-pasajero">
    <span style="color: #64748B; font-weight: bold;">
        <i class="fa fa-plus-circle"></i> AGREGAR OTRO PASAJERO
    </span>
</div>

<?php
$this->registerJs("
    var pasajeroIndex = 1;

    window.setRuta = function(index, origen, destino) {
        $('#origen-' + index).val(origen);
        $('#destino-' + index).val(destino);
    };

    // EVENTO PRINCIPAL: Se dispara al seleccionar un pasajero de la lista
    $(document).on('select2:select', '.select-pasajero-ajax', function(e) {
        var idPasajero = e.params.data.id;
        var index = $(this).data('index');
        var containerRutas = $('#rutas-recientes-' + index);
        var inputTelefono = $('#telefono-' + index);

        // Si es un ID numérico (pasajero existente)
        if (idPasajero && !isNaN(idPasajero)) {
            // 1. Obtener Rutas
            $.get('{$urlRutas}', {id: idPasajero}, function(data) {
                var rutas = (typeof data === 'string') ? JSON.parse(data) : data;
                containerRutas.empty();
                if (rutas.length > 0) {
                    containerRutas.append('<div style=\"font-size:11px; color:#666; margin-bottom:5px;\">Rutas frecuentes:</div>');
                    rutas.forEach(function(r) {
                        containerRutas.append(`<span class='ruta-sugerida' onclick='setRuta(\${index}, \"\${r.origen}\", \"\${r.destino}\")'>\${r.origen} <i class='fa fa-arrow-right'></i> \${r.destino}</span>`);
                    });
                }
            });

            // 2. Obtener Datos del Pasajero (Teléfono)
            $.get('{$urlDatosPasajero}', {id: idPasajero}, function(res) {
                if(res.success) {
                    inputTelefono.val(res.telefono);
                    inputTelefono.css('background-color', '#e8f5e9'); // Feedback visual verde
                    setTimeout(() => inputTelefono.css('background-color', ''), 1000);
                }
            });
        } else {
            // Es un tag nuevo, limpiar teléfono para ingreso manual
            inputTelefono.val('').focus();
            containerRutas.empty();
        }
    });

    // Limpiar al deseleccionar
    $(document).on('select2:unselect', '.select-pasajero-ajax', function() {
        var index = $(this).data('index');
        $('#telefono-' + index).val('');
        $('#rutas-recientes-' + index).empty();
    });

    $('#btn-add-pasajero').on('click', function() {
        var options = " . json_encode($dataPasajeros) . ";
        var selectOptions = '<option value=\"\">Buscar...</option>';
        $.each(options, function(id, nombre) {
            selectOptions += '<option value=\"' + id + '\">' + nombre + '</option>';
        });

        var newRow = `
            <div class='pasajero-row' id='p-row-\${pasajeroIndex}'>
                <button type='button' class='btn btn-remove' onclick='$(\"#p-row-\${pasajeroIndex}\").remove();'>&times;</button>
                <div class='row'>
                    <div class='col-md-3'>
                        <label class='control-label'>Pasajero</label>
                        <select name='Pasajeros[\${pasajeroIndex}][id_pasajero]' class='form-control select-pasajero-ajax' data-index='\${pasajeroIndex}' id='s2-\${pasajeroIndex}'>
                            \${selectOptions}
                        </select>
                    </div>
                    <div class='col-md-2'>
                        <label class='control-label'>Teléfono</label>
                        <input type='text' name='Pasajeros[\${pasajeroIndex}][telefono]' id='telefono-\${pasajeroIndex}' class='form-control' style='border-radius: 8px;' placeholder='Ej: 0412...'>
                    </div>
                    <div class='col-md-3'>
                        <label class='control-label'>Ruta Origen</label>
                        <input type='text' name='Pasajeros[\${pasajeroIndex}][origen]' id='origen-\${pasajeroIndex}' class='form-control' style='border-radius: 8px;'>
                    </div>
                    <div class='col-md-4'>
                        <label class='control-label'>Ruta Destino</label>
                        <input type='text' name='Pasajeros[\${pasajeroIndex}][destino]' id='destino-\${pasajeroIndex}' class='form-control' style='border-radius: 8px;'>
                    </div>
                </div>
                <div class='row' style='margin-top: 10px;'>
                    <div class='col-md-9'>
                        <label class='control-label'><i class='fa fa-map-marker' style='color: #db4437;'></i> Enlace Google Maps</label>
                        <input type='text' name='Pasajeros[\${pasajeroIndex}][google_map]' id='google_map-\${pasajeroIndex}' class='form-control' placeholder='Pegue el link aquí...' style='border-radius: 8px; border-left: 3px solid #db4437;'>
                    </div>
                    <div class='col-md-3'>
                        <label class='control-label'>Hora</label>
                        <input type='time' name='Pasajeros[\${pasajeroIndex}][hora]' class='form-control campo-hora-dinamico' style='border-radius: 8px;'>
                    </div>
                </div>
                <div id='rutas-recientes-\${pasajeroIndex}' style='margin-top: 5px;'></div>
            </div>`;

        $('#pasajeros-container').append(newRow);
        
        // Inicializar Select2 en la nueva fila
        $('#s2-' + pasajeroIndex).select2({ 
            width: '100%', 
            tags: true, 
            allowClear: true,
            placeholder: 'Buscar...',
            tokenSeparators: [',', ';']
        });
        
        pasajeroIndex++;
    });
");
?>