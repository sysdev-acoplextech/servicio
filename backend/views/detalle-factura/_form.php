<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DetalleFactura */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalle-factura-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'num_factura')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_factura')->textInput() ?>

    <?= $form->field($model, 'observacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'monto_facturado')->textInput() ?>

    <?= $form->field($model, 'id_servicios')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subtotal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iva')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tasa_dia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_emision')->textInput() ?>

    <?= $form->field($model, 'monto_bs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_cliente')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
