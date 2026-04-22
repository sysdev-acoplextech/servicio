<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ConductorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="conductor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cedula') ?>

    <?= $form->field($model, 'nacionalidad') ?>

    <?= $form->field($model, 'nombres') ?>

    <?= $form->field($model, 'apellidos') ?>

    <?php // echo $form->field($model, 'telefono_principal') ?>

    <?php // echo $form->field($model, 'telefono_alterno') ?>

    <?php // echo $form->field($model, 'correo') ?>

    <?php // echo $form->field($model, 'fecha_ingreso') ?>

    <?php // echo $form->field($model, 'fecha_egreso') ?>

    <?php // echo $form->field($model, 'foto') ?>

    <?php // echo $form->field($model, 'estatus') ?>

    <?php // echo $form->field($model, 'id_usuario') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
