<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use backend\models\Banco;
use backend\models\TipoMoneda;
use backend\models\TipoCuenta;

/* @var $this yii\web\View */
/* @var $model backend\models\CuentasBancarias */
/* @var $form yii\widgets\ActiveForm */

$this->registerCss("
    /* Estilo del Formulario: Bordes Rectos e Inputs Limpios */
    .form-control {
        border-radius: 0px !important;
        border: 1px solid #D1D5DB;
        padding: 10px;
        height: auto;
    }
    .form-control:focus {
        border-color: #1B242D;
        box-shadow: none;
    }
    .select2-container--krajee .select2-selection {
        border-radius: 0px !important;
    }
    
    /* Etiquetas con estilo moderno */
    label {
        font-weight: bold;
        color: #4B5563;
        font-size: 9pt;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    /* Botón Redondeado Estilo Misacdi */
    .btn-guardar {
        border-radius: 15px !important;
        padding: 12px 35px;
        font-weight: bold;
        background-color: #EA4C2D;
        border: none;
        color: white;
        box-shadow: 0 4px 10px rgba(234, 76, 45, 0.2);
        transition: 0.3s;
    }
    .btn-guardar:hover {
        background-color: #D63D1F;
        transform: translateY(-2px);
    }
");
?>

<div class="cuentas-bancarias-form" style="background: #FFF; padding: 25px; border-radius: 20px;">

    <?php $form = ActiveForm::begin([
        'id' => 'form-cuentas-bancarias',
        'options' => ['data-pjax' => true]
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'id_banco')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Banco::find()->all(), 'idbanco', 'nom_banco'),
                'options' => ['placeholder' => 'Seleccione Banco...'],
                'pluginOptions' => ['allowClear' => true],
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'numero_cuenta')->textInput([
                'maxlength' => true, 
                'placeholder' => 'Ej: 0134-XXXX-XXXX-XXXX'
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'descripcion')->textInput([
                'maxlength' => true,
                'placeholder' => 'Ej: Cuenta Principal de Ingresos'
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'id_tipo_moneda')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(TipoMoneda::find()->all(), 'id_tipo_moneda', 'moneda'),
                'options' => ['placeholder' => 'Moneda...'],
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'id_tipo_cuenta')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(TipoCuenta::find()->all(), 'id_tipo_cuenta', 'nombre_tipo_cuenta'),
                'options' => ['placeholder' => 'Tipo de Cuenta...'],
            ]) ?>
        </div>
        <div class="col-md-4">
             <?= $form->field($model, 'estatus')->widget(Select2::classname(), [
                'data' => [1 => 'ACTIVO', 0 => 'INACTIVO'],
                'options' => ['placeholder' => 'Estado...'],
            ]) ?>
        </div>
    </div>

    <div class="row" style="background: #F9FAFB; padding: 20px; border-radius: 15px; margin: 10px 0 25px 0; border: 1px dashed #D1D5DB;">
        <div class="col-md-6">
            <?= $form->field($model, 'saldo')->textInput([
                'maxlength' => true,
                'style' => 'font-weight: bold; font-size: 14pt; color: #10B981; text-align: right;',
                'placeholder' => '0.00'
            ])->label('SALDO INICIAL / ACTUAL') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'fecha_saldo_inicial')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Seleccione fecha...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ]
            ]) ?>
        </div>
    </div>

    <div class="form-group text-right">
        <?= Html::submitButton('<i class="fa fa-save"></i> GUARDAR REGISTRO BANCARIO', [
            'class' => 'btn btn-guardar'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
// Script para formatear el número mientras se escribe (opcional)
$this->registerJs("
    // Lógica adicional para asegurar que el input de saldo use el formato correcto si es necesario
");
?>