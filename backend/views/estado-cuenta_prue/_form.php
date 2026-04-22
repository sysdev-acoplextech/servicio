<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EstadoCuenta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estado-cuenta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha_transaccion')->textInput() ?>

    <?= $form->field($model, 'referencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'monto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'operador')->textInput() ?>

    <?= $form->field($model, 'fecha_registro')->textInput() ?>

    <?= $form->field($model, 'hora')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'conciliado')->textInput() ?>

    <?= $form->field($model, 'eliminado')->textInput() ?>

    <?= $form->field($model, 'numero_cuenta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo_transaccion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_categoria')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
