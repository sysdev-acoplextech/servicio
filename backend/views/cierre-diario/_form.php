<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CierreDiario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cierre-diario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha_cierre')->textInput() ?>

    <?= $form->field($model, 'numero_cuenta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'saldo_sistema')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'saldo_bancario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'diferencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_operador')->textInput() ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
