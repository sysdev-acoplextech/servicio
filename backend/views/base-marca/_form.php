<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseMarca */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="base-marca-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_marca')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estatus')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
