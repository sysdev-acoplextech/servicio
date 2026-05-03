<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use backend\models\Cliente;
use backend\models\Estatus;
use backend\models\BaseTipoVehiculo;
use backend\models\TipoTrasladoRuta;

// Cargamos la data necesaria
$dataClientes = ArrayHelper::map(Cliente::find()->all(), 'id_cliente', 'nombre_apellido');
$hoy = date('Y-m-d');

$dataRutas = ArrayHelper::map(
    TipoTrasladoRuta::find()->where(['estatus' => 1])->all(), 
    'id', 
    'nombre_traslado_ruta'
);

if ($model->isNewRecord) {
    $model->id_estatus = 5;
}

$urlInfo = Url::to(['servicios/info-cliente']);
$urlProyectos = Url::to(['servicios/get-proyectos']);
?>

<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'id_tipo_vehiculo')->dropDownList(
            ArrayHelper::map(BaseTipoVehiculo::find()->all(), 'id', 'nombre_tipo_vehiculo'),
            ['prompt' => 'Seleccione Vehículo...', 'style' => 'border-radius:8px;']
        ) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'id_tipo_traslado_ruta')->dropDownList(
            $dataRutas, 
            ['prompt' => 'Seleccione Tipo de Ruta...', 'style' => 'border-radius:8px;']
        ) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'fecha_servicio')->input('date', ['style' => 'border-radius:8px; ', 'min' => $hoy,]) ?>
    </div>
</div>

<hr style="border-top: 1px solid #eee;">

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'id_cliente')->widget(Select2::classname(), [
            'data' => $dataClientes,
            'options' => [
                'id' => 'select-cliente',
                'placeholder' => 'Buscar cliente o empresa...',
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'tags' => true, 
                'tokenSeparators' => [',', ';'],
            ],
        ]); ?>
    </div>
    <div class="col-md-3">
        <label>Teléfono de Contacto</label>
        <input type="text" id="info-telefono" name="ClienteNuevo[telefono]" class="form-control" readonly 
               maxlength="11"
               style="border-radius:8px; background:#f8f9fa; font-weight: bold; border: 1px solid #d2d6de;"
               placeholder="Automático...">
    </div>
    <div class="col-md-3">
        <?php 
        $estatusList = Estatus::find()->where(['id' => [5, 10, 11]])->all();
        ?>
        <?= $form->field($model, 'id_estatus')->dropDownList(
            ArrayHelper::map($estatusList, 'id', 'estatus'),
            ['style' => 'border-radius:8px;']
        ) ?>
    </div>
</div>

<div class="row" id="container-proyecto" style="display: none; margin-top: 10px;">
    <div class="col-md-6">
        <label class="control-label">Cliente Asociado al proyecto</label>
        <?= Select2::widget([
            'name' => 'cliente_proyecto_id', 
            'id' => 'select-proyecto',
            'data' => [], 
            'options' => ['placeholder' => 'Seleccione el proyecto...'],
            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
        ]); ?>
    </div>
    <div class="col-md-6">
        <div class="alert alert-info" style="margin-top: 25px; padding: 10px; border-radius: 8px;">
            <i class="fa fa-info-circle"></i> Este cliente tiene proyectos/empresas vinculadas.
        </div>
    </div>
</div>

<div id="alert-no-grato" class="alert alert-danger" style="display:none; border-radius:12px; margin-top:15px; font-weight: bold; border-left: 5px solid #a94442;">
    <i class="fa fa-exclamation-triangle"></i> 
    <b>ATENCIÓN CRÍTICA:</b> Este cliente figura como <b>NO GRATO</b>.
</div>

<?php
$this->registerJs("
// Bloquear escritura no numérica en tiempo real para el teléfono
$('#info-telefono').on('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
});

$('#select-cliente').on('change', function() {
    var val = $(this).val();
    var containerProyecto = $('#container-proyecto');
    var selectProyecto = $('#select-proyecto');
    var inputTelefono = $('#info-telefono');

    if (val) {
        if (isNaN(val)) {
            // Cliente NUEVO escrito a mano
            inputTelefono.prop('readonly', false)
                         .css({'background': '#ffffff', 'border': '1px solid #ccd0d4'})
                         .val('')
                         .attr('placeholder', 'Ej: 04121234567')
                         .focus();
            
            containerProyecto.slideUp();
            $('#alert-no-grato').slideUp();
        } else {
            // Cliente existente
            inputTelefono.prop('readonly', true)
                         .css({'background': '#f8f9fa', 'border': '1px solid #d2d6de'})
                         .attr('placeholder', 'Automático...');

            $.ajax({
                url: '{$urlProyectos}',
                type: 'GET',
                data: {id: val},
                dataType: 'json',
                success: function(data) {
                    selectProyecto.empty().append('<option value=\"\">Seleccione...</option>');
                    if (data && data.length > 0) {
                        $.each(data, function(i, item) {
                            selectProyecto.append($('<option>', { value: item.id, text: item.text }));
                        });
                        containerProyecto.slideDown();
                    } else {
                        containerProyecto.slideUp();
                        selectProyecto.val(null).trigger('change');
                    }
                }
            });

            $.ajax({
                url: '{$urlInfo}',
                type: 'GET',
                data: {id: val},
                success: function(data) {
                    if (data.success) {
                        inputTelefono.val(data.telefono);
                        if (data.grato == 1) $('#alert-no-grato').slideDown();
                        else $('#alert-no-grato').slideUp();
                    }
                }
            });
        }
    } else {
        containerProyecto.slideUp();
        inputTelefono.prop('readonly', true)
                     .css({'background': '#f8f9fa', 'border': '1px solid #d2d6de'})
                     .val('')
                     .attr('placeholder', 'Automático...');
        $('#alert-no-grato').slideUp();
    }
});
");
?>