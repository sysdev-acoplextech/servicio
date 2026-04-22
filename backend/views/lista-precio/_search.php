<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ListaPrecioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lista-precio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_lista') ?>

    <?= $form->field($model, 'id_variable') ?>

    <?= $form->field($model, 'monto') ?>

    <?= $form->field($model, 'id_moneda') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
