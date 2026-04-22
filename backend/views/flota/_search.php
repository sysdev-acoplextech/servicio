<?php

use backend\models\BaseTipoVehiculo;
use backend\models\CondicionFlota;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\FlotaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="flota-search">
    <div class="modal fade" id="modal-default2">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><span class="fa fa-search-plus"></span>&nbsp; <b>Búsqueda Avanzada de la Flota</b></h4>
                </div>
                <div class="modal-body">
                    <?php $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'get',
                    ]); ?>

                    <div class="col-md-6">
                        <?php
                        $tipo = BaseTipoVehiculo::find()->all();
                        $listipo = ArrayHelper::map($tipo, 'id', 'nombre_tipo_vehiculo');
                        echo $form->field($model, 'id_tipo_vehiculo')->widget(Select2::classname(), [
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
                    <div class="col-md-6">
                        <?php
                        $tipo = CondicionFlota::find()->all();
                        $listipo = ArrayHelper::map($tipo, 'id', 'nombre_condicion_flota');
                        echo $form->field($model, 'id_condicion')->widget(Select2::classname(), [
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

<div class="col-md-6">
                        <?php
                        echo $form->field($model, 'tercerizado')->widget(SwitchInput::classname(), [
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

                    <?= $form->field($model, 'id_marca') ?>

                    <?php // echo $form->field($model, 'id_modelo') 
                    ?>

                    <?php // echo $form->field($model, 'placa') 
                    ?>

                    <?php // echo $form->field($model, 'id_estado') 
                    ?>

                    <?php // echo $form->field($model, 'id_municipio') 
                    ?>

                    <?php // echo $form->field($model, 'id_parroquia') 
                    ?>

                    <?php // echo $form->field($model, 'asignado')->checkbox() 
                    ?>

                    <?php // echo $form->field($model, 'gerencia') 
                    ?>

                    <?php // echo $form->field($model, 'nombre_gerente') 
                    ?>

                    <?php // echo $form->field($model, 'fecha_asignacion') 
                    ?>

                    <?php // echo $form->field($model, 'fecha_registro') 
                    ?>

                    <?php // echo $form->field($model, 'id_usuario') 
                    ?>

                    <div class="box-footer">
                        <div class="box-tools pull-right">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-chevron-left"></span> <b> Cancelar</b></button>&nbsp;
                                <?= Html::a('<span class="glyphicon glyphicon-erase"></span><b> Limpiar</b>', [$ruta], ['class' => 'btn btn-default']); ?>
                                <?= Html::submitButton(Yii::t('app', '<span class="fa fa-search-plus"></span><b> Buscar</b>'), ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>