<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Conductor */

$this->title = "Ficha: " . $model->nombres . " " . $model->apellidos;
$azulOscuro = "#1B242D";
$naranja = "#EA4C2D";

$baseUrl = Yii::$app->request->baseUrl;
$img = (!empty($model->foto)) ? $baseUrl . $model->foto : $baseUrl . '/img/imagen_vacio.png';
?>

<div class="conductor-view" style="background-color: #fff; padding: 20px; border: 1px solid #eee; position: relative;">

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <?= Html::a('<i class="fa fa-pencil"></i> EDITAR', ['update', 'id' => $model->id], ['class' => 'btn btn-flat', 'style' => "background-color: $azulOscuro; color: white; font-weight: bold; border-radius: 0px;"]) ?>
        
        <?= Html::a('<i class="fa fa-file-pdf-o"></i> GENERAR PDF', ['pdf', 'id' => $model->id], [
            'class' => 'btn btn-flat', 
            'target' => '_blank', // Abre en pestaña nueva
            'style' => "background-color: $naranja; color: white; font-weight: bold; border-radius: 0px;"
        ]) ?>
    </div>

    <div class="row" style="margin-bottom: 25px; display: flex; align-items: center;">
        <div class="col-xs-3 col-sm-2 text-center">
            <div style="border: 2px solid #333; padding: 2px; background: #fff; width: 140px; height: 160px; overflow: hidden; margin: 0 auto;">
                <img src="<?= $img ?>" alt="Foto" style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
            </div>
        </div>
        <div class="col-xs-9 col-sm-10" style="padding-left: 30px;">
            <div style="border-left: 4px solid <?= $naranja ?>; padding-left: 15px;">
                <h2 style="margin: 0; color: <?= $azulOscuro ?>; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
                    <?= $model->nombres . " " . $model->apellidos ?>
                </h2>
                <h4 style="color: #555; margin: 5px 0;">
                    FICHA DE IDENTIFICACIÓN: <b><?= ($model->nacionalidad == 1 ? "V-" : "E-") . $model->cedula ?></b>
                </h4>
            </div>
            <div style="margin-top: 10px;">
                <span class="badge-status" style="background-color: <?= $model->estatus == 1 ? '#00a65a' : '#dd4b39' ?>;">
                    <?= $model->estatus == 1 ? 'ACTIVO' : 'INACTIVO' ?>
                </span>
                <span class="badge-status" style="background-color: <?= $model->tercerizado == 1 ? '#00c0ef' : '#f39c12' ?>; margin-left: 5px;">
                    <?= $model->tercerizado == 1 ? 'ALIANZA' : 'PROPIO' ?>
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <h5 class="print-header"><i class="fa fa-user"></i> INFORMACIÓN PERSONAL</h5>
            <table class="table table-ficha">
                <tr>
                    <th>Correo Electrónico</th>
                    <td><?= $model->correo ?></td>
                </tr>
                <tr>
                    <th>Teléfono Principal</th>
                    <td><?= $model->telefono_principal ?></td>
                </tr>
                <tr>
                    <th>Teléfono Alterno</th>
                    <td><?= $model->telefono_alterno ?: 'N/A' ?></td>
                </tr>
            </table>
        </div>

        <div class="col-xs-6">
            <h5 class="print-header"><i class="fa fa-briefcase"></i> DATOS LABORALES</h5>
            <table class="table table-ficha">
                <tr>
                    <th>Fecha de Ingreso</th>
                    <td><?= Yii::$app->formatter->asDate($model->fecha_ingreso, 'php:d-m-Y') ?></td>
                </tr>
                <tr>
                    <th>Fecha de Egreso</th>
                    <td><?= $model->fecha_egreso ? Yii::$app->formatter->asDate($model->fecha_egreso, 'php:d-m-Y') : 'VIGENTE' ?></td>
                </tr>
                <tr>
                    <th>Antigüedad</th>
                    <td>
                        <?php 
                            $d1 = new DateTime($model->fecha_ingreso);
                            $d2 = new DateTime();
                            $diff = $d1->diff($d2);
                            echo $diff->y . " años, " . $diff->m . " meses";
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-xs-12">
            <h5 class="print-header"><i class="fa fa-search"></i> OBSERVACIONES GENERALES</h5>
            <div style="border: 1px solid #ddd; padding: 15px; background: #f9f9f9; min-height: 100px; font-size: 13px;">
                <?= $model->observacion_inicial ?: 'Sin observaciones registradas en el sistema.' ?>
            </div>
        </div>
    </div>

    <div class="visible-print" style="margin-top: 50px; text-align: center; border-top: 1px solid #eee; padding-top: 20px;">
        <div style="display: flex; justify-content: space-around;">
            <div style="border-top: 1px solid #000; width: 200px; padding-top: 5px;">Firma del Conductor</div>
            <div style="border-top: 1px solid #000; width: 200px; padding-top: 5px;">Recursos Humanos</div>
        </div>
        <p style="margin-top: 20px; font-size: 10px; color: #999;">Generado por Sistema CH GROUP - <?= date('d-m-Y H:i') ?></p>
    </div>
</div>

<style>
    /* Estilos Generales Cuadrados */
    .badge-status { color: white; padding: 4px 10px; font-size: 11px; font-weight: bold; display: inline-block; border-radius: 0px !important; }
    .print-header { font-weight: bold; color: <?= $azulOscuro ?>; border-bottom: 2px solid <?= $naranja ?>; padding-bottom: 5px; margin-bottom: 10px; text-transform: uppercase; font-size: 12px; }
    .table-ficha th { background: #f4f4f4; width: 45%; font-size: 11px; text-transform: uppercase; padding: 8px !important; border: 1px solid #ddd !important; }
    .table-ficha td { padding: 8px !important; border: 1px solid #ddd !important; font-size: 12px; }

    /* CSS PARA IMPRESIÓN */
    @media print {
        body * { visibility: hidden; }
        .conductor-view, .conductor-view * { visibility: visible; }
        .conductor-view { position: absolute; left: 0; top: 0; width: 100%; border: none !important; }
        .no-print { display: none !important; }
        .visible-print { display: block !important; }
        .badge-status { border: 1px solid #000 !important; color: #000 !important; background: transparent !important; }
        .print-header { border-bottom: 2px solid #000 !important; color: #000 !important; }
        .table-ficha th { background: #eee !important; color: #000 !important; }
    }
    
    .visible-print { display: none; }
</style>