<?php

use backend\models\BaseTipoVehiculo;
use backend\models\Cliente;
use backend\models\Estatus;
use backend\models\ListaPrecio;
use backend\models\Pasajero;
use backend\models\PasajeroServicio;
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


<div class="box box-widget widget-user-2">

    <div class="box box-primary">
        <div class="box-body">
            <div class="col-md-12">

            <div class="row">
            <div class="col-md-12">
                <?= Html::a('Ver Servicio', ['view','id' =>  $model->id_servicio], ['class' => 'btn btn-success']) ?>
            
            </div>
            
            </div>
            <br>
                <div class="row">
                    <div class="col-md-3">

                        <fieldset>
                            <fieldset style="background-color: #f5f5f5; border: 1px solid #ccc;  padding: 10px; border-radius: 5px;">
                                <h4><i class="glyphicon glyphicon-tags"> </i> Tarifa</h4>

                                <table class="table">
                                    <tr style="background-color: #ededed;">
                                        <th>Tipo de Servicio</th>
                                        <th>Km</th>
                                        <th>Monto ($)</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                            $tipo_vehiculo = BaseTipoVehiculo::find()->where(['id' => $model->id_tipo_vehiculo])->one();
                                            $ruta = TipoTrasladoRuta::find()->where(['id' => $model->id_tipo_traslado_ruta])->one();
                                            $tipo_ruta = TipoRuta::find()->where(['id' => $model->id_tipo_ruta])->one();
                                            echo $tipo_vehiculo->nombre_tipo_vehiculo . "/" . $ruta->nombre_traslado_ruta . "/" . $tipo_ruta->nombre_ruta;
                                            ?>
                                        </td>
                                        <td><?= $model->km_servicio ?></td>

                                        <td><?= $model->monto ?></td>

                                    </tr>
                                </table>
                                <?php
                                $variable = ServicioVariables::find()->where(['id_servicio' => $model->id_servicio])->all();

                                if ($variable) {
                                ?>

                                    <table class="table">
                                        <tr style="background-color: #ededed;">
                                            <th>#</th>
                                            <th>Servicio Adicionales</th>
                                            <th>Cantidad</th>
                                            <th>Monto ($)</th>
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
                                                <td style="text-align: right;">
                                                    <?= $variable[$i]['monto']; ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>

                                <?php } ?>
                                <?= Html::a('Modificar', ['controller/formulario1'], ['class' => 'btn btn-success']) ?>
                            </fieldset>
                    </div>
                    <div class="col-md-4">
                        <fieldset style="background-color: #f5f5f5; border: 1px solid #ccc;  padding: 10px; border-radius: 5px;">
                            <h4><i class="glyphicon glyphicon-user"> </i> Cliente</h4>
                            <table class="table">
                                <tr>
                                    <th style="background-color: #ededed;">Cédula:</th>
                                    <td><?= $model2->cedula; ?></td>
                                </tr>
                                <tr>
                                    <th style="background-color: #ededed;">Nombre y apellido:</th>
                                    <td><?= $model2->nombre_apellido; ?></td>
                                </tr>
                                <tr>
                                    <th style="background-color: #ededed;">Teléfono principal:</th>
                                    <td><?= $model2->telefono_principal; ?></td>
                                </tr>
                                <tr>
                                    <th style="background-color: #ededed;">Teléfono alterno:</th>
                                    <td><?= $model2->telefono_alterno; ?></td>
                                </tr>
                                <tr>
                                    <th style="background-color: #ededed;">Correo:</th>
                                    <td><?= $model2->correo; ?></td>
                                </tr>
                                <tr>
                                    <th style="background-color: #ededed;">Dirección:</th>
                                    <td><?= $model2->direccion; ?></td>
                                </tr>
                            </table>
                            <?= Html::a('Modificar', ['modificar-cliente', 'id' => $model->id_servicio], ['class' => 'btn btn-primary']) ?>
                        </fieldset>
                    </div>
                    <div class="col-md-5">
                        <fieldset style="background-color: #f5f5f5; border: 1px solid #ccc;  padding: 10px; border-radius: 5px;">
                            <h4><i class="glyphicon glyphicon-road"> </i> Pasajeros</h4>
                            <table class="table">
                                <tr style="background-color: #ededed;">
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                </tr>
                                <tr>
                                    <?php
                                    $pax = PasajeroServicio::find()->where(['id_servicio' => $model->id_servicio])->all();
                                    for ($i = 0; $i < count($pax); $i++) {
                                    ?>
                                <tr>
                                    <td>
                                        <?= $i + 1; ?>
                                    </td>
                                    <td>
                                        <?php $pax_dato = Pasajero::find()->where(['id_pasajero' => $pax[$i]['id_pasajero']])->one(); ?>
                                        <?= $pax_dato->nombre_apellido; ?>
                                    </td>
                                    <td>
                                        <?= $pax_dato->telefono; ?>
                                    </td>
                                    <td>
                                        <?= Yii::$app->formatter->asDate($pax[$i]['fecha'], 'php:d-m-Y') ?>
                                    </td>
                                    <td>
                                        <?= $pax[$i]['hora'] ?>
                                    </td>
                                    <td>
                                        <?= $pax[$i]['origen'] ?>
                                    </td>
                                    <td>
                                        <?= $pax[$i]['destino'] ?>
                                    </td>
                                </tr>
                            <?php
                                    }
                            ?>
                            </table>
                            <?= Html::a('Modificar', ['modificar-pasajeros', 'id' => $model->id_servicio], ['class' => 'btn btn-warning']) ?>
                        </fieldset>
                    </div>
                </div>
                <div class="form-group">
                    <div class="box-tools pull-right">
                        <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> <b>Regresar</b>', ['index'], ['class' => 'btn btn-warning btn']) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
</div>