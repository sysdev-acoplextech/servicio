<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use backend\models\Tarifario;
use backend\models\FormaPago;

$urlRecargo = Url::to(['servicios/obtener-recargo']);

// Data para el select de formas de pago
$dataFormaPago = ArrayHelper::map(FormaPago::find()->where(['estatus' => 1])->all(), 'id_forma_pago', 'descripcion');

// Consulta para unir variables con sus precios
$variablesAdicionales = (new \yii\db\Query())
    ->select(['v.id_variable', 'v.nombre_variable', 'v.descripcion', 'l.monto'])
    ->from('variables_servicio v')
    ->innerJoin('lista_precio l', 'v.id_variable = l.id_variable')
    ->where(['v.estatus' => 1])
    ->all();
?>

<style>
    .adicionales-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .adicional-card {
        background: white;
        border: 2px solid #E2E8F0;
        border-radius: 12px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        border-bottom: 4px solid #E2E8F0;
    }

    .adicional-card:hover {
        border-color: #3498db;
        transform: translateY(-2px);
    }

    .adicional-card.active {
        border-color: #27ae60;
        background: #f0fff4;
        border-bottom: 4px solid #219150;
    }

    .card-content {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-check {
        font-size: 1.4em;
        color: #CBD5E1;
    }

    .adicional-card.active .card-check {
        color: #27ae60;
    }

    .card-info {
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-weight: bold;
        color: #1e293b;
        font-size: 11pt;
        line-height: 1.2;
    }

    .card-price {
        color: #64748b;
        font-size: 10pt;
        margin-top: 4px;
    }

    .adicional-card.active .card-price {
        color: #166534;
        font-weight: bold;
    }

    /* Estilo para el área de observaciones */
    .textarea-observacion {
        border-radius: 12px;
        border: 1px solid #E2E8F0;
        padding: 12px;
        resize: none;
        transition: border-color 0.3s;
    }
    .textarea-observacion:focus {
        border-color: #3498db;
        outline: none;
    }
</style>

<div class="box box-solid" style="background: #F8FAFC; border-radius: 15px; border: 1px solid #E2E8F0; padding: 20px;">

    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-12">
            <div id="status-flag" style="padding: 10px 15px; border-radius: 8px; background: #e2e8f0; color: #64748b; font-weight: bold; display: inline-block;">
                <i class="fa fa-refresh"></i> ESPERANDO DATOS...
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <label>1. Tarifario</label>
            <?= Select2::widget([
                'name' => 'id_tarifario_filtro',
                'data' => ArrayHelper::map(Tarifario::find()->all(), 'id_tarifario', 'descripcion'),
                'options' => ['id' => 'select-tarifario-padre', 'placeholder' => 'Seleccione...'],
                'pluginOptions' => ['allowClear' => true],
            ]); ?>
        </div>
        <div class="col-md-7">
            <label>2. Ruta</label>
            <?= Select2::widget([
                'name' => 'ruta_selector',
                'options' => ['id' => 'id-selector-ruta-dep', 'placeholder' => 'Busque ruta...', 'disabled' => true],
                'pluginOptions' => [
                    'allowClear' => true,
                    'ajax' => [
                        'url' => Url::to(['servicios/buscar-ruta']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { 
                            return { q: params.term, id_tarifario: $("#select-tarifario-padre").val() }; 
                        }'),
                        'processResults' => new JsExpression('function(data) { return { results: data.results }; }'),
                    ],
                ],
                'pluginEvents' => [
                    "select2:select" => "function(e) { 
                        var data = e.params.data;
                        $('#id-selector-ruta-dep').data('sedan', data.sedan);
                        $('#id-selector-ruta-dep').data('camioneta', data.camioneta);
                        aplicarPrecioBase();
                    }",
                ]
            ]); ?>
        </div>
    </div>

    <hr style="border-top: 1px dashed #CBD5E1;">

    <div class="row">
        <div class="col-md-12">
            <label style="color: #475569; font-size: 1.1em; margin-bottom: 15px;">
                <i class="fa fa-star text-yellow"></i> 3. Adicionales del Servicio
            </label>
            <div class="adicionales-grid">
                <?php foreach ($variablesAdicionales as $var): ?>
                    <div class="adicional-card" data-id="<?= $var['id_variable'] ?>" data-monto="<?= $var['monto'] ?>">
                        <div class="card-content">
                            <div class="card-check"><i class="fa fa-circle-thin"></i></div>
                            <div class="card-info">
                                <span class="card-title"><?= Html::encode($var['nombre_variable']) ?></span>
                                <span class="card-price">+$<?= number_format($var['monto'], 2, ',', '.') ?></span>
                            </div>
                        </div>
                        <input type="checkbox" name="Servicios[adicionales][]" value="<?= $var['id_variable'] ?>" style="display: none;">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <hr style="border-top: 1px dashed #CBD5E1;">
    
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'id_forma_pago')->widget(Select2::class, [
                'data' => $dataFormaPago,
                'options' => ['placeholder' => 'Seleccione forma de pago...'],
                'pluginOptions' => ['allowClear' => true],
            ])->label('<i class="fa fa-credit-card"></i> Forma de Pago') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'monto_base', ['enableClientValidation' => false])->textInput([
                'id' => 'monto-base',
                'style' => 'background: #FFFDE7; font-weight: bold; border-radius: 8px;'
            ])->label('Monto  ($)') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'monto_recargo', ['enableClientValidation' => false])->textInput([
                'id' => 'monto-recargo',
                'style' => 'color: #d32f2f; font-weight: bold; border-radius: 8px;'
            ])->label('Recargo ($)') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'viaticos', ['enableClientValidation' => false])->textInput([
                'id' => 'monto-viatico',
                'style' => 'border-radius: 8px;'
            ])->label('Viáticos ($)') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'monto', ['enableClientValidation' => false])->textInput([
                'id' => 'monto-total-final',
                'readonly' => true,
                'style' => 'background: #27ae60; color: white; font-weight: bold; font-size: 1.2em; border: none; border-radius: 8px;'
            ])->label('TOTAL') ?>
        </div>
    </div>

    <div class="row" style="margin-top: 15px;">
        <div class="col-md-12">
            <?= $form->field($model, 'observacion_inicial')->textarea([
                'rows' => 2,
                'class' => 'form-control textarea-observacion',
                'placeholder' => 'Escriba aquí las instrucciones específicas para el conductor...'
            ])->label('<i class="fa fa-commenting-o"></i> Observación a ser enviada al conductor') ?>
        </div>
    </div>
