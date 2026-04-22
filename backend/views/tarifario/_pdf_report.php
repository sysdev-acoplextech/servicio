<?php

use yii\helpers\Html;

?>
<div class="header-pdf">
    <table style="border: none;">
        <tr>
            <td style="border: none; width: 50%;">
                <div class="title">Tarifario Maestro</div>
                <div style="color: #64748B; font-size: 10pt;">Reporte General de Rutas y Servicios</div>
            </td>
            <td style="border: none; width: 50%; text-align: right;">
                <div style="font-weight: bold; color: #1E293B;">CH GROUP 2</div>
                <div style="font-size: 8pt; color: #94A3B8;">Fecha de impresión: <?= date('d/m/Y H:i') ?></div>
            </td>
        </tr>
    </table>
</div>

<?php foreach ($tarifarios as $tarifario): ?>
    <div class="card">
        <div class="tarifario-title">
            <?= Html::encode($tarifario->descripcion) ?> 
            <span style="color: #94A3B8; font-size: 9pt; font-weight: normal;">(ID: #<?= $tarifario->id_tarifario ?>)</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="40%">Ruta o Destino</th>
                    <th width="15%" style="text-align: center;">Viático</th>
                    <th width="22.5%" class="text-right">Sedan ($)</th>
                    <th width="22.5%" class="text-right">Camioneta ($)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tarifario->detalles as $detalle): ?>
                    <tr>
                        <td style="font-weight: bold; color: #334155;">
                            <?= Html::encode($detalle->rutas) ?>
                        </td>
                        <td style="text-align: center;">
                            <?php if ($detalle->inc_viatico): ?>
                                <span class="badge">SÍ</span>
                            <?php else: ?>
                                <span style="color: #CBD5E1;">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-right" style="font-family: monospace;">
                            <?= number_format($detalle->sedan, 2, ',', '.') ?>
                        </td>
                        <td class="text-right" style="font-family: monospace;">
                            <?= number_format($detalle->camioneta, 2, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>

<div class="footer">
    Este documento es una representación oficial de los precios vigentes a la fecha.
</div>