<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseMetodosPagoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="base-metodos-pago-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_metodo') ?>

    <?= $form->field($model, 'nombre_metodo') ?>

    <?= $form->field($model, 'num_cuenta') ?>

    <?= $form->field($model, 'banco') ?>

    <?= $form->field($model, 'telefono') ?>

    <?php // echo $form->field($model, 'identificacion') ?>

    <?php // echo $form->field($model, 'estatus')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
