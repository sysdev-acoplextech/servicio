<?php

use backend\models\Conductor;
use backend\models\MovFlota;
use backend\models\VConductores;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\switchinput\SwitchInput;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Flota */
/* @var $model2 backend\models\Asignacion */
/* @var $model3 backend\models\MovFlota */
/* @var $registros array */

?>

<style>
    /* Estilo para que los inputs y el switch sean rectos dentro del modal */
    .flota-form input, 
    .flota-form .select2-selection,
    .flota-form .input-group-addon,
    .flota-form .bootstrap-switch {
        border-radius: 0px !important;
    }

    /* Botones siempre redondeados */
    .btn-redondo {
        border-radius: 15px !important;
        padding: 10px 20px;
        font-weight: bold;
        border: none;
    }

    .form-label-custom {
        color: #64748B;
        text-transform: uppercase;
        font-size: 8pt;
        font-weight: bold;
        margin-bottom: 8px;
        display: block;
    }

    /* Estilo para la tabla de historial */
    .table-historial {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        background: #FFF;
    }
    .table-historial th {
        background-color: #1B242D !important;
        color: white !important;
        padding: 12px;
        font-size: 9pt;
        text-transform: uppercase;
        border: none;
    }
    .table-historial td {
        padding: 12px;
        border-bottom: 1px solid #F1F5F9;
        color: #475569;
        font-size: 10pt;
    }
</style>

<div class="flota-form" style="padding: 20px;">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row">
        <div class="col-md-3">
            <label class="form-label-custom">¿Es Gerencia?</label>
            <?= $form->field($model, 'gerencia')->widget(SwitchInput::classname(), [
                'type' => SwitchInput::CHECKBOX,
                'pluginOptions' => [
                    'handleWidth' => 50,
                    'offColor' => 'danger',
                    'onColor' => 'success',
                    'onText' => 'SI',
                    'offText' => 'NO'
                ]
            ])->label(false); ?>
        </div>

        <div class="col-md-5">
            <label class="form-label-custom">Conductor Asignado</label>
            <?php
            $conductores = VConductores::find()->all();
            $lisconductores = ArrayHelper::map($conductores, 'id', 'datos');
            echo $form->field($model2, 'id_conductor')->widget(Select2::classname(), [
                'data' => $lisconductores,
                'options' => ['placeholder' => 'Seleccione Conductor...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(false);
            ?>
        </div>

        <div class="col-md-4">
            <label class="form-label-custom">Fecha de Asignación</label>
            <?= $form->field($model2, 'fecha_asignacion')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Elegir fecha...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy',
                    'todayHighlight' => true
                ]
            ])->label(false); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 15px;">
        <div class="col-md-12">
            <label class="form-label-custom">Observaciones del Movimiento</label>
            <?= $form->field($model3, 'observacion')->textInput([
                'maxlength' => true, 
                'placeholder' => 'Escriba una nota sobre esta asignación...',
                'style' => 'height: 45px;'
            ])->label(false) ?>
        </div>
    </div>

    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 text-right">
            <?= Html::button('<i class="fa fa-arrow-left"></i> Regresar', [
                'class' => 'btn btn-default btn-redondo',
                'data-dismiss' => 'modal',
                'style' => 'background: #F1F5F9; color: #475569; margin-right: 10px;'
            ]) ?>
            <?= Html::submitButton('<i class="fa fa-check"></i> Guardar Asignación', [
                'class' => 'btn btn-primary btn-redondo',
                'style' => 'background: #10B981;'
            ]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if ($registros): ?>
        <hr style="border-top: 1px solid #F1F5F9; margin: 30px 0;">
        <h4 style="font-weight: bold; color: #1B242D; margin-bottom: 20px;">Historial de Asignaciones</h4>
        
        <div style="overflow-x: auto; border: 1px solid #F1F5F9;">
            <table class="table-historial">
                <thead>
                    <tr>
                        <th style="width: 20%;">Fecha</th>
                        <th style="width: 40%;">Conductor</th>
                        <th style="width: 40%;">Observación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registros as $reg): ?>
                        <tr>
                            <td style="font-weight: bold;">
                                <?= date('d-m-Y', strtotime($reg['fecha_asignacion'])) ?>
                            </td>
                            <td>
                                <?php
                                $conductor = VConductores::find()->where(['id' => $reg['id_conductor']])->one();
                                echo $conductor ? $conductor->datos : '<span class="text-danger">No encontrado</span>';
                                ?>
                            </td>
                            <td style="font-size: 9pt; font-style: italic;">
                                <?php
                                $movflota = MovFlota::find()->where(['id_accion' => $reg['id_asignacion']])->one();
                                echo $movflota ? $movflota->observacion : 'Sin observaciones';
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>