<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseMetodosPago */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="base-metodos-pago-form">

    <div class="rango-form">
        <div class="box box-widget widget-user-2">
            <div class="box box-primary">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-sm-3">

                            <?= $form->field($model, 'nombre_metodo')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($model, 'num_cuenta')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($model, 'banco')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-3">

                        <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">

                                <?= $form->field($model, 'identificacion')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                            </div>
                
                            <div class="col-sm-3">
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
        </div>