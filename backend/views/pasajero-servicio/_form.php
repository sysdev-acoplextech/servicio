<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PasajeroServicio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pasajero-servicio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_servicio')->textInput() ?>

    <?= $form->field($model, 'hora')->textInput() ?>

    <?= $form->field($model, 'origen')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'destino')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
