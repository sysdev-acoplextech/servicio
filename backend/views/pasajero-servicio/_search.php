<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PasajeroServicioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pasajero-servicio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pax_servicio') ?>

    <?= $form->field($model, 'id_servicio') ?>

    <?= $form->field($model, 'hora') ?>

    <?= $form->field($model, 'origen') ?>

    <?= $form->field($model, 'destino') ?>

    <?php // echo $form->field($model, 'fecha') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
