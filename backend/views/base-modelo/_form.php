<?php

use backend\models\BaseMarca;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseTipoVehiculo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="base-modelo-form">
    <div class="rango-form">
        <div class="box box-widget widget-user-2">
            <div class="box box-primary">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-sm-4">

                        <?php
                            $tipo = BaseMarca::find()->all();
                            $listipo = ArrayHelper::map($tipo, 'id', 'nombre_marca');
                            echo $form->field($model, 'id_marca')->widget(Select2::classname(), [
                                'data' => $listipo,
                                'pluginLoading' => false,
                                'value' => null,
                                'options' => ['placeholder' => 'Seleccione...'],
                                'pluginOptions' => [
                                    'multiple' => false,
                                    'allowClear' => true,
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-4">

                            <?= $form->field($model, 'nombre_modelo')->textInput(['maxlength' => true]) ?>
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
    </div>
</div>