<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCss("
    .tarifario-form { background-color: #F8FAFC; padding: 20px; }
    
    /* Input Estilizado: Menos pesado, borde solo abajo al enfocar */
    .minimal-input {
        border: 1px solid #E2E8F0 !important;
        border-radius: 12px !important;
        padding: 10px 15px !important;
        height: auto !important;
        transition: all 0.3s;
        box-shadow: none !important;
    }
    .minimal-input:focus {
        border-color: #6366F1 !important;
        background-color: #F8FAFC;
    }

    /* Tabla de rutas tipo 'clean' */
    .table-tarifario { border-collapse: separate; border-spacing: 0 8px; }
    .table-tarifario thead th { 
        border: none !important; 
        color: #94A3B8; 
        font-size: 8pt; 
        text-transform: uppercase;
        padding: 10px 15px;
    }
    .table-tarifario tbody tr { 
        background: #FFFFFF; 
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .table-tarifario td { 
        border: none !important; 
        padding: 12px !important;
        vertical-align: middle !important;
    }
    .table-tarifario tr td:first-child { border-radius: 12px 0 0 12px; }
    .table-tarifario tr td:last-child { border-radius: 0 12px 12px 0; }

    .btn-circle {
        width: 32px; height: 32px; padding: 0; line-height: 32px;
        border-radius: 50% !important; font-size: 10pt;
    }
");

$this->registerJs("
    $('#btn-add-ruta').click(function() {
        var index = $('#tabla-detalles tbody tr').length; 
        var row = `<tr>
            <td><input type='text' name='Detalle[\${index}][rutas]' class='form-control minimal-input' placeholder='Destino...'></td>
            <td><input type='text' name='Detalle[\${index}][sedan]' class='form-control text-right minimal-input monto-input' value='0,00'></td>
            <td><input type='text' name='Detalle[\${index}][camioneta]' class='form-control text-right minimal-input monto-input' value='0,00'></td>
            <td class='text-center'>
                <input type='hidden' name='Detalle[\${index}][inc_viatico]' value='0'>
                <input type='checkbox' name='Detalle[\${index}][inc_viatico]' value='1' style='transform: scale(1.2); cursor: pointer;'>
            </td>
            <td class='text-center'><button type='button' class='btn btn-link text-danger btn-remove'><i class='fa fa-trash'></i></button></td>
        </tr>`;
        $('#tabla-detalles tbody').append(row);
    });

    $(document).on('click', '.btn-remove', function() { $(this).closest('tr').remove(); });
");
?>

<div class="tarifario-form">

    <?php $form = ActiveForm::begin(['id' => 'tarifario-dynamic-form']); ?>

    <div class="row">
        <div class="col-md-4">
            <div class="card-moderna" style="padding: 25px; border: 1px solid #E2E8F0;">
                <h5 style="font-weight: bold; color: #1B242D; margin-bottom: 20px;">Información General</h5>

                <?= $form->field($model, 'descripcion')->textInput([
                    'class' => 'form-control minimal-input',
                    'placeholder' => 'Nombre del tarifario...',
                ])->label('Descripción', ['style' => 'font-size: 9pt; color: #64748B;']) ?>

                <div style="margin-top: 30px; background: #F1F5F9; padding: 15px; border-radius: 15px;">
                    <small style="color: #64748B; display: block; margin-bottom: 10px;">
                        <i class="fa fa-info-circle"></i> Defina el nombre del grupo y luego agregue las rutas con sus respectivos costos para Sedan y Camioneta.
                    </small>
                </div>

                <div style="margin-top: 25px;">
                    <?= Html::submitButton('<i class="fa fa-check"></i> GUARDAR TARIFARIO', [
                        'class' => 'btn btn-success btn-block btn-modulo',
                        'style' => 'background: linear-gradient(135deg, #10B981 0%, #059669 100%); padding: 15px;'
                    ]) ?>
                </div>
            </div>
        </div>

            <div class="col-md-8">
                <div class="card-moderna" style="padding: 25px; min-height: 400px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h5 style="font-weight: bold; color: #1B242D; margin: 0;">Configuración de Rutas</h5>
                        <button type="button" id="btn-add-ruta" class="btn btn-primary btn-sm btn-modulo" style="background: #6366F1; font-size: 7.5pt;">
                            <i class="fa fa-plus"></i> AGREGAR FILA
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-tarifario" id="tabla-detalles">
                            <thead>
                                <tr>
                                    <th>Ruta o Destino</th>
                                    <th width="140" class="text-right">Sedan (VES)</th>
                                    <th width="140" class="text-right">Camioneta (VES)</th>
                                    <th width="80" class="text-center">Viático</th>
                                    <th width="40"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($detalles)): ?>
                                    <?php foreach ($detalles as $index => $detalle): ?>
                                        <tr>
                                            <td><?= Html::textInput("Detalle[$index][rutas]", $detalle->rutas, ['class' => 'form-control minimal-input']) ?></td>
                                            <td><?= Html::textInput("Detalle[$index][sedan]", number_format($detalle->sedan, 2, ',', '.'), ['class' => 'form-control text-right minimal-input monto-input']) ?></td>
                                            <td><?= Html::textInput("Detalle[$index][camioneta]", number_format($detalle->camioneta, 2, ',', '.'), ['class' => 'form-control text-right minimal-input monto-input']) ?></td>
                                            <td class="text-center">
                                                <?= Html::hiddenInput("Detalle[$index][inc_viatico]", 0) ?>
                                                <?= Html::checkbox("Detalle[$index][inc_viatico]", $detalle->inc_viatico, [
                                                    'value' => 1,
                                                    'style' => 'transform: scale(1.2); margin-top: 8px;'
                                                ]) ?>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-link text-danger btn-remove"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td><?= Html::textInput('Detalle[0][rutas]', '', ['class' => 'form-control minimal-input', 'placeholder' => 'Ej: Caracas - Valencia']) ?></td>
                                        <td><?= Html::textInput('Detalle[0][sedan]', '0,00', ['class' => 'form-control text-right minimal-input monto-input']) ?></td>
                                        <td><?= Html::textInput('Detalle[0][camioneta]', '0,00', ['class' => 'form-control text-right minimal-input monto-input']) ?></td>
                                        <td class="text-center">
                                            <?= Html::hiddenInput("Detalle[0][inc_viatico]", 0) ?>
                                            <?= Html::checkbox("Detalle[0][inc_viatico]", false, ['value' => 1, 'style' => 'transform: scale(1.2);']) ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>