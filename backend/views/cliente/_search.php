<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ClienteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cliente-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_cliente') ?>

    <?= $form->field($model, 'id_tipo_cliente') ?>

    <?= $form->field($model, 'cedula') ?>

    <?= $form->field($model, 'nombre_apellido') ?>

    <?= $form->field($model, 'rif') ?>

    <?php // echo $form->field($model, 'razon_social') ?>

    <?php // echo $form->field($model, 'telefono_principal') ?>

    <?php // echo $form->field($model, 'telefono_alterno') ?>

    <?php // echo $form->field($model, 'correo') ?>

    <?php // echo $form->field($model, 'id_estado') ?>

    <?php // echo $form->field($model, 'id_municipio') ?>

    <?php // echo $form->field($model, 'id_parroquia') ?>

    <?php // echo $form->field($model, 'direccion') ?>

    <?php // echo $form->field($model, 'empresa') ?>

    <?php // echo $form->field($model, 'id_referido') ?>

    <?php // echo $form->field($model, 'lugar_contacto') ?>

    <?php // echo $form->field($model, 'id_nos_conoce') ?>

    <?php // echo $form->field($model, 'fecha_cumpleanos') ?>

    <?php // echo $form->field($model, 'viaja_frecuente') ?>

    <?php // echo $form->field($model, 'recibir_correo') ?>

    <?php // echo $form->field($model, 'cliente_grato') ?>

    <?php // echo $form->field($model, 'id_categoria') ?>

    <?php // echo $form->field($model, 'id_proyecto') ?>

    <?php // echo $form->field($model, 'id_usuario') ?>

    <?php // echo $form->field($model, 'fecha_registro') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
