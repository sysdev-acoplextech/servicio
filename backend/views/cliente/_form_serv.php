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
use yii\web\JsExpression;
use kartik\switchinput\SwitchInput;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model backend\models\Cliente */
/* @var $form yii\widgets\ActiveForm */


$municipio = [];
$parroquia = [];
if ($model->id_estado) {

    $municipio = ArrayHelper::map(GeoMunicipio::find()->where(['id_estado' => $model->id_estado])->all(), 'id_municipio', 'nombre');
}

?>



<script type="text/javascript">
    function mismo() {
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
                <div class="row">
                    <div class="col-sm-12">
                        <fieldset>
                            <legend>Datos Básicos</legend>
                            <div class="row" id="particular" style="display: block;">
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'cedula_rif_serv')->textInput(['id' => 'cedula_rif_serv','maxlength' => true])->label('Cédula/RIF'); ?>
                                </div>
                                <div class="col-sm-6">
                                    
                                    <?php
                                        $data = Cliente::find()
                                        ->select(['nombre_apellido as value', 'nombre_apellido as label', 'id_cliente as id',
                                         'cedula','telefono_principal', 'id_tipo_cliente','telefono_alterno','correo',
                                         'direccion'])
                                        ->asArray()
                                        ->all();

                                    ?>

                                    <?= $form->field($model, 'nombre_apellido')->widget(\yii\jui\AutoComplete::classname(), [
                                        'clientOptions' => [
                                            'source' => $data,
                                            'autoFill' => true,
                                            'class' => 'form-control',
                                            'minLength' => '1',
                                            'select' => new JsExpression("function( event, ui ) {
                                                            var str = ui.item.label;
                                                            var matches = str.match(/[A-Z]/g);
                                                            var acronym = matches.join('');
                                                            $('#nombre_apellido').val(ui.item.nombre_apellido);
                                                            $('#telefono_principal').val(ui.item.telefono_principal);
                                                            $('#direccion').val(ui.item.direccion);
                                                            $('#correo').val(ui.item.correo);
                                                            $('#cedula_rif_serv').val(ui.item.cedula);
                                                            $('#telefono_alterno').val(ui.item.telefono_alterno);
                                                            }")
                                        ],
                                        'options' => [
                                            'class' => 'form-control'
                                        ]
                                    ]) ?>

                                </div>
                            </div>
                            <div class="row" id="empresa" style="display: none;">
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'rif')->textInput(['maxlength' => true])->label('RIF'); ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'razon_social')->textInput()->label('Razón Social'); ?>

                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'telefono_principal')->textInput(['id' => 'telefono_principal','maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'telefono_alterno')->textInput(['id' => 'telefono_alterno','maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'correo')->textInput(['id' => 'correo','maxlength' => true]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'direccion')->textarea(['id' => 'direccion','rows' => 2]) ?>
                    </div>
                </div>

                <div class="row" id="proyecto" style="display: none;">
                    <div class="col-sm-12">
                        <fieldset>
                            <legend>Clientes por Proyectos</legend>
                            <div class="alert alert-success" role="alert">
                                Datos exclusivos para clientes por proyecto relacionados a la gestión de servicio y de cobro
                            </div>
                            <fieldset>
                                <legend>Persona autorizada para solicitar servicios:

                                </legend>
                                <?= $form->field($model, 'mismapersona')->checkbox(['onclick' => 'mismo()', 'id' => 'mismapersona']) ?>
                                <div class="col-sm-4">
                                    <?= $form->field($model2, 'nombre_autorizada_servicio')->textInput(['maxlength' => true, 'id' => 'aaaa']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'telefono_p_autorizada_servicio')->textInput(['maxlength' => true, 'id' => 'telefono_p_autorizada_servicio']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'telefono_a_autorizada_servicio')->textInput(['maxlength' => true, 'id' => 'telefono_a_autorizada_servicio']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'correo_persona_autorizada')->textInput(['id' => 'correo_persona_autorizada']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'cargo')->textInput(['id' => 'cargo']); ?>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Persona de contacto relacionado a la gestión de cobro:</legend>
                                <div class="col-sm-4">
                                    <?= $form->field($model2, 'nombre_contacto_paga')->textInput(['maxlength' => true, 'id' => 'bbbb']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'telefono_p_paga')->textInput(['maxlength' => true, 'id' => 'telefono_p_paga']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'telefono_a_paga')->textInput(['maxlength' => true, 'id' => 'telefono_a_paga']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'correo_paga')->textInput(['id' => 'correo_paga']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($model2, 'cargo_paga')->textInput(['maxlength' => true, 'id' => 'cargo_paga']); ?>
                                </div>
                                <div class="col-sm-12">
                                    <?= $form->field($model2, 'correo_envio_retenciones')->textInput(); ?>
                                </div>
                            </fieldset>
                        </fieldset>
                    </div>
                </div>




            </div>