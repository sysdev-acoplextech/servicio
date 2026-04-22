<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\models\CondicionFlota;

/* @var $this yii\web\View */
/* @var $modelFlota backend\models\Flota */
/* @var $modelMov backend\models\MovFlota */

?>

<style>
    /* Estilo para que los campos dentro del modal sean rectos */
    .estatus-form .select2-selection,
    .estatus-form .form-control {
        border-radius: 0px !important;
        border: 1px solid #CBD5E1 !important;
        height: 45px !important;
        box-shadow: none !important;
    }

    .estatus-form textarea.form-control {
        height: auto !important;
    }

    /* Etiquetas elegantes */
    .form-label-custom {
        color: #64748B;
        text-transform: uppercase;
        font-size: 8.5pt;
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
        letter-spacing: 0.5px;
    }

    /* Botones redondeados según tus reglas */
    .btn-redondo {
        border-radius: 20px !important;
        padding: 12px 25px;
        font-weight: bold;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-cancelar {
        background-color: #F1F5F9;
        color: #475569;
    }

    .btn-cancelar:hover {
        background-color: #E2E8F0;
    }

    .btn-guardar {
        background-color: #10B981;
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }

    .btn-guardar:hover {
        background-color: #059669;
        transform: translateY(-2px);
    }

    /* Info de la unidad superior */
    .unidad-info-box {
        background: #F8FAFC;
        padding: 15px;
        border-left: 4px solid #1B242D;
        margin-bottom: 25px;
    }
</style>

<div class="estatus-form" style="padding: 15px;">

    <div class="unidad-info-box">
        <h5 style="margin:0; font-weight: bold; color: #1B242D;">
            <i class="fa fa-truck"></i> UNIDAD PLACA: <span style="color: #EA4C2D;"><?= Html::encode($modelFlota->placa) ?></span>
        </h5>
        <p style="margin: 5px 0 0 0; color: #64748B; font-size: 9pt;">
            Condición actual: <b><?= $modelFlota->idCondicion ? $modelFlota->idCondicion->nombre_condicion_flota : 'Sin Definir' ?></b>
        </p>
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'form-cambio-estatus',
        'enableAjaxValidation' => false,
    ]); ?>

    <div class="row">
        <div class="col-md-12">
            <label class="form-label-custom">Seleccione la Nueva Condición</label>
            <?= $form->field($modelMov, 'id_estatus')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(CondicionFlota::find()->where(['estatus' => 1])->all(), 'id', 'nombre_condicion_flota'),
                'options' => ['placeholder' => 'Buscar condición (Operativo, Taller, etc)...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => '#modal-flota' // Importante para que funcione dentro de un modal
                ],
            ])->label(false); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
            <label class="form-label-custom">Observaciones / Motivo del Cambio</label>
            <?= $form->field($modelMov, 'observacion')->textarea([
                'rows' => 4,
                'placeholder' => 'Escriba aquí los detalles del por qué se cambia el estatus...',
            ])->label(false) ?>
        </div>
    </div>

    <hr style="border-top: 1px solid #F1F5F9; margin: 25px 0;">

    <div class="row">
        <div class="col-md-12 text-right">
            <?= Html::button('<i class="fa fa-times"></i> Cancelar', [
                'class' => 'btn btn-redondo btn-cancelar',
                'data-dismiss' => 'modal'
            ]) ?>
            
            <?= Html::submitButton('<i class="fa fa-save"></i> Procesar Cambio', [
                'class' => 'btn btn-redondo btn-guardar',
            ]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
// Script para asegurar que el Select2 cargue bien dentro del Modal de Bootstrap
$this->registerJs("
    $('#modal-flota').on('shown.bs.modal', function () {
        $(this).find('.select2-hidden-accessible').select2('open').select2('close');
    });
");
?>