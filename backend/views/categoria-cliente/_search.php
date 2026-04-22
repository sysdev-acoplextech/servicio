<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoriaClienteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categoria-cliente-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_categoria') ?>

    <?= $form->field($model, 'nombre_categoria') ?>

    <?= $form->field($model, 'desde_viajes') ?>

    <?= $form->field($model, 'hasta_viajes') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'estatus') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
