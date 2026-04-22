<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VariablesServicioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="variables-servicio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_variable') ?>

    <?= $form->field($model, 'nombre_variable') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'estatus') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
