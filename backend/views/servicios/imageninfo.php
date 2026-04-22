<?php

use backend\models\Conductor;
use backend\models\MovFlota;
use backend\models\VConductores;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use backend\models\TipoRuta;
use backend\models\TipoTrasladoRuta;
use backend\models\BaseTipoVehiculo;
use backend\models\Pasajero;
use backend\models\PasajeroServicio;
use backend\models\VariablesServicio;
use backend\models\ServicioVariables;
use backend\models\VFlota;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\switchinput\SwitchInput;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\CuerpoBomberos */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="servicio-form">

    <div class="box box-widget widget-user-2">
        <div class="box box-default">
            <div class="box-body">
                <?php $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>

                <div class="row">
                    <div class="col-md-12">
                        <fieldset>
                            <legend>Relación de Servicio</legend>
                            <table class="table">
                                <tr>
                                    <th colspan="6">SERVICIOS DE TRASLADO CH GROUP | Num. <?= $model->id_servicio ?></th>
                                </tr>
                                <tr>
                                <th colspan="6">
                                    <?php
                                    $diaDeLaSemana = date('N', strtotime($model->fecha_registro));
                                    $dia_semana = '';
                                    switch ($diaDeLaSemana) {
                                        case '1':
                                            $dia_semana = 'Lunes';
                                            break;
                                        case '2':
                                            $dia_semana = 'Martes';
                                            break;
                                        case '3':
                                            $dia_semana = 'Miércoles';
                                            break;
                                        case '4':
                                            $dia_semana = 'Jueves';
                                            break;
                                        case '5':
                                            $dia_semana = 'Viernes';
                                            break;
                                        case '6':
                                            $dia_semana = 'Sábado';
                                            break;
                                        case '7':
                                            $dia_semana = 'Domingo';
                                            break;
                                    }

                                    echo $dia_semana . " " . Yii::$app->formatter->asDate($model->fecha_registro, 'php:d-m-Y');

                                    $conductor = VConductores::find()->where(['id' => $model->id_conductor])->one();
                                    $flota = VFlota::find()->where(['id_flota' => $model->id_flota])->one();
                                    
                                    ?>
                            </th>
                            </tr>
                            <tr>
                                    <th>Conductor</th>
                                    <th><?= $conductor->datos ?></th>
                                    <th>Teléfono</th>
                                    <th><?= $conductor->telefono_principal ?></th>
                                    <th>Vehículo</th>
                                    <th><?= $flota->nombre_flota ?></th>
                                </tr>
                            </table>

                            <?php
                            $variable = ServicioVariables::find()->where(['id_servicio' => $model->id_servicio])->all();

                            if ($variable) {
                            ?>
                                <legend>Servicio Adicional</legend>
                                <table class="table" style="width: 50%;">
                                    <tr>
                                        <th>Item.</th>
                                        <th>Servicio Adicionales</th>
                                        <th>Cantidad</th>
                                    </tr>
                                    <?php
                                    $variable = ServicioVariables::find()->where(['id_servicio' => $model->id_servicio])->all();
                                    for ($i = 0; $i < count($variable); $i++) {
                                    ?>
                                        <tr>
                                            <td>
                                                <?= $i + 1; ?>
                                            </td>
                                            <td>
                                                <?php $nombre_servicio = VariablesServicio::find()->where(['id_variable' => $variable[$i]['id_variable_servicio']])->one(); ?>
                                                <?= $nombre_servicio->nombre_variable; ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?= $variable[$i]['cantidad']; ?>
                                            </td>

                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </table>

                            <?php } ?>

                            <legend>Pasajero(s)</legend>
                            <table class="table">
                                <tr>
                                    <th>Ruta.</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Hora</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                </tr>
                                <?php
                                $variable = PasajeroServicio::find()->where(['id_servicio' => $model->id_servicio])->all();

                                for ($i = 0; $i < count($variable); $i++) {
                                ?>
                                    <tr>
                                        <td>
                                            <?= $i + 1; ?>
                                        </td>
                                        <td>
                                            <?php $pax = Pasajero::find()->where(['id_pasajero' => $variable[$i]['id_pasajero']])->one(); ?>
                                            <?= $pax->nombre_apellido; ?>
                                        </td>
                                        <td>
                                            <?= $pax->telefono; ?>
                                        </td>
                                        <td>
                                            <?= $variable[$i]['hora']; ?>
                                        </td>
                                        <td style="text-align: right;">
                                            <?= $variable[$i]['origen']; ?>
                                        </td>
                                        <td style="text-align: right;">
                                            <?= $variable[$i]['destino']; ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                            <table class="table">
                                <tr>
                                    <th>Observación.</th>
                                </tr>
                                <tr>
                                    <th><?= $model->observacion_inicial; ?></th>
                                </tr>
                            </table>


                        </fieldset>
                    </div>
                    <?php
                        $im = imagegrabscreen();
                        imagepng($im, "mi_captura_de_pantalla.png");
                        imagedestroy($im);
                    ?>

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

<br>
<?php
/*
if ($registros) {
?>
    <div class="box box-widget widget-user-2">
        <div class="box box-purple">
            <div class="box-body">
                <div class="col-md-12">
                    <table class='table table-bordered' width=100%>
                        <tr style="background-color: #394B8B; color: white">
                            <th>Fecha de Asignación</th>
                            <th>Conductor</th>
                            <th>Observación</th>
                        </tr>
                        <tr>
                            <?php
                            for ($i = 0; $i < count($registros); $i++) {
                            ?>
                        <tr>
                            <td>
                                <?php
                                    $fecha = explode("-", $registros[$i]['fecha_asignacion']);
                                    $fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];

                                    echo $fecha;
                                ?>
                             </td>
                            <td>
                            <?php
                                $conductor = VConductores::find()->where(['id' => $registros[$i]['id_conductor']])->one();
                                echo $conductor->datos; ?>

                            </td>
                            <td>
                            <?php
                                $movflota = MovFlota::find()->where(['id_accion' => $registros[$i]['id_asignacion']])->one();
                                echo $movflota->observacion; ?>

                            </td>
                       
                            
                        </tr>
                    <?php
                            }
                    ?>

                    </tr>
                    </table>
                </div>
            </div>
        </div>
    <?php  }*/ ?>