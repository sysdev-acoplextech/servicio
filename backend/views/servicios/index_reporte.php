<?php

use mdm\admin\components\Helper;

$controllerId = $this->context->uniqueId . '/';

?>
<div class="box box-widget widget-user-2">
    <div class="widget-user-header bg-navy">
        <div class="widget-user-image">
            <table width='100%'>
                <tr>
                    <th align="left" width="95%">
                        <h4><span class="glyphicon glyphicon-signal"></span>&nbsp; <b>Reportes General de Servicios</b></h4>
                    </th>
                </tr>
            </table>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-body">
            <?php if (Helper::checkRoute($controllerId . 'resumen-servicios')) { ?>
                <div class="col-md-3">
                    <!-- Servicios Concluidos -->
                    <button type="button" class="btn btn-app" data-toggle="modal" data-target="#modal-pagotec">
                        <i class="fa fa-handshake-o"></i> <b>Servicios Concluidos</b>
                    </button>
                </div>
            <?php
                echo $this->render('form_servicios_resumen', ['model' => $model]);
            }
            ?>
            <?php if (Helper::checkRoute($controllerId . 'resumen-servicios')) { ?>
                <div class="col-md-3">
                    <!-- carterda de creditos (creditos) -->
                    <button type="button" class="btn btn-app" data-toggle="modal" data-target="#modal-pagotec">
                        <i class="fa fa-taxi"></i> <b>Conductores</b>
                    </button>
                </div>
            <?php
                echo $this->render('form_servicios_resumen', ['model' => $model]);
            }
            ?>
            <?php if (Helper::checkRoute($controllerId . 'resumen-servicios')) { ?>
                <div class="col-md-3">
                    <!-- carterda de creditos (creditos) -->
                    <button type="button" class="btn btn-app" data-toggle="modal" data-target="#modal-pagotec">
                        <i class="fa fa-users"></i> <b>Clientes</b>
                    </button>
                </div>
            <?php
                echo $this->render('form_servicios_resumen', ['model' => $model]);
            }
            ?>
            <?php if (Helper::checkRoute($controllerId . 'gestion-pago')) { ?>
                <div class="col-md-3">
                    <!-- carterda de creditos (creditos) -->
                    <button type="button" class="btn btn-app" data-toggle="modal" data-target="#modal-gestion">
                        <i class="fa fa-credit-card-alt"></i> <b>Gestión de Pagos</b>
                    </button>
                </div>
            <?php
                echo $this->render('form_gestion_pago', ['model' => $model]);
            }
            ?>
        </div>
    </div>
</div>