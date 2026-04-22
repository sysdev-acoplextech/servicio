<?php
use yii\helpers\Html;

// Paleta de Colores MISACDI
$naranja = "#EA4C2D";
$azulOscuro = "#1B242D";
$celeste = "#98C1D9";
$grisTexto = "#666666";
$fondoFila = "#F9F9F9";

// Ruta base del servidor para mPDF
$webroot = Yii::getAlias('@webroot'); 
$rutaVacia = $webroot . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'imagen_vacio.png';

?>

<div style="background-color: #FFFFFF; padding: 5px; font-family: 'Helvetica', sans-serif;">

    <div style="background-color: <?= $azulOscuro ?>; color: #FFFFFF; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
        <table width="100%" style="border-collapse: collapse;">
            <tr>
                <td>
                    <div style="font-size: 16pt; font-weight: bold; color:#FFFFFF" >REPORTE DE CONDUCTORES</div>
                    <div style="font-size: 9pt; color: <?= $celeste ?>; text-transform: uppercase;">Gestión de conductores</div>
                </td>
                <td align="right">
                    <div style="font-size: 16pt; font-weight: bold; color:#FFFFFF"><?= date('d/m/Y') ?></div>
                    <div style="font-size: 9pt; opacity: 0.8; color:#FFFFFF;">TOTAL: <?= count($conductores) ?> REGISTROS</div>
                </td>
            </tr>
        </table>
    </div>

    <table width="100%" style="border-collapse: separate; border-spacing: 0 8px;">
        <thead>
            <tr style="color: <?= $grisTexto ?>; font-size: 7.5pt; text-transform: uppercase; font-weight: bold;">
                <th width="60" style="padding-bottom: 5px;">PERFIL</th>
                <th align="left" style="padding-bottom: 5px; padding-left: 10px;">IDENTIFICACIÓN / DATOS</th>
                <th align="center" style="padding-bottom: 5px;">INGRESO</th>
                <th align="center" style="padding-bottom: 5px;">EGRESO</th>
                <th align="center" style="padding-bottom: 5px;">TIPO</th>
                <th width="90" style="padding-bottom: 5px;">ESTATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($conductores as $conductor): ?>
            <tr style="background-color: <?= $fondoFila ?>;">
                
                <td align="center" style="border: 1px solid #F0F0F0; border-right: none; border-radius: 12px 0 0 12px; padding: 10px;">
                    <?php 
                        // Construimos la ruta física reemplazando separadores para Windows
                        $fotoDb = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $conductor->foto);
                        $fullPath = $webroot . $fotoDb;

                        if (empty($conductor->foto) || !file_exists($fullPath)) {
                            $imgFinal = $rutaVacia;
                        } else {
                            $imgFinal = $fullPath;
                        }

                        echo '<img src="' . $imgFinal . '" style="width: 48px; height: 48px; border-radius: 7px; border: 1.5px solid '.$celeste.'; object-fit: cover;">'; 
                    ?>
                </td>

                <td style="border-top: 1px solid #F0F0F0; border-bottom: 1px solid #F0F0F0; padding: 10px;">
                    <div style="font-size: 10pt; color: <?= $naranja ?>; font-weight: bold;">
                        <?= ($conductor->nacionalidad == '1') ? 'V' : 'E' ?>-<span style="padding: 0 4px; border-radius: 3px; font-size: 9pt;"><?= number_format($conductor->cedula, 0, '', '.') ?></span>
                    </div>
                    <div style="font-size: 9.5pt; font-weight: bold; text-transform: uppercase; margin-top: 2px;">
                        <?= $conductor->nombres . ' ' . $conductor->apellidos ?>
                    </div>
                    <div style="font-size: 8pt; color: <?= $grisTexto ?>; margin-top: 2px;">
                        <?= strtolower($conductor->correo) ?> | <?= $conductor->telefono_principal ?>
                    </div>
                </td>

                <td align="center" style="border-top: 1px solid #F0F0F0; border-bottom: 1px solid #F0F0F0; padding: 10px; font-size: 8.5pt;">
                    <?= date('d/m/Y', strtotime($conductor->fecha_ingreso)) ?>
                </td>

                <td align="center" style="border-top: 1px solid #F0F0F0; border-bottom: 1px solid #F0F0F0; padding: 10px; font-size: 8.5pt; color: <?= $grisTexto ?>;">
                    <?= $conductor->fecha_egreso ? date('d/m/Y', strtotime($conductor->fecha_egreso)) : '---' ?>
                </td>

                <td align="center" style="border-top: 1px solid #F0F0F0; border-bottom: 1px solid #F0F0F0; padding: 10px;">
                    <span style="font-size: 7.5pt; font-weight: bold; color: <?= $conductor->tercerizado ? $celeste : $azulOscuro ?>;">
                        <?= $conductor->tercerizado ? 'ALIADO' : 'PROPIO' ?>
                    </span>
                </td>

                <td align="center" style="border: 1px solid #F0F0F0; border-left: none; border-radius: 0 12px 12px 0; padding: 10px;">
                    <div style="background-color: #E6F4EA; color: #1E7E34; padding: 4px 8px; border-radius: 7px; font-size: 7pt; font-weight: bold;">
                        <?= $conductor->estatus ? 'ACTIVO' : 'INACTIVO' ?>
                    </div>
                </td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="margin-top: 15px; text-align: center; font-size: 7.5pt; color: <?= $grisTexto ?>; opacity: 0.5;">
        *** Fin del Reporte de Conductores ***
    </div>
</div>