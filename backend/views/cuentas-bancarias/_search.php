<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CuentasBancariasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cuentas-bancarias-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_cuentas') ?>

    <?= $form->field($model, 'numero_cuenta') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'estatus') ?>

    <?= $form->field($model, 'id_usuario') ?>

    <?php // echo $form->field($model, 'fecha_registro') ?>

    <?php // echo $form->field($model, 'hora') ?>

    <?php // echo $form->field($model, 'id_banco') ?>

    <?php // echo $form->field($model, 'id_tipo_moneda') ?>

    <?php // echo $form->field($model, 'id_tipo_cuenta') ?>

    <?php // echo $form->field($model, 'saldo') ?>

    <?php // echo $form->field($model, 'fecha_saldo_inicial') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
