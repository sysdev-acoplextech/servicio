<?php

use backend\models\BaseMetodosPago;
use backend\models\Conductor;
use backend\models\MovFlota;
use backend\models\VConductores;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use backend\models\TipoRuta;
use backend\models\TipoTrasladoRuta;
use backend\models\BaseTipoVehiculo;
use backend\models\MetodoPago;
use backend\models\OperadorFinanciero;
use backend\models\Pasajero;
use backend\models\PasajeroServicio;
use backend\models\VariablesServicio;
use backend\models\ServicioVariables;
use backend\models\Tasadia;
use backend\models\VFlota;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;

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
             

                <div class="row">
                    <div class="col-md-12">

                        <fieldset>
                            <div class="alert alert-success alert-dismissible">
                                <?php
                                $tasa = Tasadia::find()->where(['id_estatus' => TRUE])->one();
                                ?>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-bank"></i> ¡Tasa del Día!</h4>
                                <?php

                                //$valor_bs = $tasa->valor * $model->monto;

                                echo "Fecha de actualización: " .  Yii::$app->formatter->asDate($tasa->fecha_hora, 'php:d-m-Y') . " Valor: " . Yii::$app->formatter->asDecimal($tasa->valor, 2) . " Bs. ";
                                if ($model->faltante > 0) {
                                    $valor_bs = $model->faltante * $tasa->valor;
                                    $valor_dolares = $model->faltante;
                                } else {
                                    $valor_bs = $tasa->valor * $model->monto;
                                    $valor_dolares = $model->monto;
                                }


                                echo "<h4><b>Debe cancelar en Bs. </b> " . Yii::$app->formatter->asDecimal($valor_bs, 2) . " / $ " . Yii::$app->formatter->asDecimal($valor_dolares, 2) . "</h4>";
                                ?>
                               
                            </div>
                            <legend>Pagar servicio</legend>
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
                                    <td><?= Yii::$app->formatter->asDecimal($model->monto, 2);   ?>

                                    </td>

                            </table>
                            <?php
                            $variable = ServicioVariables::find()->where(['id_servicio' => $model->id_servicio])->all();

                            if ($variable) {
                            ?>
                                <legend>Servicio Adicional</legend>
                                <table class="table" style="width: 50%;">
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

                            <?php }
                            if ($pagos) {
                            ?>
                                <legend>Pagos previos</legend>
                                <table class="table">
                                    <tr style="background-color: #ededed;">
                                        <th>Fecha del pago</th>
                                        <th>Referencia</th>
                                        <th>Monto</th>
                                        <th>Moneda</th>
                                        <th>Tipo de pago</th>
                                        <th>Banco origen</th>
                                        <th>Método de pago</th>
                                        <th>Restan por pagar($)</th>
                                        <th>Tasa</th>
                                        <th>Observación</th>
                                        <th>Acción</th>
                                    </tr>
                                    <?php

                                    for ($i = 0; $i < count($pagos); $i++) {
                                    ?>
                                        <tr>
                                            <td>
                                                <?= Yii::$app->formatter->asDate($pagos[$i]['fecha_pago'], 'php:d-m-Y') ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?= $pagos[$i]['referencia']; ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?= $pagos[$i]['monto']; ?>
                                            </td>
                                            <td>
                                                <?= $pagos[$i]['id_tipo_moneda']; ?>
                                            </td>
                                            <td>
                                                <?= $pagos[$i]['tipo_pago']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($pagos[$i]['banco_origen']) {
                                                    $banco_origen = OperadorFinanciero::find()->where(['id_operador' => $pagos[$i]['banco_origen']])->one();
                                                    echo $banco_origen->nombre_operador;
                                                } else {
                                                    echo "-----";
                                                }
                                                ?>

                                            </td>
                                            <td>
                                                <?php $metodo = BaseMetodosPago::find()->where(['id_metodo' => $pagos[$i]['id_metodo']])->one();
                                                ?>

                                                <?= $metodo->nombre_metodo; ?>
                                            </td>
                                            <td style="background-color: yellow;">

                                                <?= Yii::$app->formatter->asDecimal($pagos[$i]['faltante'], 2);   ?>
                                            </td>
                                            <td>
                       
                                                <?=  number_format($pagos[$i]['tasa'], 2, ',', '.'). " Bs."?>
                                            </td>
                                            <td>

                                                <?= $pagos[$i]['observacion_pago'];   ?>
                                            </td>
                                            <td>

                                                <?= Html::a('Eliminar', ['borrarpago', 'id' => $pagos[$i]['id_pago'],'id_servicio' => $model->id_servicio], [
                                                    'class' => 'btn btn-danger',
                                                    'data' => [
                                                        'confirm' => 'Seguro que desea eliminar el pago  registrado?',
                                                        'method' => 'post',
                                                    ],
                                                ]) ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                            <?php }  ?>
                        </fieldset>
                    </div>


                </div>
                <?php $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>
                 <?= $form->field($model3, 'monto_pagar')->hiddenInput(['readonly' => true, 'value' => round($valor_bs, 2)])->label(false); ?>
                <div class="row">
                    <div class="col-md-12">
                        <fieldset>
                            <legend>Información del pago</legend>
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
                            <div class="row">
                                <div class="col-md-3">
                                    <?= $form->field($model3, 'tipo_pago')->widget(Select2::classname(), [
                                        'data' =>
                                        [
                                            'Pago móvil' => 'Pago móvil',
                                            'Transferencia' => 'Transferencia',
                                            'Efectivo (Bs)' => 'Efectivo (Bs)',
                                            'Efectivo (Divisas)' => 'Efectivo (Divisas)',
                                            'Zelle' => 'Zelle',
                                        ],
                                        'options' => ['placeholder' => 'Seleccione...'],
                                        'pluginOptions' => [
                                            'multiple' => false,
                                            'allowClear' => true,
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($model3, 'fecha_pago')->input('date', [
                                        'max' => date('Y-m-d'),

                                    ])->widget(DatePicker::className(), []) ?>
                                </div>

                                <div class="col-md-3">
                                    <?= $form->field($model3, 'monto')->textInput(['maxlength' => true]) ?>
                                </div>

                                <div class="col-md-3">
                                    <?= $form->field($model3, 'referencia')->textInput(['maxlength' => true]) ?>
                                </div>

                                <?= $form->field($model3, 'id_servicio')->hiddenInput(['readonly' => true, 'value' => $model->id_servicio])->label(false); ?>

                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <?= $form->field($model3, 'id_tipo_moneda')->widget(Select2::classname(), [
                                        'data' =>
                                        [
                                            'Bs' => 'Bs',
                                            '$' => 'Dolares',

                                        ],
                                        'options' => ['placeholder' => 'Seleccione...'],

                                        'pluginOptions' => [
                                            'multiple' => false,
                                            'allowClear' => true,
                                            'value' => ['Bs'],
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <div class="col-md-3">
                                    <?php
                                    $operadores = OperadorFinanciero::find()->all();
                                    $lisoperador = ArrayHelper::map($operadores, 'id_operador', 'nombre_operador');
                                    echo $form->field($model3, 'banco_origen')->widget(Select2::classname(), [
                                        'data' => $lisoperador,
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
                                    $metodo = BaseMetodosPago::find()->all();
                                    $lismetodo = ArrayHelper::map($metodo, 'id_metodo', 'nombre_metodo');
                                    echo $form->field($model3, 'id_metodo')->widget(Select2::classname(), [
                                        'data' => $lismetodo,
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
                                    <?php echo $form->field($model3, 'observacion_pago')->textarea(['rows' => 2]); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo $form->field($model2, 'observacion')->textarea(['rows' => 2])->label("Observación general para el conductor asignado"); ?>
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