</div>

<?php
$this->registerJs("
    function setFlag(type, message) {
        var flag = $('#status-flag');
        var css = { 'background': '#f1f5f9', 'color': '#64748b' };
        var icon = 'fa-refresh';
        if(type == 'loading') { css = {'background': '#dbeafe', 'color': '#1e40af'}; icon = 'fa-spinner fa-spin'; }
        if(type == 'success') { css = {'background': '#dcfce7', 'color': '#166534'}; icon = 'fa-check-circle'; }
        flag.css(css).html('<i class=\"fa '+icon+'\"></i> ' + message);
    }

    function calcularMontoTotal() {
        var parseValue = function(id) {
            var val = $(id).val() || '0';
            return parseFloat(val.toString().replace(/\./g, '').replace(',', '.')) || 0;
        };

        var base = parseValue('#monto-base');
        var rec  = parseValue('#monto-recargo');
        var via  = parseValue('#monto-viatico');
        
        var adicionalSum = 0;
        $('.adicional-card.active').each(function() {
            adicionalSum += parseFloat($(this).data('monto')) || 0;
        });

        var total = base + rec + via + adicionalSum;

        $('#monto-total-final').val(total.toFixed(2).replace('.', ','));

        var ids = ['monto_base', 'monto_recargo', 'viaticos', 'monto'];
        var form = $('#w0');

        $.each(ids, function(i, attr) {
            var attributeId = 'servicios-' + attr; 
            var container = $('.field-' + attributeId.replace(/_/g, '-')); 
            
            container.removeClass('has-error').addClass('has-success');
            container.find('.help-block').empty();

            if (form.length > 0 && form.data('yiiActiveForm')) {
                form.yiiActiveForm('updateAttribute', attributeId, '');
            }
        });
    }

    function aplicarPrecioBase() {
        var tipoV = $('#servicios-id_tipo_vehiculo').val(); 
        var sedan = $('#id-selector-ruta-dep').data('sedan') || 0;
        var camioneta = $('#id-selector-ruta-dep').data('camioneta') || 0;
        var precio = (tipoV == '1') ? sedan : camioneta;
        
        if(precio > 0) {
            $('#monto-base').val(parseFloat(precio).toFixed(2).replace('.', ','));
            calcularMontoTotal();
            setFlag('success', 'PRECIO RUTA APLICADO');
        }
    }

    $(document).on('click', '.adicional-card', function() {
        var card = $(this);
        var checkbox = card.find('input[type=\"checkbox\"]');
        var icon = card.find('.card-check i');
        
        card.toggleClass('active');
        var isActive = card.hasClass('active');
        
        checkbox.prop('checked', isActive);
        icon.toggleClass('fa-circle-thin', !isActive).toggleClass('fa-check-circle', isActive);
        
        calcularMontoTotal();
    });

    function obtenerRecargo(esInicial) {
        var horaSolo = '';
        $('.campo-hora-dinamico').each(function() {
            if ($(this).val() !== '') { horaSolo = $(this).val(); return false; }
        });

        if (!horaSolo) {
            $('#monto-recargo').val('0,00');
            calcularMontoTotal();
            return;
        }

        if(!esInicial) setFlag('loading', 'CONSULTANDO HORARIO...');
        
        $.get('" . $urlRecargo . "', { hora: horaSolo }, function(res) {
            if (res.success) {
                var valor = parseFloat(res.recargo) || 0;
                $('#monto-recargo').val(valor.toFixed(2).replace('.', ','));
                setFlag('success', valor > 0 ? 'RECARGO: ' + res.descripcion : 'TARIFA NORMAL');
                calcularMontoTotal();
            }
        });
    }

    $('#select-tarifario-padre').on('change', function() {
        var val = $(this).val();
        $('#id-selector-ruta-dep').prop('disabled', !val).val(null).trigger('change');
        setFlag('reset', val ? 'ELIJA UNA RUTA' : 'ESPERANDO TARIFARIO');
    });

    $(document).on('change', '#servicios-id_tipo_vehiculo', function() { aplicarPrecioBase(); });
    $(document).on('change blur', '.campo-hora-dinamico', function() { obtenerRecargo(false); });
    
    $(document).on('keyup change', '#monto-base, #monto-recargo, #monto-viatico', function() {
        calcularMontoTotal();
    });

    $(document).ready(function() {
        setTimeout(function() {
            obtenerRecargo(true);
            calcularMontoTotal();
        }, 500);
    });
");
?>