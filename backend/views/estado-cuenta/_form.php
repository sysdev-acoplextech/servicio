<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\FinancieroEstadoCuenta $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="financiero-estado-cuenta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha_transaccion')->textInput() ?>

    <?= $form->field($model, 'referencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'monto')->textInput() ?>

    <?= $form->field($model, 'operador')->textInput() ?>

    <?= $form->field($model, 'fecha_registro')->textInput() ?>

    <?= $form->field($model, 'hora')->textInput() ?>

    <?= $form->field($model, 'conciliado')->checkbox() ?>

    <?= $form->field($model, 'eliminado')->textInput() ?>

    <?= $form->field($model, 'numero_cuenta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo_transaccion')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
