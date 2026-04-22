<?php

use backend\models\Moneda;
use backend\models\VariablesServicio;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\ListaPrecio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lista-precio-form">
    <div class="box box-widget widget-user-2">
        <div class="box box-primary">
            <div class="box-body">

                <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-sm-4">
                        <?php
                        $tipo = VariablesServicio::find()->orderBy(['nombre_variable'=>SORT_ASC])->all();
                        $listipo = ArrayHelper::map($tipo, 'id_variable', 'nombre_variable');
                        echo $form->field($model, 'id_variable')->widget(Select2::classname(), [
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
                        <?= $form->field($model, 'monto')->textInput() ?>
                    </div>
                    <div class="col-sm-4">

                    <?php
                        $tipo = Moneda::find()->where(['idestatus'=>TRUE])->orderBy(['nombre_moneda'=>SORT_ASC])->all();
                        $listipo = ArrayHelper::map($tipo, 'id_moneda', 'nombre_moneda');
                        echo $form->field($model, 'id_moneda')->widget(Select2::classname(), [
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