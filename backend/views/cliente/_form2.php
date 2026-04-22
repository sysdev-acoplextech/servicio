<?php

use backend\models\BaseNosConoce;
use backend\models\BaseTipoCliente;
use backend\models\Cliente;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use backend\models\GeoEstado;
use backend\models\GeoMunicipio;
use backend\models\GeoParroquia;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Cliente */
/* @var $form yii\widgets\ActiveForm */


$municipio = [];
$parroquia = [];
if ($model->id_estado) {

    $municipio = ArrayHelper::map(GeoMunicipio::find()->where(['id_estado' => $model->id_estado])->all(), 'id', 'nombre_municipio');

}

if ($model->id_municipio) {
    $parroquia = ArrayHelper::map(GeoParroquia::find()->where(['id_municipio' => $model->id_municipio])->all(), 'id', 'nombre_parroquia');
}


//Muestra de div de los Datos del cliente
if (empty($model->id_tipo_cliente)) {
    $muestra1='none';
    $muestra2='none';
    $muestra3='none';
} else{
    switch ($model->id_tipo_cliente) {
        case '1':
            $muestra1='block';
            $muestra2='none';
            $muestra3='none';
            break;
        case '3':
            $muestra1='none';
            $muestra2='block';
            $muestra3='none';
            break;
        case '2':
            $muestra1='none';
            $muestra2='block';
            $muestra3='block';
            break;
       
    }
    
}


?>

<script type="text/javascript">
    function mismo(){
        document.getElementById('bbbb').value = document.getElementById('aaaa').value;
        document.getElementById('telefono_p_paga').value = document.getElementById('telefono_p_autorizada_servicio').value;
        document.getElementById('telefono_a_paga').value = document.getElementById('telefono_a_autorizada_servicio').value;
        document.getElementById('correo_paga').value = document.getElementById('correo_persona_autorizada').value;
        document.getElementById('cargo_paga').value = document.getElementById('cargo').value;
    }
    </script>

