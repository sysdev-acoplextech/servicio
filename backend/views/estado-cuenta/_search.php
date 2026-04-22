<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\FinancieroEstadoCuentaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="financiero-estado-cuenta-search">

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

    <?php // echo $form->field($model, 'conciliado')->checkbox() ?>

    <?php // echo $form->field($model, 'eliminado') ?>

    <?php // echo $form->field($model, 'numero_cuenta') ?>

    <?php // echo $form->field($model, 'tipo_transaccion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
