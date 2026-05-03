<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CotizacionRapidaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cotizacion-rapida-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_cotizacion') ?>

    <?= $form->field($model, 'cliente_nombre') ?>

    <?= $form->field($model, 'telefono') ?>

    <?= $form->field($model, 'fecha_servicio') ?>

    <?= $form->field($model, 'hora_servicio') ?>

    <?php // echo $form->field($model, 'id_tarifario') ?>

    <?php // echo $form->field($model, 'ruta_detalle') ?>

    <?php // echo $form->field($model, 'id_tipo_vehiculo') ?>

    <?php // echo $form->field($model, 'forma_pago') ?>

    <?php // echo $form->field($model, 'adicionales_json') ?>

    <?php // echo $form->field($model, 'monto_base') ?>

    <?php // echo $form->field($model, 'monto_recargo') ?>

    <?php // echo $form->field($model, 'monto_viatico') ?>

    <?php // echo $form->field($model, 'monto_total') ?>

    <?php // echo $form->field($model, 'creado_el') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
