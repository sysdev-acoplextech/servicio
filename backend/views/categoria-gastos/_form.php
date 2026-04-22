<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoriaGastos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categoria-gastos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_categoria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estatus')->textInput() ?>

    <?= $form->field($model, 'id_fondo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
