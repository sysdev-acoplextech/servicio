<?php

use backend\models\Cliente;
use backend\models\ListaPrecio;
use backend\models\Pasajero;
use backend\models\Tarifario;
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

//Establecemos valores
$km_particular = $tarifario_base->km_particular;
$banda_1 = $tarifario_base->banda_1;
$banda_2 = $tarifario_base->banda_2;
$banda_3 = $tarifario_base->banda_3;
$mas_20 = $tarifario_base->mas_20;
$nocturno = $tarifario_base->nocturno;
$porc_camioneta_interior = $tarifario_base->porc_camioneta_interior;
$porc_camioneta_caracas = $tarifario_base->porc_camioneta_caracas;
$rango_banda_1 = $tarifario_base->rango_banda_1;
$rango_banda_2 = $tarifario_base->rango_banda_2;
$rango_banda_3 = $tarifario_base->rango_banda_3;


?>

<style type="text/css">
    .boton-imagen {
        display: inline-block;
        /* Permite que el enlace se comporte como un bloque */
        text-decoration: none;
        /* Elimina el subrayado del enlace */
        border-radius: 8px;
        /* Bordes redondeados */
        overflow: hidden;
        /* Asegura que el contenido no sobresalga */
        transition: transform 0.3s;
        /* Transición suave para el efecto hover */
    }

    .label_a {
        display: inline;
        padding: .2em .6em .3em;
        font-size: 100%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25em;

    }

    .boton-imagen img {
        display: block;
        /* Elimina el espacio debajo de la imagen */
        width: 100%;
        /* Ajusta la imagen al tamaño del contenedor */
        height: auto;
        /* Mantiene la proporción de la imagen */
    }

    .boton-imagen:hover {
        transform: scale(1.05);
        /* Aumenta ligeramente el tamaño al pasar el mouse */
    }

    .imagen-check {
        position: relative;
        /* Necesario para posicionar el pseudo-elemento */
        display: inline-block;
        /* Permite que el contenedor se ajuste al tamaño de la imagen */
    }

    .imagen-check img {
        display: block;
        /* Elimina el espacio debajo de la imagen */
        width: 100%;
        /* Ajusta la imagen al tamaño del contenedor */
        height: auto;
        /* Mantiene la proporción de la imagen */
    }

    .imagen-check::after {
        content: "✔";
        /* Símbolo de check */
        position: absolute;
        /* Posiciona el check sobre la imagen */
        top: 2px;
        /* Ajusta la posición vertical */
        left: 100px;
        /* Ajusta la posición horizontal */
        font-size: 24px;
        /* Tamaño del check */
        color: white;
        /* Color del check */
        background-color: green;
        /* Fondo semi-transparente */
        border-radius: 50%;
        /* Bordes redondeados */
        padding: 5px;
        /* Espaciado alrededor del check */
    }
</style>

