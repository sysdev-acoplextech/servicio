<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ServicioPagoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="servicio-pago-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pago') ?>

    <?= $form->field($model, 'id_servicio') ?>

    <?= $form->field($model, 'fecha_pago') ?>

    <?= $form->field($model, 'monto') ?>

    <?= $form->field($model, 'referencia') ?>

    <?php // echo $form->field($model, 'tipo_pago') ?>

    <?php // echo $form->field($model, 'id_metodo') ?>

    <?php // echo $form->field($model, 'banco_origen') ?>

    <?php // echo $form->field($model, 'procedencia') ?>

    <?php // echo $form->field($model, 'observacion_pago') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
