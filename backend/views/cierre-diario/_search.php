<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CierreDiarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cierre-diario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idcierre') ?>

    <?= $form->field($model, 'fecha_cierre') ?>

    <?= $form->field($model, 'numero_cuenta') ?>

    <?= $form->field($model, 'saldo_sistema') ?>

    <?= $form->field($model, 'saldo_bancario') ?>

    <?php // echo $form->field($model, 'diferencia') ?>

    <?php // echo $form->field($model, 'id_operador') ?>

    <?php // echo $form->field($model, 'observaciones') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
