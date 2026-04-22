<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;

$azulOscuro = "#1B242D";
$naranja = "#EA4C2D";

// Formateo de fechas
foreach (['fecha_ingreso', 'fecha_egreso'] as $attr) {
    if ($model->$attr && strpos($model->$attr, '-') !== false) {
        $d = explode("-", $model->$attr);
        if (count($d) == 3 && strlen($d[0]) == 4) {
            $model->$attr = $d[2] . "-" . $d[1] . "-" . $d[0];
        }
    }
}

$baseUrl = Yii::$app->request->baseUrl; 
$fotoUrl = (!empty($model->foto)) ? $baseUrl . $model->foto : $baseUrl . '/img/imagen_vacio.png';
?>

<div class="conductor-form" style="padding: 10px; background-color: #fff;">
    
    <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
        <div class="alert alert-<?= $type ?> alert-dismissible" style="border-radius: 0; margin-bottom: 15px; font-size: 12px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?= $message ?>
        </div>
    <?php endforeach; ?>

    <?php $form = ActiveForm::begin([
        'id' => 'conductor-active-form',
        'options' => ['enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'control-label', 'style' => 'text-transform: uppercase; font-size: 10px; color: #666; font-weight: bold; margin-bottom: 3px;'],
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-9" style="border-right: 1px solid #f4f4f4;">
            <h5 style="color: <?= $azulOscuro ?>; font-weight: bold; margin-top: 0; border-left: 3px solid <?= $naranja ?>; padding-left: 8px;">
                DATOS DEL CONDUCTOR
            </h5>

            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'nacionalidad')->widget(Select2::classname(), [
                        'data' => [1 => 'V', 0 => 'E'],
                        'options' => ['placeholder' => '...'],
                        'pluginOptions' => ['allowClear' => false, 'minimumResultsForSearch' => -1],
                    ]); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'cedula')->textInput(['type' => 'number', 'class' => 'form-control input-flat']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'correo')->textInput(['class' => 'form-control input-flat']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'nombres')->textInput(['class' => 'form-control input-flat']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'apellidos')->textInput(['class' => 'form-control input-flat']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'telefono_principal')->textInput(['class' => 'form-control input-flat']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'telefono_alterno')->textInput(['class' => 'form-control input-flat']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'fecha_ingreso')->widget(DatePicker::classname(), [
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'pluginOptions' => ['autoclose' => true, 'format' => 'dd-mm-yyyy'],
                        'options' => ['class' => 'input-flat']
                    ]); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'fecha_egreso')->widget(DatePicker::classname(), [
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'pluginOptions' => ['autoclose' => true, 'format' => 'dd-mm-yyyy'],
                        'options' => ['class' => 'input-flat']
                    ]); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'observacion_inicial')->textarea(['rows' => 2, 'class' => 'form-control input-flat', 'style' => 'resize:none;']) ?>
                </div>
            </div>
        </div>

        <div class="col-md-3 text-center">
            <label style="text-transform: uppercase; font-size: 10px; color: #666; display: block; margin-bottom: 8px;">FOTO PERFIL</label>
            
            <div class="contenedor-foto-perfil">
                <?= $form->field($model, 'foto')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'showCaption' => false, 'showRemove' => false, 'showUpload' => false,
                        'browseClass' => 'btn btn-default btn-xs btn-block btn-flat',
                        'browseLabel' => 'CAMBIAR',
                        'initialPreview' => [$fotoUrl],
                        'initialPreviewAsData' => true,
                        'previewSettings' => ['image' => ['width' => '100%', 'height' => '160px']],
                    ],
                ])->label(false); ?>
            </div>

            <div style="margin-top: 15px; background: #f9f9f9; padding: 10px; border: 1px solid #eee;">
                <div style="margin-bottom: 10px;">
                    <?= $form->field($model, 'estatus')->widget(SwitchInput::classname(), [
                        'pluginOptions' => ['size' => 'mini', 'onColor' => 'success', 'offColor' => 'danger', 'onText' => 'ACT', 'offText' => 'INC']
                    ]); ?>
                </div>
                <div>
                    <?= $form->field($model, 'tercerizado')->widget(SwitchInput::classname(), [
                        'pluginOptions' => ['size' => 'mini', 'onColor' => 'info', 'offColor' => 'default', 'onText' => 'ALI', 'offText' => 'PRO']
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer" style="margin-top: 20px; padding: 15px 0 0 0; border-top: 1px solid #eee;">
        <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">CANCELAR</button>
        <?= Html::submitButton('<i class="fa fa-save"></i> ACTUALIZAR REGISTRO', ['class' => 'btn btn-flat', 'style' => "background-color: $azulOscuro; color: white; padding: 10px 25px; font-weight: bold;"]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<style>
    /* RESET DE COMPONENTES A CUADRADOS */
    .modal-content, .modal-header, .modal-footer, .input-flat, 
    .select2-container--krajee .select2-selection, .btn-flat, 
    .form-control, .input-group-addon, .file-preview, .alert { 
        border-radius: 0px !important; 
    }

    /* X DEL MODAL EN BLANCO */
    .modal-header .close { color: #fff !important; opacity: 1 !important; text-shadow: none !important; }

    /* FIX IMAGEN ESTIRADA */
    .file-preview-image {
        width: 100% !important;
        height: 160px !important;
        object-fit: cover !important; /* Mantiene proporción */
        object-position: center !important;
    }
    
    .file-preview { padding: 0 !important; border: 1px solid #ddd !important; overflow: hidden !important; }
    .kv-preview-thumb, .file-preview-frame { width: 100% !important; margin: 0 !important; padding: 0 !important; border: none !important; }
    .file-thumbnail-footer { display: none !important; }

    /* AJUSTE DE LABELS DE SWITCHES */
    .col-md-3 .control-label { font-size: 9px !important; margin-bottom: 2px !important; display: block; }
</style>