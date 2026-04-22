<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ServiciosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="servicios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_servicio') ?>

    <?= $form->field($model, 'fecha_registro') ?>

    <?= $form->field($model, 'id_tipo_vehiculo') ?>

    <?= $form->field($model, 'id_tipo_traslado_ruta') ?>

    <?= $form->field($model, 'id_cliente') ?>

    <?php // echo $form->field($model, 'fecha_servicio') ?>

    <?php // echo $form->field($model, 'km_servicio') ?>

    <?php // echo $form->field($model, 'monto') ?>

    <?php // echo $form->field($model, 'id_conductor') ?>

    <?php // echo $form->field($model, 'id_flota') ?>

    <?php // echo $form->field($model, 'id_estatus') ?>

    <?php // echo $form->field($model, 'observacion_inicial') ?>

    <?php // echo $form->field($model, 'id_usuario') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
