<?php
use yii\helpers\Html;
$azulOscuro = "#1B242D";
$naranja = "#EA4C2D";
$baseUrl = Yii::getAlias('@webroot');
$logo = $baseUrl . '/img/logo_reportes.png'; // Ajusta la extensión si es .jpg o .svg
$foto = (!empty($model->foto)) ? $baseUrl . $model->foto : $baseUrl . '/img/imagen_vacio.png';
?>

<div style="font-family: Arial, sans-serif; color: #333;">
    <table width="100%" style="border-bottom: 3px solid <?= $naranja ?>; padding-bottom: 10px;">
        <tr>
            <td width="70%">
                <h1 style="color: <?= $azulOscuro ?>; margin: 0;">FICHA DEL CONDUCTOR</h1>
            </td>
            <td width="30%" align="right">
                <img src="<?= $logo ?>" width="50">
            </td>
        </tr>
    </table>

    <br>

    <table width="100%" cellpadding="10" style="border: 1px solid #eee;">
        <tr>
            <td width="25%" align="center" style="border-right: 1px solid #eee;">
                <div style="border: 1px solid #333; width: 150px; height: 180px; overflow: hidden;">
                    <img src="<?= $foto ?>" style="width: 20%; height: 20%; object-fit: cover;">
                </div>
            </td>
            <td width="75%" valign="top">
                <h2 style="color: <?= $azulOscuro ?>; text-transform: uppercase; margin-bottom: 5px;">
                    <?= $model->nombres . " " . $model->apellidos ?>
                </h2>
                <p style="font-size: 16px;">
                    <b>CÉDULA:</b> <?= ($model->nacionalidad == 1 ? "V-" : "E-") . $model->cedula ?><br>
                    <b>ESTATUS:</b> <?= $model->estatus == 1 ? 'ACTIVO' : 'INACTIVO' ?><br>
                    <b>TIPO:</b> <?= $model->tercerizado == 1 ? 'ALIANZA' : 'PROPIO' ?>
                </p>
            </td>
        </tr>
    </table>

    <h4 style="background: <?= $azulOscuro ?>; color: white; padding: 5px 10px; margin-top: 20px;">INFORMACIÓN DE CONTACTO</h4>
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <th align="left" style="border: 1px solid #ddd; padding: 8px; background: #f9f9f9;">CORREO</th>
            <td style="border: 1px solid #ddd; padding: 8px;"><?= $model->correo ?></td>
        </tr>
        <tr>
            <th align="left" style="border: 1px solid #ddd; padding: 8px; background: #f9f9f9;">TELÉFONO PRINCIPAL</th>
            <td style="border: 1px solid #ddd; padding: 8px;"><?= $model->telefono_principal ?></td>
        </tr>
        <tr>
            <th align="left" style="border: 1px solid #ddd; padding: 8px; background: #f9f9f9;">TELÉFONO ALTERNO</th>
            <td style="border: 1px solid #ddd; padding: 8px;"><?= $model->telefono_alterno ?: 'N/A' ?></td>
        </tr>
    </table>

    <h4 style="background: <?= $azulOscuro ?>; color: white; padding: 5px 10px; margin-top: 20px;">DATOS LABORALES</h4>
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <th align="left" style="border: 1px solid #ddd; padding: 8px; background: #f9f9f9;">FECHA INGRESO</th>
            <td style="border: 1px solid #ddd; padding: 8px;"><?= date('d-m-Y', strtotime($model->fecha_ingreso)) ?></td>
            <th align="left" style="border: 1px solid #ddd; padding: 8px; background: #f9f9f9;">FECHA EGRESO</th>
            <td style="border: 1px solid #ddd; padding: 8px;"><?= $model->fecha_egreso ? date('d-m-Y', strtotime($model->fecha_egreso)) : 'VIGENTE' ?></td>
        </tr>
    </table>

    <h4 style="background: <?= $azulOscuro ?>; color: white; padding: 5px 10px; margin-top: 20px;">OBSERVACIONES</h4>
    <div style="border: 1px solid #ddd; padding: 10px; min-height: 100px; font-size: 12px; background: #fcfcfc;">
        <?= $model->observacion_inicial ?: 'Sin observaciones.' ?>
    </div>

    <div style="margin-top: 60px; text-align: center;">
        <table width="100%">
            <tr>
                <td width="45%" style="border-top: 1px solid #000;">Firma del Conductor</td>
                <td width="10%"></td>
                <td width="45%" style="border-top: 1px solid #000;">CH Group</td>
            </tr>
        </table>
    </div>
</div>