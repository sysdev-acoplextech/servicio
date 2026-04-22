<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model backend\models\VariablesServicio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="variables-servicio-form">
    <div class="box box-widget widget-user-2">
        <div class="box box-primary">
            <div class="box-body">
                <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'nombre_variable')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-12">
                        <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?php
                        echo $form->field($model, 'estatus')->widget(SwitchInput::classname(), [
                            'type' => SwitchInput::CHECKBOX,
                            'pluginOptions' => [
                                'handleWidth' => 60,
                                'offColor' => 'danger',
                                'onColor' => 'success',
                                'onText' => 'SI',
                                'offText' => 'NO'
                            ]
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="box-tools pull-right">
                        <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> <b>Regresar</b>', ['index'], ['class' => 'btn btn-warning btn']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> <b>Guardar</b>', ['class' => 'btn btn-primary btn']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>