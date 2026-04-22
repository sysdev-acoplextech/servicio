<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoriaGastosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categoria-gastos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_categoria_gasto') ?>

    <?= $form->field($model, 'nombre_categoria') ?>

    <?= $form->field($model, 'estatus') ?>

    <?= $form->field($model, 'id_fondo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
