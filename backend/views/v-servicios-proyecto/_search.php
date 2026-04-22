<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VServiciosProyectoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vservicios-proyecto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_servicio') ?>

    <?= $form->field($model, 'fecha_registro') ?>

    <?= $form->field($model, 'id_tipo_vehiculo') ?>

    <?= $form->field($model, 'id_tipo_traslado_ruta') ?>

    <?= $form->field($model, 'id_cliente') ?>

    <?php // echo $form->field($model, 'id_tipo_cliente') ?>

    <?php // echo $form->field($model, 'cedula') ?>

    <?php // echo $form->field($model, 'nombre_apellido') ?>

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

    <?php // echo $form->field($model, 'nuevo') ?>

    <?php // echo $form->field($model, 'fecha_servicio') ?>

    <?php // echo $form->field($model, 'km_servicio') ?>

    <?php // echo $form->field($model, 'monto') ?>

    <?php // echo $form->field($model, 'id_conductor') ?>

    <?php // echo $form->field($model, 'id_flota') ?>

    <?php // echo $form->field($model, 'id_estatus') ?>

    <?php // echo $form->field($model, 'observacion_inicial') ?>

    <?php // echo $form->field($model, 'id_usuario') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