<?php
$this->registerJs('
    $(document).ready(function() {
        $("#km").focus();
    });
');
?>

<div class="servicios-form">
<div class="box-body">
    <div class="row">
        <div class="col-lg-12">
                <?= Html::a('Regresar', ['create-seleccion', 'model' => $model,
            'model2' => $model2,
            'model3' => $model3,
            'model4' => $model4,
            'model5' => $model5,
            'model6' => $model6], ['class' => 'btn btn-primary']) ?>
            <br>
            <br>
            <div>
        <div>
    <div>
    <div class="box box-widget widget-user-2">
      
            <div class="box-body">
               
                <?php $form = ActiveForm::begin(); ?>

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" id="servicio" onclick="opendiv('servicio')">Servicio(s)</a></li>
                    <li><a data-toggle="tab" style="display: block" id="cliente" onclick="opendiv('cliente')">Cliente</a></li>
                    <li><a data-toggle="tab" style="display: block" id="pasajero" onclick="opendiv('pasajero')">Pasajero</a></li>
                    <li><a data-toggle="tab" style="display: block" id="gestionar" onclick="opendiv('gestionar');consolidado_servicio();">Gestionar</a></li>
                </ul>

                  


                <?= $form->field($model, 'km_particular')->hiddenInput(['value' => $km_particular, 'id' => 'km_particular', 'readonly' => true])->label(false); ?>
                <?= $form->field($model, 'banda_1')->hiddenInput(['value' => $banda_1, 'id' => 'banda_1', 'readonly' => true])->label(false); ?>
                <?= $form->field($model, 'banda_2')->hiddenInput(['value' => $banda_2, 'id' => 'banda_2', 'readonly' => true])->label(false); ?>
                <?= $form->field($model, 'banda_3')->hiddenInput(['value' => $banda_3, 'id' => 'banda_3', 'readonly' => true])->label(false); ?>
                <?= $form->field($model, 'mas_20')->hiddenInput(['value' => $mas_20, 'id' => 'mas_20', 'readonly' => true])->label(false); ?>
                <?= $form->field($model, 'nocturno')->hiddenInput(['value' => $nocturno, 'id' => 'nocturno', 'readonly' => true])->label(false); ?>
                <?= $form->field($model, 'porc_camioneta_interior')->hiddenInput(['value' => $porc_camioneta_interior, 'id' => 'porc_camioneta_interior', 'readonly' => true])->label(false); ?>
                <?= $form->field($model, 'porc_camioneta_caracas')->hiddenInput(['value' => $porc_camioneta_caracas, 'id' => 'porc_camioneta_caracas', 'readonly' => true])->label(false); ?>
                <?= $form->field($model, 'rango_banda_1')->hiddenInput(['value' => $rango_banda_1, 'id' => 'rango_banda_1', 'readonly' => true])->label(false); ?>
                <?= $form->field($model, 'rango_banda_2')->hiddenInput(['value' => $rango_banda_2, 'id' => 'rango_banda_2', 'readonly' => true])->label(false); ?>
                <?= $form->field($model, 'rango_banda_3')->hiddenInput(['value' => $rango_banda_3, 'id' => 'rango_banda_3', 'readonly' => true])->label(false); ?>

                <?= $form->field($model, 'item_tipo_vehiculo')->hiddenInput(['id' => 'item_tipo_vehiculo', 'value' => 'Sedán', 'readonly' => true])->label(false); ?>
                <?= $form->field($model, 'item_ruta')->hiddenInput(['id' => 'item_ruta', 'value' => 'Gran Caracas', 'readonly' => true])->label(false); ?>
                <?= $form->field($model, 'item_horario')->hiddenInput(['id' => 'item_horario', 'value' => 'Diurno', 'readonly' => true])->label(false); ?>


                <!--<div style="position: fixed; top: 0; right: 0; width: 200px; height: 100px; background-color: #f0f0f0; border: 1px solid #ccc;">
    
    </div>-->

                <div id="servicio_div" style="display:block">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 25%; background-color: #ededed;  border-top-left-radius: 10px;
                                        border-top-right-radius: 10px;
                                        border-bottom-left-radius: 10px;
                                        border-bottom-right-radius: 10px;">
                                <div class="col-md-12">
                                    <br>
                                    <fieldset>
                                        <?= $form->field($model, 'km_servicio')->textInput(['style' => 'font-size: 32px;text-align: center;', 'id' => 'km']) ?>
                                        <button type="button" class="btn btn-success" style="width: 100%;" onclick="calcular()">Calcular</button>
                                        <div id="div_destino" style="height: 350px; width: 500px;">
                                            <hr>
                                            <div id="monto_tarifario" style="display: none;" class="col-md-12">

                                                <div class="col-md-6">
                                                    <?= $form->field($model, 'desc_km')->hiddenInput(['id' => 'desc_km'])->label(false); ?>
                                                    <div id="descrip_km_item_view" style="text-align: left;"></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <?= $form->field($model, 'item_km')->textInput(['id' => 'item_km', 'style' => 'text-align: right'])->label(false); ?>
                                                </div>
                                                <hr>
                                            </div>
                                            <div id="vs_maleta" class="col-md-12" style="display: none;">
                                                <div class="col-md-2" id="desc_variable1">
                                                </div>
                                                <div class="col-md-5">
                                                    <?php echo $form->field($model, 'cant_v1')->widget(TouchSpin::classname(), [
                                                        'options' => ['placeholder' => '', 'id' => 'cant_v1', 'value' => 1, 'onchange' => 'suma_cantidad(1)'],
                                                        'pluginOptions' => [
                                                            'min' => 0,
                                                            'max' => 30,
                                                            'step' => 1,
                                                            'postfix' => 'und',
                                                            'decimals' => 0,
                                                        ]
                                                    ])->label(false); ?>

                                                    <?= $form->field($model, 'variable1')->hiddenInput(['id' => 'variable1', 'readonly' => true])->label(false); ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <?= $form->field($model, 'subtotal_v1')->textInput(['id' => 'subtotal_v1', 'style' => 'text-align: right'])->label(false); ?>
                                                    <?= $form->field($model, 'monto_v1')->hiddenInput(['id' => 'monto_v1', 'style' => 'text-align: right'])->label(false); ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <img src="../web/img/minus.png" alt="menos" width="70%" onclick="quitar(1)">
                                                </div>
                                            </div>

                                            <div id="vs_pax" class="col-md-12" style="display: none;">
                                                <div class="col-md-2" id="desc_variable2">
                                                </div>
                                                <div class="col-md-5">
                                                    <?php echo $form->field($model, 'cant_v2')->widget(TouchSpin::classname(), [
                                                        'options' => ['placeholder' => '', 'id' => 'cant_v2', 'value' => 1, 'onchange' => 'suma_cantidad(2)'],
                                                        'pluginOptions' => [
                                                            'min' => 0,
                                                            'max' => 30,
                                                            'step' => 1,
                                                            'postfix' => 'und',
                                                            'decimals' => 0,
                                                        ]
                                                    ])->label(false); ?>

                                                    <?= $form->field($model, 'variable2')->hiddenInput(['id' => 'variable2', 'readonly' => true])->label(false); ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <?= $form->field($model, 'subtotal_v2')->textInput(['id' => 'subtotal_v2', 'style' => 'text-align: right'])->label(false); ?>
                                                    <?= $form->field($model, 'monto_v2')->hiddenInput(['id' => 'monto_v2', 'style' => 'text-align: right'])->label(false); ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <img src="../web/img/minus.png" alt="menos" width="70%" onclick="quitar(2)">
                                                </div>
                                            </div>


                                            <div id="vs_silla" class="col-md-12" style="display: none;">
                                                <div class="col-md-2" id="desc_variable5">
                                                </div>
                                                <div class="col-md-5">
                                                    <?php echo $form->field($model, 'cant_v5')->widget(TouchSpin::classname(), [
                                                        'options' => ['placeholder' => '', 'id' => 'cant_v5', 'value' => 1, 'onchange' => 'suma_cantidad(5)'],
                                                        'pluginOptions' => [
                                                            'min' => 0,
                                                            'max' => 30,
                                                            'step' => 1,
                                                            'postfix' => 'und',
                                                            'decimals' => 0,
                                                        ]
                                                    ])->label(false); ?>

                                                    <?= $form->field($model, 'variable5')->hiddenInput(['id' => 'variable5', 'readonly' => true])->label(false); ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <?= $form->field($model, 'subtotal_v5')->textInput(['id' => 'subtotal_v5', 'style' => 'text-align: right'])->label(false); ?>
                                                    <?= $form->field($model, 'monto_v5')->hiddenInput(['id' => 'monto_v5', 'style' => 'text-align: right'])->label(false); ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <img src="../web/img/minus.png" alt="menos" width="70%" onclick="quitar(5)">
                                                </div>

                                            </div>
                                            <div id="vs_mascota" class="col-md-12" style="display: none;">
                                                <div class="col-md-2" id="desc_variable7">
                                                </div>
                                                <div class="col-md-5">
                                                    <?php echo $form->field($model, 'cant_v7')->widget(TouchSpin::classname(), [
                                                        'options' => ['placeholder' => '', 'id' => 'cant_v7', 'value' => 1, 'onchange' => 'suma_cantidad(7)'],
                                                        'pluginOptions' => [
                                                            'min' => 0,
                                                            'max' => 30,
                                                            'step' => 1,
                                                            'postfix' => 'und',
                                                            'decimals' => 0,
                                                        ]
                                                    ])->label(false); ?>

                                                    <?= $form->field($model, 'variable7')->hiddenInput(['id' => 'variable7', 'readonly' => true])->label(false); ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <?= $form->field($model, 'subtotal_v7')->textInput(['id' => 'subtotal_v7', 'style' => 'text-align: right'])->label(false); ?>
                                                    <?= $form->field($model, 'monto_v7')->hiddenInput(['id' => 'monto_v7', 'style' => 'text-align: right'])->label(false); ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <img src="../web/img/minus.png" alt="menos" width="70%" onclick="quitar(7)">
                                                </div>

                                            </div>
                                            <div id="vs_hora_espera" class="col-md-12" style="display: none;">
                                                <div class="col-md-2" id="desc_variable3">
                                                </div>
                                                <div class="col-md-5">
                                                    <?php echo $form->field($model, 'cant_v3')->widget(TouchSpin::classname(), [
                                                        'options' => ['placeholder' => '', 'id' => 'cant_v3', 'value' => 1, 'onchange' => 'suma_cantidad(3)'],
                                                        'pluginOptions' => [
                                                            'min' => 0,
                                                            'max' => 30,
                                                            'step' => 1,
                                                            'postfix' => 'und',
                                                            'decimals' => 0,
                                                        ]
                                                    ])->label(false); ?>

                                                    <?= $form->field($model, 'variable3')->hiddenInput(['id' => 'variable3', 'readonly' => true])->label(false); ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <?= $form->field($model, 'subtotal_v3')->textInput(['id' => 'subtotal_v3', 'style' => 'text-align: right'])->label(false); ?>
                                                    <?= $form->field($model, 'monto_v3')->hiddenInput(['id' => 'monto_v3', 'style' => 'text-align: right'])->label(false); ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <img src="../web/img/minus.png" alt="menos" width="70%" onclick="quitar(3)">
                                                </div>

                                            </div>
                                            <div id="vs_aeropuerto" class="col-md-12" style="display: none;">
                                                <div class="col-md-2" id="desc_variable4">
                                                </div>
                                                <div class="col-md-5">
                                                    <?php echo $form->field($model, 'cant_v4')->widget(TouchSpin::classname(), [
                                                        'options' => ['placeholder' => '', 'id' => 'cant_v4', 'value' => 1, 'onchange' => 'suma_cantidad(4)'],
                                                        'pluginOptions' => [
                                                            'min' => 0,
                                                            'max' => 30,
                                                            'step' => 1,
                                                            'postfix' => 'und',
                                                            'decimals' => 0,
                                                        ]
                                                    ])->label(false); ?>

                                                    <?= $form->field($model, 'variable4')->hiddenInput(['id' => 'variable4', 'readonly' => true])->label(false); ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <?= $form->field($model, 'subtotal_v4')->textInput(['id' => 'subtotal_v4', 'style' => 'text-align: right'])->label(false); ?>
                                                    <?= $form->field($model, 'monto_v4')->hiddenInput(['id' => 'monto_v4', 'style' => 'text-align: right'])->label(false); ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <img src="../web/img/minus.png" alt="menos" width="70%" onclick="quitar(2)">
                                                </div>

                                            </div>
                                            <div id="vs_encomienda" class="col-md-12" style="display: none;">
                                                <div class="col-md-2" id="desc_variable6">
                                                </div>
                                                <div class="col-md-5">
                                                    <?php echo $form->field($model, 'cant_v6')->widget(TouchSpin::classname(), [
                                                        'options' => ['placeholder' => '', 'id' => 'cant_v6', 'value' => 1, 'onchange' => 'suma_cantidad(6)'],
                                                        'pluginOptions' => [
                                                            'min' => 0,
                                                            'max' => 30,
                                                            'step' => 1,
                                                            'postfix' => 'und',
                                                            'decimals' => 0,
                                                        ]
                                                    ])->label(false); ?>

                                                    <?= $form->field($model, 'variable6')->hiddenInput(['id' => 'variable6', 'readonly' => true])->label(false); ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <?= $form->field($model, 'subtotal_v6')->textInput(['id' => 'subtotal_v6', 'style' => 'text-align: right'])->label(false); ?>
                                                    <?= $form->field($model, 'monto_v6')->hiddenInput(['id' => 'monto_v6', 'style' => 'text-align: right'])->label(false); ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <img src="../web/img/minus.png" alt="menos" width="70%" onclick="quitar(6)">
                                                </div>

                                            </div>

                                        </div>

                                        <div id="total" style="background-color: #3c8dbc;
                                        border-top-left-radius: 10px;
                                        border-top-right-radius: 10px;
                                        border-bottom-left-radius: 10px;
                                        border-bottom-right-radius: 10px;
                                        color: #FFF;   padding: 10px 20px; border:1" class="col-md-12">
                                            <div class="col-md-4">
                                                <b>Total:</b>
                                            </div>
                                            <div class="col-md-8" id="view_monto" style="text-align: right;">
                                            </div>
                                            <?= $form->field($model, 'monto')->hiddenInput(['id' => 'monto'])->label(false); ?>

                                        </div>

                                    </fieldset>
                                    <br>
                                </div>
                            </td>
                            <td>
                                <div class="col-md-12">
                                    <fieldset>
                                        <legend>Servicios Ofrecidos</legend>
                                        <div class="col-md-12">
                                            <div class="col-md-3">
                                                <a href="#" class="boton-imagen " id="autobus">
                                                    <img src="../web/img/autobus.png" alt="Autobus" width="100%" onclick="add_categoria('Autobus','tipo_vehiculo')">
                                                    <p style="text-align: center;">Autobus</p>
                                                </a>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="#" class="boton-imagen " id="van">
                                                    <img src="../web/img/van.png" alt="Van" width="100%" onclick="add_categoria('Van','tipo_vehiculo')">
                                                    <p style="text-align: center;">Van</p>
                                                </a>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="#" class="boton-imagen " id="camioneta">
                                                    <img src="../web/img/camioneta.png" alt="Camioneta" width="100%" onclick="add_categoria('Camioneta','tipo_vehiculo')">
                                                    <p style="text-align: center;">Camioneta</p>
                                                </a>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="#" class="boton-imagen " id="sedan">
                                                    <img src="../web/img/sedan.png" alt="Sedan" width="100%" onclick="add_categoria('Sedán','tipo_vehiculo')">
                                                    <p style="text-align: center;">Sedán</p>
                                                </a>

                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <legend>Recorrido - Rutas </legend>
                                        <div class="col-md-12" style="text-align: center;">
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-success" style="width: 100%;" onclick="add_categoria('Nacional','ruta')">Nacional</button>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-success" style="width: 100%;" onclick="add_categoria('Gran Caracas','ruta')">Gran Caracas</button>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-primary" style="width: 100%;" onclick="add_categoria('Diurno','horario')">Diurno</button>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-primary" style="width: 100%;" onclick="add_categoria('Nocturno','horario')">Nocturno</button>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="col-md-12" style="text-align: center;">
                                            <div class="col-md-3">
                                                <?php
                                                $lista_precio = ListaPrecio::find()->where(['id_variable' => 1])->one();
                                                ?>
                                                <img src="../web/img/maleta.png" alt="Maleta" width="50%" onclick="enviarDato('<?= $lista_precio->id_variable ?>','<?= $lista_precio->monto ?>')">
                                                <h4><?= $lista_precio->monto . "$"; ?></h4>
                                            </div>
                                            <div class="col-md-3">
                                                <?php
                                                $lista_precio = ListaPrecio::find()->where(['id_variable' => 2])->one();
                                                ?>
                                                <img src="../web/img/pax.png" alt="Pasajero Adicional" width="50%" onclick="enviarDato('<?= $lista_precio->id_variable ?>','<?= $lista_precio->monto ?>')">
                                                <h4><?= $lista_precio->monto . "$"; ?></h4>
                                            </div>
                                            <div class="col-md-3">
                                                <?php
                                                $lista_precio = ListaPrecio::find()->where(['id_variable' => 5])->one();

                                                ?>
                                                <img src="../web/img/silla_bebe.png" alt="Silla para Bebé" width="50%" onclick="enviarDato('<?= $lista_precio->id_variable ?>','<?= $lista_precio->monto ?>')">
                                                <h4><?= $lista_precio->monto . "$"; ?></h4>
                                            </div>
                                            <div class="col-md-3">
                                                <?php
                                                $lista_precio = ListaPrecio::find()->where(['id_variable' => 7])->one();
                                                ?>
                                                <img src="../web/img/mascota.png" alt="Mascota" width="50%" onclick="enviarDato('<?= $lista_precio->id_variable ?>','<?= $lista_precio->monto ?>')">
                                                <h4><?= $lista_precio->monto . "$"; ?></h4>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="text-align: center;">
                                            <div class="col-md-3">
                                                <?php
                                                $lista_precio = ListaPrecio::find()->where(['id_variable' => 3])->one();
                                                ?>
                                                <img src="../web/img/tiempo_espera.png" alt="Tiempo de Espera" width="50%" onclick="enviarDato('<?= $lista_precio->id_variable ?>','<?= $lista_precio->monto ?>')">
                                                <h4><?= $lista_precio->monto . "$"; ?></h4>
                                            </div>
                                            <div class="col-md-3">
                                                <?php
                                                $lista_precio = ListaPrecio::find()->where(['id_variable' => 4])->one();
                                                ?>
                                                <img src="../web/img/espera_aeropuerto.png" alt="Espera dentro Aeropuerto" width="50%" onclick="enviarDato('<?= $lista_precio->id_variable ?>','<?= $lista_precio->monto ?>')">
                                                <h4><?= $lista_precio->monto . "$"; ?></h4>
                                            </div>
                                            <div class="col-md-3">
                                                <?php
                                                $lista_precio = ListaPrecio::find()->where(['id_variable' => 6])->one();
                                                ?>
                                                <img src="../web/img/encomienda.png" alt="Encomienda" width="50%" onclick="enviarDato('<?= $lista_precio->id_variable ?>','<?= $lista_precio->monto ?>')">
                                                <h4><?= $lista_precio->monto . "$"; ?></h4>
                                            </div>
                                        </div>

                            </td>
                        </tr>
                        <!-- <tr>
                        <td rowspan="2">
                            <div class="col-md-12" style="text-align: center;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-success" style="width: 100%;">Cliente</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-warning" style="width: 100%;">Agenda</button>
                                    </div>
                                </div>
                                <div>
                                    <br>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary" style="width: 100%;">Pasajeros</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-danger" style="width: 100%;">Limpiar</button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>-->

                    </table>

                </div>
                <div id="pasajeros_div" style="display:none">

                    <div class="row">

                        <div class="col-md-6" style="text-align: right;">
                            <small><a href="#" class="label_a bg-green" onclick="mismo_cliente()">Mismo Cliente</a> </small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">

                            <?php
                            $data = Pasajero::find()
                                ->select([
                                    'nombre_apellido as value',
                                    'nombre_apellido as label',
                                    'id_pasajero as id',
                                    'telefono'
                                ])
                                ->asArray()
                                ->all();
                            ?>
                            <?= $form->field($model6, 'nombre_apellido')->widget(\yii\jui\AutoComplete::classname(), [
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
                                            $('#telefono_pax').val(ui.item.telefono);
                                            }")
                                ],
                                'options' => [
                                    'class' => 'form-control',
                                ]
                            ]) ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model6, 'telefono')->textInput(['id' => 'telefono_pax', 'maxlength' => true]) ?>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model5, 'fecha')->input('date', [
                                'max' => date('Y-m-d'), 
                            ])->widget(DatePicker::className(), []) ?>

                        </div>
                        <div class="col-md-6">
                            <label>Hora</label>
                            <?php
                            echo TimePicker::widget([
                                'name' => 'hora',
                                'options' => [
                                    'readonly' => true,
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model5, 'origen')->textarea(['rows' => 3])  ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model5, 'destino')->textarea(['rows' => 3])  ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success" style="width: 30%;" onclick="add_pax()">Agregar Ruta</button>
                        </div>
                    </div>

                    <div class="row" id="resumen_pasajeros" style="display: none;">
                        <div class="col-md-12">
                            <br>
                            <fieldset>
                                <legend>Pasajeros por rutas</legend>
                                <?= $form->field($model6, 'num_pax')->hiddenInput(['id' => 'num_pax', 'value' => 1])->label(false) ?>

                                <div class="col-md-12" id='pax_1' style="display: none;">
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'nombre1')->textInput(['id' => 'nombre1', 'maxlength' => true])->label('Nombre') ?>
                                    </div>
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'telefono1')->textInput(['id' => 'telefono1', 'maxlength' => true])->label('Teléfono') ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model5, 'fecha1')->textInput(['id' => 'fecha1', 'maxlength' => true])->label('Fecha') ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model5, 'hora1')->textInput(['id' => 'hora1', 'maxlength' => true])->label('Hora') ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model5, 'origen1')->textInput(['id' => 'origen1', 'maxlength' => true])->label('Origen') ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model5, 'destino1')->textInput(['id' => 'destino1', 'maxlength' => true])->label('Destino') ?>
                                    </div>
                                </div>

                                <div class="col-md-12" id='pax_2' style="display: none;">
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'nombre2')->textInput(['id' => 'nombre2', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'telefono2')->textInput(['id' => 'telefono2', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model5, 'fecha2')->textInput(['id' => 'fecha2', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model5, 'hora2')->textInput(['id' => 'hora2', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model5, 'origen2')->textInput(['id' => 'origen2', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model5, 'destino2')->textInput(['id' => 'destino2', 'maxlength' => true])->label(false) ?>
                                    </div>
                                </div>

                                <div class="col-md-12" id='pax_3' style="display: none;">
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'nombre3')->textInput(['id' => 'nombre3', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'telefono3')->textInput(['id' => 'telefono3', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model5, 'fecha3')->textInput(['id' => 'fecha3', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model5, 'hora3')->textInput(['id' => 'hora3', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model5, 'origen3')->textInput(['id' => 'origen3', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model5, 'destino3')->textInput(['id' => 'destino3', 'maxlength' => true])->label(false) ?>
                                    </div>
                                </div>

                                <div class="col-md-12" id='pax_4' style="display: none;">
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'nombre4')->textInput(['id' => 'nombre4', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'telefono4')->textInput(['id' => 'telefono4', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model5, 'fecha4')->textInput(['id' => 'fecha4', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model5, 'hora4')->textInput(['id' => 'hora4', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model5, 'origen4')->textInput(['id' => 'origen4', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model5, 'destino4')->textInput(['id' => 'destino4', 'maxlength' => true])->label(false) ?>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                </div>
                <div id="gestionar_div" style="display:none">

                    <fieldset style="width: 100%; ">
                        <legend>Resumen del Servicio</legend>

                        <table class="table">
                            <tr>
                                <th>Servicio</th>
                                <td id="ser"></td>
                            
                            </tr>
                            <tr>
                                <th>Servicio Adicional</th>
                                <td id="ser_a"></td>
                            
                            </tr>

                            <tr>
                                <th>Cliente</th>
                                <td id="cli_nom"></td>
                               
                            </tr>
                            <tr>
                                <th>Pasajero(s)</th>
                                <td id="pax_nom"></td>
                            
                            </tr>


                        </table>

                        <?= $form->field($model, 'observacion_inicial')->textarea(['rows' => 6])  ?>


                    </fieldset>

                    <div class="form-group">
                        <div class="box-tools pull-right">
                            <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> <b>Regresar</b>', ['index'], ['class' => 'btn btn-warning btn']) ?>
                            <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> <b>Guardar</b>', ['class' => 'btn btn-primary btn']) ?>
                        </div>
                    </div>

                </div>

                <div id="cliente_div" style="display:none">

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
                                        <?= $form->field($model3, 'cedula_rif_serv')->textInput(['id' => 'cedula_rif_serv', 'maxlength' => true])->label('Cédula/RIF'); ?>
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


                </div>



                <?php ActiveForm::end(); ?>



            </div>
        </div>
    </div>
