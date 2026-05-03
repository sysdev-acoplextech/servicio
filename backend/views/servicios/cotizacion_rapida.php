<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use backend\models\Cliente;
use backend\models\BaseTipoVehiculo;
use backend\models\TipoTrasladoRuta;
use yii\web\JsExpression;
use backend\models\Tarifario;

$this->title = 'Cálculo Rápido de Servicio';
$urlInfoCliente = Url::to(['servicios/info-cliente']);
$hoy = date('Y-m-d');

$this->registerCss("
    .service-wrapper { display: flex; gap: 20px; padding: 15px; background: #f4f7f6; min-height: 90vh; }
    .form-container { flex: 3; background: white; border-radius: 20px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .summary-sticky { flex: 1; min-width: 300px; }
    .card-total { 
        position: sticky; top: 20px; background: #1B242D; color: white; 
        border-radius: 20px; padding: 25px; border-left: 5px solid #3B82F6;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .total-big { font-size: 32pt; font-weight: 900; color: #3B82F6; margin: 10px 0; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px; }
    .detail-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 13px; color: #94A3B8; }
    .detail-row b { color: white; font-size: 14px; }
    .section-title { font-weight: 800; color: #1E293B; margin-bottom: 20px; border-bottom: 2px solid #F1F5F9; padding-bottom: 10px; }
    .adicionales-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; }
    .adicional-card {
        background: #F8FAFC; border: 2px solid #E2E8F0; border-radius: 12px; padding: 12px;
        cursor: pointer; transition: 0.2s; text-align: center;
    }
    .adicional-card.active { border-color: #3B82F6; background: #EFF6FF; box-shadow: 0 4px 6px rgba(59, 130, 246, 0.1); }
    .adicional-card .card-title { display: block; font-weight: bold; font-size: 11px; color: #475569; }
    .adicional-card .card-price { color: #3B82F6; font-weight: 800; font-size: 12px; }
");

// Consulta de variables
$variablesAdicionales = (new \yii\db\Query())
    ->select(['v.id_variable', 'v.nombre_variable', 'v.descripcion', 'l.monto'])
    ->from('variables_servicio v')
    ->innerJoin('lista_precio l', 'v.id_variable = l.id_variable')
    ->where(['v.estatus' => 1])
    ->all();
?>

<div class="cotizacion-rapida">
    <?php $form = ActiveForm::begin(['id' => 'form-rapido']); ?>
    
    <div class="service-wrapper">
        <div class="form-container">
            
            <h4 class="section-title"><i class="fa fa-user text-primary"></i> 1. Datos del Cliente</h4>
             <div class="row">
                <div class="col-md-8">
                    <?= $form->field($model, 'id_cliente')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Cliente::find()->all(), 'id_cliente', 'nombre_apellido'),
                        'options' => [
                            'id' => 'select-cliente',
                            'placeholder' => 'Buscar o escribir nuevo cliente...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'tags' => true,
                            'tokenSeparators' => [',', ';'],
                        ],
                    ])->label('Nombre / Empresa') ?>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Teléfono de Contacto</label>
                    <?= Html::textInput('telefono_cliente', '', [
                        'id' => 'campo-telefono',
                        'class' => 'form-control',
                        'style' => 'border-radius:10px; font-weight: bold; height: 38px;',
                        'placeholder' => 'Ingrese el número...',
                        'maxlength' => 11
                    ]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'fecha_servicio')->input('date', [
                        'style' => 'border-radius:10px;',
                        'min' => $hoy,
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <label>Ruta Predeterminada (Tarifario)</label>
                    <select id="ruta-select" class="form-control" style="border-radius:10px;">
                        <option value="">Seleccione una ruta para cargar precio...</option>
                        <?php 
                        $rutas = TipoTrasladoRuta::find()->where(['estatus' => 1])->all();
                        foreach($rutas as $r): 
                            $pSedan = $r->precio_sedan ?? $r->sedan ?? 0;
                            $pCamioneta = $r->precio_camioneta ?? $r->camioneta ?? 0;
                        ?>
                            <option value="<?= $r->id ?>" data-sedan="<?= $pSedan ?>" data-camioneta="<?= $pCamioneta ?>">
                                <?= Html::encode($r->nombre_traslado_ruta) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                 <div class="col-md-4">
                    <?= $form->field($model, 'id_tipo_vehiculo')->dropDownList(
                        ArrayHelper::map(BaseTipoVehiculo::find()->all(), 'id', 'nombre_tipo_vehiculo'),
                        ['prompt' => 'Seleccione Vehículo...', 'style' => 'border-radius:8px;']
                    ) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label> Tarifario</label>
                    <?= Select2::widget([
                        'name' => 'id_tarifario_filtro',
                        'data' => ArrayHelper::map(Tarifario::find()->all(), 'id_tarifario', 'descripcion'),
                        'options' => ['id' => 'select-tarifario-padre', 'placeholder' => 'Seleccione...'],
                        'pluginOptions' => ['allowClear' => true],
                    ]); ?>
                </div>
                <div class="col-md-6">
                    <label> Ruta</label>
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

            <br>
            <h4 class="section-title"><i class="fa fa-plus-circle text-primary"></i> 2. Adicionales de Servicio</h4>
            <div class="adicionales-grid">
                <?php foreach ($variablesAdicionales as $var): ?>
                    <div class="adicional-card" data-id="<?= $var['id_variable'] ?>" data-monto="<?= $var['monto'] ?>">
                        <span class="card-title"><?= Html::encode($var['nombre_variable']) ?></span>
                        <span class="card-price">+$<?= number_format($var['monto'], 2, ',', '.') ?></span>
                        <input type="checkbox" name="Servicios[adicionales][]" value="<?= $var['id_variable'] ?>" style="display: none;">
                    </div>
                <?php endforeach; ?>
            </div>

            <br>
            <h4 class="section-title"><i class="fa fa-money text-primary"></i> 3. Montos Manuales</h4>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'monto_base')->textInput(['id' => 'monto-base', 'class' => 'form-control calc-trigger']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'monto_recargo')->textInput(['id' => 'monto-recargo', 'class' => 'form-control calc-trigger']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'viaticos')->textInput(['id' => 'monto-viatico', 'class' => 'form-control calc-trigger']) ?>
                </div>
            </div>
            <?= $form->field($model, 'id_tipo_vehiculo')->hiddenInput(['id' => 'tipo-v-select', 'value' => 1])->label(false) ?>
        </div>

        <div class="summary-sticky">
            <div class="card-total">
                <h4 style="margin-top: 0; font-size: 12px; color: #3B82F6; font-weight: 900; text-transform: uppercase;">Resumen de Cobro</h4>
                
                <div class="detail-row"><span>Monto Base:</span> <b id="lbl-base">0,00</b></div>
                <div class="detail-row"><span>Recargo/Hora:</span> <b id="lbl-recargo">0,00</b></div>
                <div class="detail-row"><span>Adicionales:</span> <b id="lbl-extras">0,00</b></div>
                
                <div class="total-big">
                    <span style="font-size: 20pt; vertical-align: top;">$</span>
                    <span id="lbl-total">0,00</span>
                </div>

                <?= $form->field($model, 'monto')->hiddenInput(['id' => 'final-monto-input'])->label(false) ?>
                <?= $form->field($model, 'id_estatus')->hiddenInput(['value' => 12])->label(false) ?>

                <div style="margin-top: 20px; display: flex; flex-direction: column; gap: 10px;">
                    <?= Html::submitButton('<i class="fa fa-save"></i> GUARDAR COTIZACIÓN', [
                        'class' => 'btn btn-primary btn-block',
                        'style' => 'border-radius: 15px; padding: 15px; font-weight: bold; background: #3B82F6; border: none;'
                    ]) ?>
                    <?= Html::a('<i class="fa fa-arrow-left"></i> REGRESAR', ['index'], ['class' => 'btn btn-link btn-block', 'style' => 'color: #94A3B8; font-size: 12px;']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJs("
    function getFloat(val) {
        if(!val) return 0;
        let s = val.toString().replace(/\./g, '').replace(',', '.');
        return parseFloat(s) || 0;
    }

    function format(num) {
        return num.toLocaleString('de-DE', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    function updateCalculo() {
        let base = getFloat($('#monto-base').val());
        let recargo = getFloat($('#monto-recargo').val());
        let viatico = getFloat($('#monto-viatico').val());
        
        let extras = 0;
        $('.adicional-card.active').each(function() {
            extras += parseFloat($(this).data('monto')) || 0;
        });

        let total = base + recargo + viatico + extras;
        
        // Actualizar etiquetas en el cuadro negro de la derecha
        $('#lbl-base').text(format(base));
        $('#lbl-recargo').text(format(recargo));
        $('#lbl-extras').text(format(extras));
        $('#lbl-total').text(format(total));
        
        // Actualizar el input oculto que se envía al servidor
        $('#final-monto-input').val(format(total));
    }

    // Evento para los Adicionales (Cards)
    $(document).off('click', '.adicional-card').on('click', '.adicional-card', function() {
        $(this).toggleClass('active');
        let checkbox = $(this).find('input[type=\"checkbox\"]');
        checkbox.prop('checked', $(this).hasClass('active'));
        updateCalculo();
    });

    // Evento para los inputs manuales
    $(document).on('change keyup', '.calc-trigger', updateCalculo);

    // Lógica de Tarifario Dinámico
    $('#select-tarifario-padre').on('change', function() {
        let habilitar = $(this).val() !== '';
        $('#id-selector-ruta-dep').prop('disabled', !habilitar).val(null).trigger('change');
    });

    window.aplicarPrecioBase = function() {
        let sel = $('#id-selector-ruta-dep');
        let tipoV = $('#tipo-v-select').val() || 1;
        let precio = (tipoV == '1') ? sel.data('sedan') : sel.data('camioneta');
        if(precio) {
            $('#monto-base').val(format(parseFloat(precio)));
            updateCalculo();
        }
    }

    // AJAX Cliente
    $('#select-cliente').on('change', function() {
        var val = $(this).val();
        if (val && !isNaN(val)) {
            $.get('{$urlInfoCliente}', {id: val}, function(data) {
                if (data.success) $('#campo-telefono').val(data.telefono).addClass('bg-light');
            });
        } else {
            $('#campo-telefono').val('').removeClass('bg-light');
        }
    });

    // Inicializar
    updateCalculo();
");
?>