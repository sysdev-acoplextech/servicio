<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Pasajero */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pasajero-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-widget widget-user-2">
        <div class="box box-purple">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">

                        <?= $form->field($model, 'nombre_apellido')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="form-group">
                    <div class="box-tools pull-right">
                        <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> <b>Regresar</b>', ['index'], ['class' => 'btn btn-warning btn']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> <b>Guardar</b>', ['class' => 'btn btn-primary btn']) ?>
                    </div>
                </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
    </div>