<div class="cliente-form">
    <div class="box box-widget widget-user-2">
        <div class="box box-primary">
            <div class="box-body">
                <?php $form = ActiveForm::begin(); ?>
                <div class="row">

                    <div class="col-sm-12">

                        <?php
                        $tipo = BaseTipoCliente::find()->all();
                        $listipo = ArrayHelper::map($tipo, 'id', 'nombre_tipo_cliente');
                        echo $form->field($model, 'id_tipo_cliente')->widget(Select2::classname(), [
                            'data' => $listipo,
                            'pluginLoading' => false,
                            'value' => null,
                            'options' => ['placeholder' => 'Seleccione...'],
                            'pluginEvents' => [
                                "select2:select" => "function() { 
                                var selectedIds = $(this).val();
                                    if (selectedIds == 1 || selectedIds == 2) {
                                        $('#particular').show();
                                        $('#empresa').hide();
                                        $('#proyecto').hide();
                                    }
                                     if (selectedIds == 2) {
                                        $('#particular').hide();
                                        $('#empresa').show();
                                        $('#proyecto').show();
                                    }
                                     if (selectedIds == 3) {
                                        $('#particular').hide();
                                        $('#empresa').show();
                                        $('#proyecto').hide();
                                    }
                                }",
                            ],
                            'pluginOptions' => [
                                'multiple' => false,
                                'allowClear' => true,
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <fieldset>
                            <legend>Datos Básicos</legend>
                            <div class="row" id="particular" style="display: <?php echo $muestra1?>">
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'cedula')->textInput(['maxlength' => true])->label('Cédula'); ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'nombre_apellido')->textInput()->label('Nombre y apellido'); ?>
                                </div>
                            </div>
                            <div class="row" id="empresa" style="display:  <?=$muestra2?>">
                                <?php 
                                    if( ($model->id_tipo_cliente==2) || ($model->id_tipo_cliente==3) ){ ?>
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'rif')->textInput(['maxlength' => true, 'value'=> $model->cedula])->label('RIF'); ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'razon_social')->textInput(['maxlength' => true, 'value'=> $model->nombre_apellido])->label('Razón Social'); ?>

                                </div>
                                <?php 
                                }
                                ?>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'telefono_principal')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'telefono_alterno')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'correo')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-4">
                            <?php
                            $tipo = GeoEstado::find()->where(['not in', 'id', [24]])->orderBy(['nombre' => SORT_ASC])->all();
                            $listipo = ArrayHelper::map($tipo, 'id', 'nombre');
                            echo $form->field($model, 'id_estado')->widget(Select2::classname(), [
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
                        <div class="col-md-4">
                        <?php 
                            echo $form->field($model, 'id_municipio')->widget(DepDrop::classname(), [
                                'type' => DepDrop::TYPE_SELECT2,
                                'options' => [
                                    'placeholder' => 'Seleccione...',
                                    'multiple' => false,
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                ],
                                'data' => [$municipio], // ensure at least the preselected value is available
                                'pluginOptions' => [
                                    'depends' => [Html::getInputId($model, 'id_estado')], // the id for cat attribute
                                    'url' => Url::to(['/flota/dep-municipio'])
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php
                            echo $form->field($model, 'id_parroquia')->widget(DepDrop::classname(), [
                                'type' => DepDrop::TYPE_SELECT2,
                                'options' => [
                                    'placeholder' => 'Seleccione...',
                                    'multiple' => false,
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                ],
                                'data' => [$parroquia],
                                'pluginOptions' => [
                                    'depends' => [Html::getInputId($model, 'id_municipio')],
                                    'url' => Url::to(['/flota/dep-parroquia'])
                                ]
                            ]);
                            ?>
                        </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'direccion')->textarea(['rows' => 2]) ?>
                        <?= $form->field($model, 'id_usuario')->hiddenInput(['maxlength' => true, 'value'=>$model->id_usuario])->label(false) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <fieldset>
                            <legend>Información de interés</legend>

                            <div class="row">
                                <div class="col-sm-3">
                                    <?php
                                    $tipo = Cliente::find()->all();
                                    $listipo = ArrayHelper::map($tipo, 'id_cliente', 'nombre_apellido');
                                    echo $form->field($model, 'id_referido')->widget(Select2::classname(), [
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
                                <div class="col-sm-3">
                                    <?= $form->field($model, 'lugar_contacto')->textInput(['maxlength' => true, 'value' => 'Venezuela']) ?>
                                </div>
                                <div class="col-sm-3">
                                    <?php
                                    $tipo = BaseNosConoce::find()->all();
                                    $listipo = ArrayHelper::map($tipo, 'id', 'nombre_nos_conoce');
                                    echo $form->field($model, 'id_nos_conoce')->widget(Select2::classname(), [
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
                                <div class="col-sm-3">
                                    <?php echo $form->field($model, 'fecha_cumpleanos')->widget(DatePicker::classname(), [
                                        'options' => ['placeholder' => 'Seleccione...'],
                                        'pluginOptions' => [
                                            'id' => 'fecha_cumpleanos',
                                            'autoclose' => true,
                                            'format' => 'dd-mm-yyyy',
                                            // 'startView' => 'year',
                                        ]
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'viaja_frecuente')->widget(Select2::classname(), [
                                        'data' =>
                                        [
                                            '1 a 3 veces al año' => '1 a 3 veces al año',
                                            '4 a 10 veces al año' => '4 a 10 veces al año',
                                            'Más de 10 veces al año' => 'Más de 10 veces al año',
                                        ],
                                        'options' => ['placeholder' => 'Seleccione...'],
                                        'pluginOptions' => [
                                            'multiple' => false,
                                            'allowClear' => true,
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <div class="col-sm-3">
                                    <?php
                                    echo $form->field($model, 'recibir_correo')->widget(SwitchInput::classname(), [
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
                                <div class="col-sm-3">
                                    <?php
                                    echo $form->field($model, 'cliente_grato')->widget(SwitchInput::classname(), [
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

                        </fieldset>
                    </div>
                </div>
                <div class="row" id="proyecto" style="display: <?=$muestra3?>;">
                    <?php if ($model->id_tipo_cliente==2){ ?>
                    <div class="col-sm-12">
                        <fieldset>
                            <legend>Clientes por Proyectos</legend>
                            <div class="alert alert-success" role="alert">
                                Datos exclusivos para clientes por proyecto relacionados a la gestión de servicio y de cobro
                            </div>
                            <fieldset>
                                <legend>Persona autorizada para solicitar servicios:</legend>
                                <?= $form->field($model, 'mismapersona')->checkbox(['onclick' => 'mismo()', 'id' => 'mismapersona']) ?>
                                <div class="col-sm-4">
                                    <?= $form->field($model2, 'nombre_autorizada_servicio')->textInput(['maxlength' => true, 'id'=>'aaaa']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'telefono_p_autorizada_servicio')->textInput(['maxlength' => true, 'id'=>'telefono_p_autorizada_servicio']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'telefono_a_autorizada_servicio')->textInput(['maxlength' => true, 'id'=>'telefono_a_autorizada_servicio']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'correo_persona_autorizada')->textInput(['id'=>'correo_persona_autorizada']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'cargo')->textInput(['id'=>'cargo']); ?>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Persona de contacto relacionado a la gestión de cobro:</legend>
                                <div class="col-sm-4">
                                    <?= $form->field($model2, 'nombre_contacto_paga')->textInput(['maxlength' => true, 'id'=>'bbbb']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'telefono_p_paga')->textInput(['maxlength' => true, 'id'=>'telefono_p_paga']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'telefono_a_paga')->textInput(['maxlength' => true, 'id'=>'telefono_a_paga']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'correo_paga')->textInput(['id'=>'correo_paga']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'cargo_paga')->textInput(['maxlength' => true,'id'=>'cargo_paga']); ?>
                                </div>
                                <div class="col-sm-12">
                                    <?= $form->field($model2, 'correo_envio_retenciones')->textInput(); ?>
                                </div>
                            </fieldset>
                        </fieldset>
                    </div>
                    <?php }?>
                </div>



                <div class="form-group">
                    <div class="box-tools pull-right">
                        <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> <b>Regresar</b>', ['index'], ['class' => 'btn btn-warning btn']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> <b>Guardar</b>', ['class' => 'btn btn-primary btn']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>