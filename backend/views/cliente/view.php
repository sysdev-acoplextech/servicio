<?php

use backend\models\BaseNosConoce;
use backend\models\BaseTipoCliente;
use backend\models\Cliente;
use backend\models\Estatus;
use backend\models\GeoEstado;
use backend\models\GeoMunicipio;
use backend\models\GeoParroquia;
use backend\models\TipoServicio;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Cliente */

$this->title = $model->nombre_apellido;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);



?>

<style type="text/css">
    .inclined-label {
        position: relative;
        display: inline-block;
        font-size: 16px;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 5px;
        background-color: #f0f0f0;
        color: #333;
    }

    .inclined-label::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        transform: rotate(-45deg);
        background-color: #f0f0f0;
    }
</style>

<div class="cliente-view">

    <div class="box box-widget widget-user">
        <div class="widget-user-header bg-navy">
            <h3><b>
                    <span class="glyphicon glyphicon-user"></span>
                    <?php
                    echo strtoupper($model->nombre_apellido);
                    ?>
                </b></h3>

        </div>

        <div class="row">
            <div class="col-sm-12">
                <fieldset>
                    <legend>
                        <h1 class="page-header text-primary">&nbsp;&nbsp;<span class="glyphicon glyphicon-list-alt"></span>&nbsp; <b>Datos del Cliente</b></h1>
                    </legend>
                    <div class="description-block">

                        <?php

                        if ($model->cliente_grato == TRUE) { ?>
                            <div class="alert alert-danger" role="alert" style="width: 60%; margin-left: 20%">
                                CLIENTE NO GRATO
                            </div>
                        <?php } ?>

                        <table class="table table-bordered" style="width: 90%; margin-left: 5%">
                            <tr style="background-color:#c8c5c4">
                                <th>Tipo de Cliente</th>
                                <th>Identificación</th>
                                <th>Teléfono princicipal</th>
                                <th>Teléfono alterno</th>
                                <th>Correo</th>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    if (empty($model->id_tipo_cliente)) {
                                        echo "No definido";
                                    } else {
                                        $usuario_registro = BaseTipoCliente::find()->where(['id' => $model['id_tipo_cliente']])->one();
                                        echo $usuario_registro->nombre_tipo_cliente;
                                    }


                                    ?>
                                </td>
                                <td><?= $model->cedula; ?></td>
                                <td><?= $model->telefono_principal; ?></td>
                                <td>
                                    <?php
                                    if ($model->telefono_alterno)
                                        echo $model->telefono_alterno;
                                    else
                                        echo "-";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($model->correo)
                                        echo $model->correo;
                                    else
                                        echo "-";
                                    ?>
                                </td>
                            </tr>
                            <tr style="background-color:#c8c5c4">
                                <th>Estado</th>
                                <th>Municipio</th>
                                <th>Parroquia</th>
                                <th colspan="2">Dirección</th>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    $usuario_registro = GeoEstado::find()->where(['id' => $model['id_estado']])->one();
                                    if (isset($usuario_registro->nombre))
                                        echo $usuario_registro->nombre;
                                    else
                                        echo "-";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $usuario_registro = GeoMunicipio::find()->where(['id' => $model['id_municipio']])->one();
                                    if (isset($usuario_registro->nombre_municipio))
                                        echo $usuario_registro->nombre_municipio;
                                    else
                                        echo "-";
                                    ?>
                                </td>
                                <td> <?php
                                        $usuario_registro = GeoParroquia::find()->where(['id' => $model['id_parroquia']])->one();
                                        if (isset($usuario_registro->nombre_parroquia))
                                            echo $usuario_registro->nombre_parroquia;
                                        else
                                            echo "-";
                                        ?></td>
                                <td colspan="2">
                                    <?php
                                    if ($model->direccion)
                                        echo $model->direccion;
                                    else
                                        echo "-";
                                    ?>
                                </td>
                            </tr>
                            <tr style="background-color:#c8c5c4">
                                <th>Referido</th>
                                <th>Nos conoce</th>
                                <th>Fecha de Cumpleaños</th>
                                <th>Viaje Frecuentes</th>
                                <th>¿Desea recibir correos, Whatsapp?</th>
                            </tr>
                            <tr>
                                <td> <?php
                                        $usuario_registro = Cliente::find()->where(['id_cliente' => $model['id_referido']])->one();
                                        if ($usuario_registro)
                                            echo $usuario_registro->nombre_apellido;
                                        else
                                            echo "-";
                                        ?></td>
                                <td>
                                    <?php
                                    $usuario_registro = BaseNosConoce::find()->where(['id' => $model['id_nos_conoce']])->one();
                                    if ($usuario_registro)
                                        echo $usuario_registro->nombre_nos_conoce;
                                    else
                                        echo "-";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($model->fecha_cumpleanos)
                                        echo $model->fecha_cumpleanos;
                                    else
                                        echo "-";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($model->viaja_frecuente)
                                        echo $model->viaja_frecuente;
                                    else
                                        echo "-";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($model->viaja_frecuente == 0)
                                        echo "No";
                                    else
                                        echo "Si";
                                    ?>
                                </td>
                            </tr>
                        </table>


                        <table class="table table-bordered" style="width: 90%; margin-left: 5%">
                            <?php if ($model->id_tipo_cliente == 2) { ?>
                                <tr style="background-color:#c8c5c4">
                                    <th colspan="5">Persona autorizada para solicitar servicios: </th>
                                </tr>
                                <tr style="background-color:#c8c5c4">
                                    <th>Nombre y apellido</th>
                                    <th>Teléfono Principal</th>
                                    <th>Teléfono Alterno</th>
                                    <th>Correo</th>
                                    <th>Cargo</th>
                                </tr>
                                <tr>
                                    <td>
                                        <?php
                                        if (isset($model2->nombre_autorizada_servicio))
                                            echo $model2->nombre_autorizada_servicio;
                                        else
                                            echo "-";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($model2->telefono_p_autorizada_servicio))
                                            echo $model2->telefono_p_autorizada_servicio;
                                        else
                                            echo "-";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($model2->telefono_a_autorizada_servicio))
                                            echo $model2->telefono_a_autorizada_servicio;
                                        else
                                            echo "-";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($model2->correo_persona_autorizada))
                                            echo $model2->correo_persona_autorizada;
                                        else
                                            echo "-";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($model2->cargo))
                                            echo $model2->cargo;
                                        else
                                            echo "-";
                                        ?>
                                    </td>
                                </tr>
                                <hr>
                                <tr style="background-color:#c8c5c4">
                                    <th colspan="5">Persona de contacto relacionado a la gestión de cobro: </th>
                                </tr>
                                <tr style="background-color:#c8c5c4">
                                    <th>Nombre y apellido</th>
                                    <th>Teléfono Principal</th>
                                    <th>Teléfono Alterno</th>
                                    <th>Correo</th>
                                    <th>Cargo</th>
                                </tr>
                                <tr>
                                    <td>
                                        <?php
                                        if (isset($model2->nombre_contacto_paga))
                                            echo $model2->nombre_contacto_paga;
                                        else
                                            echo "-";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($model2->telefono_p_paga))
                                            echo $model2->telefono_p_paga;
                                        else
                                            echo "-";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($model2->telefono_a_paga))
                                            echo $model2->telefono_a_paga;
                                        else
                                            echo "-";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($model2->correo_paga))
                                            echo $model2->correo_paga;
                                        else
                                            echo "-";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($model2->cargo_paga))
                                            echo $model2->cargo_paga;
                                        else
                                            echo "-";
                                        ?>
                                    </td>
                                </tr>
                                <tr style="background-color:#c8c5c4">
                                    <th colspan="2">Correo para el envío de las retenciones: </th>
                                    <th colspan="3">
                                        <?php
                                        if (isset($model2->correo_envio_retenciones))
                                            echo $model2->correo_envio_retenciones;
                                        else
                                            echo "-";
                                        ?>
                                    </th>
                                </tr>
                            <?php } ?>

                        </table>
                </fieldset>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <fieldset>
                    <legend>
                        <h1 class="page-header text-primary">&nbsp;&nbsp;<span class="glyphicon glyphicon-th-list"></span>&nbsp; <b>Historial de Servicio</b></h1>
                    </legend>
                    <div class="description-block">
                        <?php
                         if (!empty($model3)) {     ?>
                        <table class="table table-bordered" style="width: 90%; margin-left: 5%">
                            <tr style="background-color:#c8c5c4">
                                <th>Fecha del Servicio</th>
                                <th>Estatus del Servicio</th>
                                <th>Monto del Servicio</th>
                                <th>Tipo de Servicio</th>
                                <th>Destino</th>
                            </tr>
                            <?php foreach ($model3 as $servicio) { ?>
                                <tr>
                                    <td>
                                        <?php
                                        if (isset($servicio->fecha_servicio))
                                            echo $servicio->fecha_servicio;
                                        else
                                            echo "-";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $estatus = Estatus::find()->where(['id'=>$servicio->id_estatus])->one();
                                            echo $estatus->estatus;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo " $".$servicio->monto;
                                        ?>
                                    </td>
                                    <td>
                                    <?php
                                            $tipo_servicio = TipoServicio::find()->where(['id'=>$servicio->tipo_servicio])->one();
                                            echo $tipo_servicio->nombre_servicio;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($servicio->destino))
                                            echo $servicio->destino;
                                        else
                                            echo "-";
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                        <?php }else{?>
                            <div class="alert alert-warning" role="alert" style="width: 60%; margin-left: 20%">
                                No se han encontrado servicios asociados a este cliente
                            </div>

                        <?php }?>

                </fieldset>
                <div class="form-group">
                    <div class="box-tools pull-right">
                        <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> <b>Regresar</b>', ['index'], ['class' => 'btn btn-warning btn']) ?>
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>