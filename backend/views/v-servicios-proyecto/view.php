<?php

use backend\models\Estatus;
use backend\models\Tasadia;
use backend\models\User;
use backend\models\VServicios;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Servicios */

$this->title = "Cliente: " . " (" . $model->cedula . ") " .  $model->nombre_apellido;
$this->params['breadcrumbs'][] = ['label' => 'Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerJsFile('@web/js/solicitudes.js');
?>

<div class="servicios-view">

    <div class="box box-widget widget-user-2">
        <div class="box box-primary">
            <div class="box-body">
                <div class="col-md-12">
                    <fieldset>
                        <legend>Servicio del cliente</legend>
                        <table class="table">
                            <tr>
                                <th>Nro.</th>
                                <th>Fecha del Servicio</th>
                                <th>Tipo de Servicio</th>
                                <th>Monto ($)</th>
                                <th>Estatus</th>
                                <th>Registrado por</th>
                                <th>Facturar</th>
                            </tr>
                            <?php
                            $estatus = [5, 6, 8];
                            $mov = VServicios::find()->where(['id_cliente' => $model->id_cliente, 'tipo_servicio' => 2,
                             'id_estatus' => $estatus, 'facturado' =>NULL ])->orderBy(['id_servicio' => SORT_ASC])->all();
                            for ($i = 0; $i < count($mov); $i++) {
                            ?>
                                <tr>
                                    <td>
                                        <?= $i + 1 ?>
                                    </td>
                                    <td>
                                        <?= Yii::$app->formatter->asDate($mov[$i]['fecha_servicio'], 'php:d-m-Y') ?>
                                    </td>

                                    <td>
                                        <?= $mov[$i]->nombre_tipo_vehiculo . "/" . $mov[$i]->nombre_traslado_ruta; ?>
                                    </td>
                                    <td>
                                        <?= $mov[$i]->monto; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $estatus = Estatus::find()->where(['id' => $mov[$i]->id_estatus])->one();


                                        if ($estatus['id'] == 4)
                                            $callout = 'yellow';
                                        else
                                            $callout = 'green';

                                        echo '<small class="label bg-' . $callout . '">' .  $estatus->estatus . '</small>';
                                        ?>
                                    </td>

                                    <td>
                                        <?php $usuario = User::find()->where(['id' => $mov[$i]['id_usuario']])->one(); ?>
                                        <?= $usuario->nombres . " " . $usuario->apellidos; ?>
                                    </td>
                                    <td>
                                  
                                        <input type="checkbox" 
                                        id="che-<?= $mov[$i]['id_servicio']; ?>"
                                        name="eve-<?= $mov[$i]['id_servicio']; ?>"  
                                        onclick="suma_monto_factura(<?=$mov[$i]['monto']?>,<?= $mov[$i]['id_servicio']; ?>)">
                                    </td>

                                </tr>
                            <?php
                            }
                            ?>
                        </table>



                        <div class="col-md-12">
                            <legend>Detalles de la factura</legend>
                      
                            <div class="alert alert-success col-md-12" id="view_monto" style="display:none">
                                                                        </div>
                            <?php $form = ActiveForm::begin(); ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <?= $form->field($model2, 'num_factura')->textInput() ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($model2, 'fecha_factura')->input('date', [
                                'max' => date('Y-m-d')
                            ])->widget(DatePicker::className(), [
                                'options' => ['placeholder' => 'Selecciona la fecha'],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-mm-yyyy',
                                    'todayHighlight' => true,
                                    'value' => date('Y-m-d'),
                                ],
                                'value' => date('Y-m-d'), // Establecer la fecha de hoy como valor predeterminado
                            ])
                            
                            ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($model2, 'monto_facturado')->textInput(['id' => 'monto_facturado','value' => 0,'readonly'=>true]) ?>
                                </div>
                                <div class="col-md-3">
                                    <?php
                                    $tasa = Tasadia::find()->where(['id_estatus' => 1])->one();
                                    ?>
                                    <?= $form->field($model2, 'tasa_dia')->textInput(['id' => 'tasa','value' => $tasa->valor,'onchange' => 'recalcular_factura()']) ?>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model2, 'observacion')->textarea(['rows' => 6]) ?>
                                    <?= $form->field($model2, 'iva')->hiddenInput(['value' => 0,'id' => 'iva'])->label(false); ?>
                                    <?= $form->field($model2, 'item_seleccionados')->hiddenInput(['id' => 'item_seleccionados'])->label(false); ?>
                                    <?= $form->field($model2, 'monto_bs')->hiddenInput(['id' => 'monto_bs'])->label(false); ?>
                                    <?= $form->field($model2, 'id_cliente')->hiddenInput(['value' => $model->id_cliente])->label(false); ?>
                                </div>
                                </div>
                          
                        </div>
                        <div class="form-group">
                            <div class="box-tools pull-right">
                                
                                <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> <b>Regresar</b>', ['index'], ['class' => 'btn btn-warning btn']) ?>
                                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>
    </div>