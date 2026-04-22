<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EstadoCuentaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estado-cuenta-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idestado_cuenta') ?>

    <?= $form->field($model, 'fecha_transaccion') ?>

    <?= $form->field($model, 'referencia') ?>

    <?= $form->field($model, 'monto') ?>

    <?= $form->field($model, 'operador') ?>

    <?php // echo $form->field($model, 'fecha_registro') ?>

    <?php // echo $form->field($model, 'hora') ?>

    <?php // echo $form->field($model, 'conciliado') ?>

    <?php // echo $form->field($model, 'eliminado') ?>

    <?php // echo $form->field($model, 'numero_cuenta') ?>

    <?php // echo $form->field($model, 'tipo_transaccion') ?>

    <?php // echo $form->field($model, 'id_categoria') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
