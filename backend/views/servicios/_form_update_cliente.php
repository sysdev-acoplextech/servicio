<?php

use backend\models\BaseTipoVehiculo;
use backend\models\Cliente;
use backend\models\Estatus;
use backend\models\ListaPrecio;
use backend\models\Pasajero;
use backend\models\ServicioVariables;
use backend\models\Tarifario;
use backend\models\TipoRuta;
use backend\models\TipoTrasladoRuta;
use backend\models\User;
use backend\models\VariablesServicio;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\touchspin\TouchSpin;
use yii\web\JsExpression;
use kartik\date\DatePicker;
use kartik\widgets\TimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Servicios */
/* @var $form yii\widgets\ActiveForm */

$tarifario_base = Tarifario::find()->one();
$this->registerJsFile('@web/js/solicitudes.js');

?>
<?php $form = ActiveForm::begin([
            'action' => ['modificar-cliente', 'id' => $_GET['id']],
            'method' => 'post',
        ]); ?>

<div class="box box-widget widget-user-2">

    <div class="box box-primary">
        <div class="box-body">
            <div class="col-md-12">

                    <div class="row">
                       
                        <div class="col-md-12">
                            <fieldset>
                                <legend>Datos Básicos</legend>
                                <div class="row" id="particular" style="display: block;">
                                    <?php
                                    $data = Cliente::find()
                                        ->select([
                                            'nombre_apellido as value',
                                            'nombre_apellido as label',
                                            'id_cliente as id',
                                            'cedula',
                                            'telefono_principal',
                                            'id_tipo_cliente',
                                            'telefono_alterno',
                                            'correo',
                                            'direccion',
                                            'cliente_grato' => new \yii\db\Expression("CASE 
                                                WHEN cliente_grato =1 THEN 'NO GRATO' 
                                                WHEN cliente_grato =0 THEN 'GRATO' 
                                                WHEN cliente_grato is NULL THEN 'GRATO' 
                                            END")
                                        ])
                                        ->asArray()
                                        ->all();
                                    ?>

                                    <div class="col-sm-6">
                                        <?= $form->field($model3, 'cedula')->textInput(['id' => 'cedula', 'maxlength' => true])->label('Cédula/RIF'); ?>
                                    </div>
                                    <div class="col-sm-6">

                                        <?= $form->field($model3, 'nombre_apellido')->widget(\yii\jui\AutoComplete::classname(), [
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
                                            $('#cedula').val(ui.item.cedula);
                                            $('#telefono_principal').val(ui.item.telefono_principal);
                                            $('#direccion').val(ui.item.direccion);
                                            $('#correo').val(ui.item.correo);
                                            $('#cedula_rif_serv').val(ui.item.cedula);
                                            $('#telefono_alterno').val(ui.item.telefono_alterno);
                                            $('#cliente_grato').val(ui.item.cliente_grato);

                                            if (ui.item.cliente_grato === 'NO GRATO') {
                                                $('#div_cliente_no_grato').text('CLIENTE NO GRATO');
                                            } else {
                                                $('#div_cliente_no_grato').text(''); // Limpiar el div si es cliente grato
                                            }
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
                                        <?= $form->field($model3, 'rif')->textInput(['maxlength' => true])->label('RIF'); ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= $form->field($model3, 'razon_social')->textInput()->label('Razón Social'); ?>

                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12" id="div_cliente_no_grato"
                            style="color: red;  font-weight: bold;
                                font-size: 20px;
                                padding: 10px;
                                ">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <?= $form->field($model3, 'telefono_principal')->textInput(['id' => 'telefono_principal', 'maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model3, 'telefono_alterno')->textInput(['id' => 'telefono_alterno', 'maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model3, 'correo')->textInput(['id' => 'correo', 'maxlength' => true]) ?>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model3, 'direccion')->textarea(['id' => 'direccion', 'rows' => 2]) ?>
                        </div>
                    </div>


                <div class="form-group">
                    <div class="box-tools pull-right">
                        <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> <b>Regresar</b>', ['index'], ['class' => 'btn btn-warning btn']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> <b>Guardar</b>', ['class' => 'btn btn-primary btn']) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<?php ActiveForm::end(); ?>
</div>