<?php

use backend\models\BaseMetodosPago;
use backend\models\Tasadia;
use backend\models\BaseTipoVehiculo;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Servicio */
/* @var $model3 backend\models\ServicioPago */
/* @var $pagos array */

$tasa = Tasadia::find()->where(['id_estatus' => TRUE])->one();

// LÓGICA DE ESTADOS
// Si faltante es null, es que no ha pagado nada.
$es_nuevo = is_null($model->faltante);
$esta_solvente = (!$es_nuevo && $model->faltante <= 0.1);

// Definición de montos para mostrar (Formato manual para asegurar coma decimal)
if ($es_nuevo) {
    $valor_dolares = $model->monto;
    $valor_bs = $model->monto * $tasa->valor;
} else {
    $valor_dolares = $model->faltante;
    $valor_bs = $model->faltante * $tasa->valor;
}
?>

<div class="servicio-form" style="background-color: #f4f7f6; padding: 20px;">
    <div class="row">
        <!-- LADO IZQUIERDO: RECIBO E HISTORIAL -->
        <div class="col-md-5">
            <div style="background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 20px;">
                <!-- Color de barra dinámico según estatus -->
                <div style="height: 8px; background: <?= $esta_solvente ? '#00a65a' : ($es_nuevo ? '#f39c12' : '#3c8dbc') ?>;"></div>
                
                <div style="padding: 25px;">
                    <div class="text-center" style="margin-bottom: 20px;">
                        <h4 style="margin: 0; font-weight: 800; color: #333; letter-spacing: 1px;">RESUMEN DE CUENTA</h4>
                        <small style="color: #999;">Servicio #<?= $model->id_servicio ?></small>
                        <div style="margin-top: 10px;">
                            <span class="label" style="background-color: <?= $esta_solvente ? '#00a65a' : ($es_nuevo ? '#f39c12' : '#3c8dbc') ?>; padding: 5px 12px; border-radius: 4px;">
                                <?= $es_nuevo ? 'SIN ABONOS' : ($esta_solvente ? 'SOLVENTE' : 'CON SALDO PENDIENTE') ?>
                            </span>
                        </div>
                    </div>

                    <div style="border-top: 2px dashed #eee; border-bottom: 2px dashed #eee; padding: 15px 0; margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #777;">Vehículo:</span>
                            <span style="font-weight: bold;">
                                <?php $tipo_v = BaseTipoVehiculo::findOne($model->id_tipo_vehiculo); echo $tipo_v ? strtoupper($tipo_v->nombre_tipo_vehiculo) : 'N/A'; ?>
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #777;">Tasa aplicada:</span>
                            <span style="color: #00a65a; font-weight: bold;"><?= number_format($tasa->valor, 2, ',', '.') ?> Bs.</span>
                        </div>
                    </div>

                    <div style="background: #f9f9f9; border-radius: 8px; padding: 15px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span style="color: #555;">Monto Total:</span>
                            <span style="font-weight: bold;">$ <?= number_format($model->monto, 2, ',', '.') ?></span>
                        </div>
                        
                        <?php if (!$es_nuevo && $model->faltante < $model->monto): ?>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px; color: #3c8dbc;">
                                <span>Total Abonado:</span>
                                <span>- $ <?= number_format($model->monto - ($esta_solvente ? 0 : $model->faltante), 2, ',', '.') ?></span>
                            </div>
                        <?php endif; ?>

                        <div style="border-top: 1px solid #ddd; margin-top: 10px; padding-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: bold; color: #333;">PENDIENTE:</span>
                            <div class="text-right">
                                <?php if ($esta_solvente): ?>
                                    <div style="font-weight: 900; font-size: 1.5em; color: #00a65a; line-height: 1;">0,00 <small style="font-size: 0.6em;">Bs.</small></div>
                                    <div style="color: #00a65a; font-weight: bold; font-size: 12px;">PAGADO TOTAL</div>
                                <?php else: ?>
                                    <div style="font-weight: 900; font-size: 1.5em; color: #e74c3c; line-height: 1;">
                                        <?= number_format($valor_bs, 2, ',', '.') ?> <small style="font-size: 0.6em;">Bs.</small>
                                    </div>
                                    <div style="color: #7f8c8d; font-weight: bold;">$ <?= number_format($valor_dolares, 2, ',', '.') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN: HISTORIAL DE PAGOS -->
            <div class="box box-solid" style="border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                <div class="box-header with-border">
                    <h4 class="box-title" style="font-weight: bold; color: #444;"><i class="fa fa-history"></i> Historial de Pagos</h4>
                </div>
                <div class="box-body" style="padding: 0;">
                    <?php if (!empty($pagos)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover" style="margin-bottom: 0; font-size: 0.9em;">
                                <tbody>
                                    <?php foreach ($pagos as $pago): ?>
                                        <tr>
                                            <td style="padding-left: 20px;">
                                                <div style="font-weight: bold; color: #333;"><?= date('d/m/Y', strtotime($pago->fecha_pago)) ?></div>
                                                <small class="text-muted">Ref: <?= $pago->referencia ?: 'S/R' ?></small>
                                            </td>
                                            <td>
                                                <span class="label label-default" style="background: #eee; color: #666; border-radius: 4px;">
                                                    <?= $pago->tipo_pago ?>
                                                </span>
                                            </td>
                                            <td class="text-right" style="padding-right: 20px;">
                                                <div style="font-weight: bold; color: #00a65a;">
                                                    <?= number_format($pago->monto, 2, ',', '.') ?> 
                                                    <small><?= $pago->id_tipo_moneda ?></small>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div style="padding: 30px; text-align: center; color: #bbb;">
                            <i class="fa fa-info-circle fa-2x" style="display: block; margin-bottom: 10px;"></i>
                            No se han registrado abonos aún.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- LADO DERECHO: FORMULARIO -->
        <div class="col-md-7">
            <?php if (!$esta_solvente): ?>
                <div class="box box-primary" style="border-radius: 12px; border-top: 3px solid #00a65a;">
                    <div class="box-header with-border" style="padding: 15px 20px;">
                        <h3 class="box-title" style="font-weight: bold; color: #00a65a;"><i class="fa fa-plus-circle"></i> Registrar Nuevo Pago</h3>
                    </div>
                    <div class="box-body" style="padding: 25px;">
                        <?php $form = ActiveForm::begin([
                            'id' => 'pago-form',
                            'enableClientValidation' => false,
                            'options' => ['autocomplete' => 'off'],
                        ]); ?>

                        <?= $form->field($model3, 'monto_pagar')->hiddenInput(['value' => round($valor_bs, 2)])->label(false); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model3, 'tipo_pago')->widget(Select2::classname(), [
                                    'data' => [
                                        'Pago móvil' => 'Pago móvil', 'Transferencia' => 'Transferencia',
                                        'Efectivo (Bs)' => 'Efectivo (Bs)', 'Efectivo (Divisas)' => 'Efectivo (Divisas)', 'Zelle' => 'Zelle',
                                    ],
                                    'options' => ['placeholder' => 'Seleccione...'],
                                ])->label('TIPO DE PAGO', ['style'=>'font-weight:700; color:#555; font-size:11px;']); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model3, 'id_tipo_moneda')->widget(Select2::classname(), [
                                    'data' => ['Bs' => 'Bolívares (Bs)', '$' => 'Dólares ($)'],
                                ])->label('TIPO DE MONEDA', ['style'=>'font-weight:700; color:#555; font-size:11px;']); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label style="font-weight:700; color:#555; font-size:11px;">MONTO DEL PAGO</label>
                                <?= $form->field($model3, 'monto', ['template' => "{input}\n{error}"])->widget(MaskedInput::classname(), [
                                    'clientOptions' => [
                                        'alias' => 'decimal', 'groupSeparator' => '.', 'radixPoint' => ',', 
                                        'autoGroup' => true, 'digits' => 2, 'removeMaskOnSubmit' => true,
                                    ],
                                    'options' => [
                                        'class' => 'form-control text-right',
                                        'style' => 'border-radius: 10px; font-weight: bold; font-size: 1.4em; color: #00a65a; background: #f0fff4; height:48px;',
                                    ]
                                ]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model3, 'fecha_pago')->widget(DatePicker::className(), [
                                    'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd', 'todayHighlight' => true],
                                    'options' => ['style' => 'border-radius: 10px; height:48px;']
                                ])->label('FECHA DEL PAGO', ['style'=>'font-weight:700; color:#555; font-size:11px;']); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model3, 'referencia')->textInput([
                                    'placeholder' => 'Nro. de Operación',
                                    'style' => 'border-radius: 8px; height:40px;'
                                ])->label('REFERENCIA', ['style'=>'font-weight:700; color:#555; font-size:11px;']); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model3, 'id_metodo')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(BaseMetodosPago::find()->all(), 'id_metodo', 'nombre_metodo'),
                                    'options' => ['placeholder' => 'Seleccione...'],
                                ])->label('DESTINO DE FONDOS', ['style'=>'font-weight:700; color:#555; font-size:11px;']); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model3, 'observacion_pago')->textarea([
                                    'rows' => 2, 
                                    'placeholder' => '¿Algún detalle importante?',
                                    'style' => 'border-radius: 8px; resize: none; width: 100%; padding: 10px;'
                                ])->label('OBSERVACIÓN DEL PAGO', ['style'=>'font-weight:700; color:#555; font-size:11px;']); ?>
                            </div>
                        </div>

                        <div class="form-group text-right" style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
                            <?= Html::a('CANCELAR', ['index'], ['class' => 'btn btn-default', 'style' => 'border-radius: 10px; padding: 10px 25px;']) ?>
                            <?= Html::submitButton('<i class="fa fa-check-circle"></i> CONFIRMAR PAGO', [
                                'class' => 'btn btn-success', 
                                'style' => 'border-radius: 10px; padding: 10px 30px; font-weight: bold; background-color: #00a65a; border:none;'
                            ]) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            <?php else: ?>
                <!-- BLOQUE DE SOLVENCIA -->
                <div class="text-center" style="padding: 60px 20px; background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
                    <i class="fa fa-check-circle fa-5x" style="color: #00a65a; margin-bottom: 20px;"></i>
                    <h2 style="font-weight: 800; color: #333;">SERVICIO SOLVENTE</h2>
                    <p class="text-muted" style="font-size: 1.1em;">Este servicio ya ha sido pagado en su totalidad y no registra deudas pendientes.</p>
                    <div style="margin-top: 30px;">
                        <?= Html::a('<i class="fa fa-arrow-left"></i> VOLVER AL LISTADO', ['index'], [
                            'class' => 'btn btn-primary', 
                            'style' => 'border-radius: 20px; padding: 10px 35px; font-weight: bold;'
                        ]) ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>