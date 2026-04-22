<?php

use backend\models\Conductor;
use backend\models\User;
use backend\models\VConductores;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Flota */

?>
<div class="flota-view">

    <div class="box box-widget widget-user">
        <div class="widget-user-header bg-navy">
            <h3><b>
                    <span class="glyphicon glyphicon-bookmark"></span>
                    <?php
                    echo strtoupper($model->placa);
                    ?>
                </b></h3>

        </div>

        <div class="row">
            <div class="col-sm-12">
            <fieldset>
                <legend>
                <h1 class="page-header text-primary">&nbsp;&nbsp;<span class="glyphicon glyphicon-list-alt"></span>&nbsp; <b>Histórico de las Condiciones de la Flota</b></h1>
                </legend>
                <div class="description-block">
                <table class="table table-bordered" style="width: 60%; margin-left: 20%">
                    <tr style="background-color:#c8c5c4">
                        <th>Fecha</th>
                        <th>Observación</th>
                        <th>Usuario</th>
                    </tr>
                    <?php for ($i=0; $i < count($model2); $i++) { 
                       ?>
                        <tr>
                            <td>
                                <?php
                                    $fecha_registro=date_create($model2[$i]['fecha_registro']);
                                    echo $fecha_registro=date_format($fecha_registro, 'd-m-Y');
                                ?>
                            </td> 
                            <td>
                            <?php
                                echo $model2[$i]['observacion'];
                            ?>
                        </td> 
                            <td>
                            <?php
                                $usuario_registro=User::find()->where(['id'=>$model2[$i]['id_usuario']])->one(); 
                                echo $usuario_registro->nombres.  " " . $usuario_registro->apellidos;
                            ?>
                        </td> 
                        </tr>
                       
                       <?php
                    }?>
                    
                </table>
            </fieldset>
            </div>   
       
        <div class="col-sm-12">
            <fieldset>
                <legend>
                <h1 class="page-header text-primary">&nbsp;&nbsp;<span class="glyphicon glyphicon-list-alt"></span>&nbsp; <b>Histórico de las Asignaciones de la Flota</b></h1>
                </legend>
                <div class="description-block">
                <table class="table table-bordered" style="width: 60%; margin-left: 20%">
                    <tr style="background-color:#c8c5c4">
                        <th>Fecha</th>
                        <th>Conductor</th>
                    </tr>
                    <?php for ($i=0; $i < count($model3); $i++) { 
                       ?>
                        <tr>
                            <td>
                                <?php
                                    $fecha_registro=date_create($model3[$i]['fecha_asignacion']);
                                    echo $fecha_registro=date_format($fecha_registro, 'd-m-Y');
                                ?>
                            </td> 
                            <td>
                            <?php
                              $mov=VConductores::find()->where(['id'=>$model3[$i]['id_conductor']])->one(); 
                                echo $mov->datos;
                            ?>
                        </td> 
                        </tr>
                       
                       <?php
                    }?>
                    
                </table>
            </fieldset>
            </div>   
        </div>
        </div>
</div>