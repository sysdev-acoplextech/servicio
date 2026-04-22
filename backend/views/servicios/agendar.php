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
$municipio = [];
/*
if ($model->id_estado) {
    $municipio = ArrayHelper::map(GeoMunicipio::find()->where(['id_estado' => $model->id_estado])->all(), 'id_municipio', 'nombre');
}
*/
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
                            <legend>Servicio</legend>
                            <table class="table">
                                <tr style="background-color: #ededed;">
                                    <th>Nro.</th>
                                    <th>Fecha del Registro</th>
                                    <th>Tipo de Servicio</th>
                                    <th>Km</th>
                                    <th>Fecha del Servicio</th>
                                    <th>Monto ($)</th>
                                </tr>
                                <tr>
                                    <td><?= $model->id_servicio ?></td>
                                    <td>
                                        <?= Yii::$app->formatter->asDate($model->fecha_registro, 'php:d-m-Y') ?>
                                    </td>
                                    <td>
                                        <?php
                                        $tipo_vehiculo = BaseTipoVehiculo::find()->where(['id' => $model->id_tipo_vehiculo])->one();
                                        $ruta = TipoTrasladoRuta::find()->where(['id' => $model->id_tipo_traslado_ruta])->one();
                                        $tipo_ruta = TipoRuta::find()->where(['id' => $model->id_tipo_ruta])->one();
                                        echo $tipo_vehiculo->nombre_tipo_vehiculo . "/" . $ruta->nombre_traslado_ruta . "/" . $tipo_ruta->nombre_ruta;
                                        ?>
                                    </td>
                                    <td><?= $model->km_servicio ?></td>
                                    <td>
                                        <?= Yii::$app->formatter->asDate($model->fecha_servicio, 'php:d-m-Y') ?>
                                    </td>
                                    <td><?= $model->monto ?></td>

                            </table>
                            <?php
                                $variable = ServicioVariables::find()->where(['id_servicio' => $model->id_servicio])->all();

                                if ($variable){
                            ?>
                            <legend>Servicio Adicional</legend>
                                <table class="table">
                                    <tr style="background-color: #ededed;">
                                        <th>Item.</th>
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
                            <legend>Pasajero(s)</legend>
                            <table class="table">
                                <tr style="background-color: #ededed;">
                                    <th>Ruta</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                </tr>
                                <tr>
                                <?php
                                $pax = PasajeroServicio::find()->where(['id_servicio'=>$model->id_servicio])->all();
                               
                                for ($i=0; $i < count($pax); $i++) { 
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $i+1;?>
                                        </td>
                                        <td>
                                            <?php $pax_dato = Pasajero::find()->where(['id_pasajero'=>$pax[$i]['id_pasajero']])->one(); ?>    
                                            <?= $pax_dato->nombre_apellido;?>
                                        </td>
                                        <td>
                                            <?= $pax_dato->telefono;?>
                                        </td>
                                        <td>
                                            <?= Yii::$app->formatter->asDate($pax[$i]['fecha'], 'php:d-m-Y') ?>
                                        </td>
                                        <td>
                                            <?= $pax[$i]['hora']?>
                                        </td>
                                        <td>
                                            <?= $pax[$i]['origen']?>
                                        </td>
                                        <td>
                                            <?= $pax[$i]['destino']?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                           
                        </fieldset>
                    </div>


                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <fieldset>
                        <legend>Agendar</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $flota = VFlota::find()->where(['asignado' =>1])->all();

                                $lisflota = ArrayHelper::map($flota, 'id_conductor', 'flota_asignada_nombre');

                                echo $form->field($model, 'flota_conductor')->widget(Select2::classname(), [
                                    'data' => $lisflota,
                                    'pluginLoading' => false,
                                    'value' => null,
                                    'options' => ['placeholder' => 'Seleccione...'],
                                    'pluginOptions' => [
                                        'multiple' => false,
                                        'allowClear' => true,
                                    ],
                                ]);
                                echo $form->field($model, 'id_servicio')->hiddenInput(['readonly' => true, 'value'=>$model->id_servicio])->label(false);?>
                                
                            </div>
                            
                            <div class="col-md-6">
                                <?php
                                echo $form->field($model3, 'id_metodo')->widget(SwitchInput::classname(), [
                                    'type' => SwitchInput::CHECKBOX,
                                    'pluginOptions' => [
                                        'handleWidth' => 60,
                                        'offColor' => 'danger',
                                        'onColor' => 'success',
                                        'onText' => 'SI',
                                        'offText' => 'NO'
                                    ]
                                ])->label('¿Pagará en efectivo?');
                                echo $form->field($model, 'id_servicio')->hiddenInput(['readonly' => true, 'value' => $model->id_servicio])->label(false);
                                ?>
                               
                            </div>
                        </div>
                               
                        <div class="row">
                            <div class="col-md-6">
                                <?php

                                $conductores = VConductores::find()->all();
                                $lisconductores = ArrayHelper::map($conductores, 'id', 'datos');
                                echo $form->field($model, 'id_conductor')->widget(Select2::classname(), [
                                    'data' => $lisconductores,
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
                                $flota = VFlota::find()->where(['asignado' =>0])->all();
                                $lisflota = ArrayHelper::map($flota, 'id_flota', 'nombre_flota');
                                echo $form->field($model, 'id_flota')->widget(Select2::classname(), [
                                    'data' => $lisflota,
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

                        <div class="row">   
                            <div class="col-md-12">
                                <?php echo $form->field($model2, 'observacion')->textarea(['rows' => 6]);?>
                            </div>
                        </div>
                        </fieldset>
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