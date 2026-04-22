<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VServiciosProyecto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vservicios-proyecto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_servicio')->textInput() ?>

    <?= $form->field($model, 'fecha_registro')->textInput() ?>

    <?= $form->field($model, 'id_tipo_vehiculo')->textInput() ?>

    <?= $form->field($model, 'id_tipo_traslado_ruta')->textInput() ?>

    <?= $form->field($model, 'id_cliente')->textInput() ?>

    <?= $form->field($model, 'id_tipo_cliente')->textInput() ?>

    <?= $form->field($model, 'cedula')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre_apellido')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefono_principal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefono_alterno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_estado')->textInput() ?>

    <?= $form->field($model, 'id_municipio')->textInput() ?>

    <?= $form->field($model, 'id_parroquia')->textInput() ?>

    <?= $form->field($model, 'direccion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'empresa')->textInput() ?>

    <?= $form->field($model, 'id_referido')->textInput() ?>

    <?= $form->field($model, 'lugar_contacto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_nos_conoce')->textInput() ?>

    <?= $form->field($model, 'fecha_cumpleanos')->textInput() ?>

    <?= $form->field($model, 'viaja_frecuente')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recibir_correo')->textInput() ?>

    <?= $form->field($model, 'cliente_grato')->textInput() ?>

    <?= $form->field($model, 'id_categoria')->textInput() ?>

    <?= $form->field($model, 'id_proyecto')->textInput() ?>

    <?= $form->field($model, 'nuevo')->textInput() ?>

    <?= $form->field($model, 'fecha_servicio')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'km_servicio')->textInput() ?>

    <?= $form->field($model, 'monto')->textInput() ?>

    <?= $form->field($model, 'id_conductor')->textInput() ?>

    <?= $form->field($model, 'id_flota')->textInput() ?>

    <?= $form->field($model, 'id_estatus')->textInput() ?>

    <?= $form->field($model, 'observacion_inicial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_usuario')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
