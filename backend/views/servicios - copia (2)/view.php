<?php

use backend\models\Banco;
use backend\models\BaseMetodosPago;
use backend\models\BaseTipoVehiculo;
use backend\models\Cliente;
use backend\models\Estatus;
use backend\models\MetodoPago;
use backend\models\MovServicio;
use backend\models\OperadorFinanciero;
use backend\models\Pasajero;
use backend\models\PasajeroServicio;
use backend\models\ServicioPago;
use backend\models\ServicioVariables;
use backend\models\TipoRuta;
use backend\models\TipoTrasladoRuta;
use backend\models\User;
use backend\models\VariablesServicio;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Servicios */

$this->title = "Num de Servicio: ". $model->id_servicio;
$this->params['breadcrumbs'][] = ['label' => 'Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="servicios-view">

    <div class="box box-widget widget-user-2">
        <div class="box box-primary">
            <div class="box-body">
            <div class="col-md-12">
                <fieldset>
                    <legend>Detalles del Servicio</legend>
                    <table class="table">
                        <tr style="background-color: #ededed;">
                            <th>Nro.</th>
                            <th>Fecha del Registro</th>
                            <th>Tipo de Servicio</th>
                            <th>Km</th>
                            <th>Fecha del Servicio</th>
                            <th>Monto ($)</th>
                            <th>Estatus</th>
                            <th>Usuario</th>
                        </tr>
                        <tr>
                            <td><?=$model->id_servicio?></td>
                            <td>
                                <?= Yii::$app->formatter->asDate($model->fecha_registro, 'php:d-m-Y') ?>
                            </td>
                            <td>
                                <?php
                                    $tipo_vehiculo = BaseTipoVehiculo::find()->where(['id'=>$model->id_tipo_vehiculo])->one();
                                    $ruta = TipoTrasladoRuta::find()->where(['id'=>$model->id_tipo_traslado_ruta])->one();
                                    $tipo_ruta = TipoRuta::find()->where(['id'=>$model->id_tipo_ruta])->one();
                                    echo $tipo_vehiculo->nombre_tipo_vehiculo."/". $ruta->nombre_traslado_ruta."/".$tipo_ruta->nombre_ruta;
                                ?>
                            </td>
                            <td><?=$model->km_servicio?></td>
                            <td>
                                <?= Yii::$app->formatter->asDate($model->fecha_servicio, 'php:d-m-Y') ?>
                            </td>
                            <td><?=$model->monto?></td>
                            <td>
                                <?php
                                    $estatus = Estatus::find()->where(['id'=>$model->id_estatus])->one();


                                    if ($estatus['id']== 4)
                                        $callout='yellow';
                                    else
                                        $callout='green';

                                    echo '<small class="label bg-' . $callout . '">' .  $estatus->estatus . '</small>';
                                ?>
                            </td>
                            <td>
                                <?php
                                    $usuario = User::find()->where(['id'=>$model->id_usuario])->one();
                                    echo $usuario->username;
                                ?> 
                            </td>   
                        </tr>
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

                    <legend>Cliente</legend>
                    <?php
                        $cliente = Cliente::find()->where(['id_cliente'=>$model->id_cliente])->one();
                    ?>
                    <table class="table">
                        <tr style="background-color: #ededed;">
                            <th>Nombre/Razón Social</th>
                            <th>Cédula/RIF</th>
                            <th>Teléfono</th>
                            <th>Teléfono Alterno</th>
                            <th>Correo</th>
                            <th>Dirección</th>
                        </tr>
                        <tr>
                            <td> 
                                <?=$cliente->nombre_apellido;?>
                            </td>
                            <td> 
                                <?=$cliente->cedula;?>
                            </td>
                            <td> 
                                <?=$cliente->telefono_principal;?>
                            </td>
                            <td> 
                                <?php
                                    if ($cliente->telefono_alterno)
                                        echo $cliente->telefono_alterno;
                                    else
                                        echo "--";
                                ?>
                            </td>
                            <td> 
                                <?=$cliente->correo;?>
                            </td>
                            <td> 
                                <?=$cliente->direccion;?>
                            </td>
                        </tr>
                    </table>

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
                    <?php if ($model->id_estatus == 6 or $model->id_estatus == 7) { ?>

                    <legend>Pagos Realizados</legend>

                    <table class="table">
                        <tr style="background-color: #ededed;">
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Referencia</th>
                            <th>Banco</th>
                            <th>Método de Pago</th>
                            <th>Tasa</th>
                            <th>Registrado por</th>
                
                        </tr>
                        <tr>
                        <?php
                        $pago = ServicioPago::find()->where(['id_servicio'=>$model->id_servicio])->all();
                        for ($i=0; $i < count($pago); $i++) { 
                            ?>
                            <tr>
                                <td>
                                    <?= Yii::$app->formatter->asDate($pago[$i]['fecha_pago'], 'php:d-m-Y') ?>
                                </td>
                                <td>
                                    <?php
                                        if ($pago[$i]['id_tipo_moneda'] == 'Bs') {
                                            $monto_pagado_divisa=  $pago[$i]['monto'] / $pago[$i]['tasa'];
                                        } else {
                                            $monto_pagado_divisa= $pago[$i]['monto'] = $pago[$i]['monto'];
                                        }
            
                                            $callout='green';

                                        echo  $pago[$i]['id_tipo_moneda']. " ".number_format($pago[$i]['monto'], 2, ',', '.'). '<br> <small class="label bg-' . $callout . '">' . "<b> Equivale a: ($ ".number_format($monto_pagado_divisa, 2, ',', '.') .")</b>". '</small>'?>
                                </td>
                                <td>
                                    <?= $pago[$i]['referencia']?>
                                </td>
                                <td>
                                    <?php $banco = OperadorFinanciero::find()->where(['id_operador'=>$pago[$i]['banco_origen']])->one(); ?>    
                                    <?= $banco->nombre_operador;?>
                                </td>
                                <td>
                                    <?php $metodo = BaseMetodosPago::find()->where(['id_metodo'=>$pago[$i]['id_metodo']])->one(); ?>    
                                    <?= $metodo->nombre_metodo;?>
                                </td>
                                <td>
                                    <?=  number_format($pago[$i]['tasa'], 2, ',', '.'). " Bs."?>
                                </td>
                                <td>
                                <?php $usuario = User::find()->where(['id'=>$pago[$i]['id_usuario']])->one(); ?>    
                                <?= $usuario->username;?>
                                </td>
                               
                            </tr>
                            <?php
                        }
                    }
                ?>
                </table>
            </fieldset>
            </div>
            <div class="col-md-12">
                <hr>
                <label>Observaciones Inicial del Servicio</label>
                <?= $model->observacion_inicial;?>
                <hr>
            </div>
            <div class="col-md-12">
            <legend>Historial del Servicio</legend>
                    <table class="table">
                        <tr style="background-color: #ededed;">
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Estatus</th>
                            <th>Observación</th>
                        </tr>
                        <tr>
                        <?php
                        $mov = MovServicio::find()->where(['id_servicio'=>$model->id_servicio])->orderBy(['id_mov_servicio' => SORT_DESC])->all();
                        for ($i=0; $i < count($mov); $i++) { 
                            ?>
                            <tr>
                                <td>
                                    <?= Yii::$app->formatter->asDate($mov[$i]['fecha'], 'php:d-m-Y') ?>
                                </td>
                                <td>
                                    <?php $usuario = User::find()->where(['id'=>$mov[$i]['id_usuario']])->one(); ?>    
                                    <?= $usuario->nombres . " ".$usuario->apellidos;?>
                                </td>
                                <td>
                                    <?php $estatus = Estatus::find()->where(['id'=>$mov[$i]['id_estatus']])->one(); ?>    
                                    <?= $estatus->estatus;?>
                                </td>
                                <td>
                                    <?= $mov[$i]['observacion']?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
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