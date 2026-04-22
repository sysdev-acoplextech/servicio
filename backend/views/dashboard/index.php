<?php

use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Cliente;
use backend\models\Estatus;
use backend\models\BaseTipoVehiculo;
use backend\models\TipoTrasladoRuta;

/** @var yii\web\View $this */
/** @var backend\models\Servicios $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Panel de Gestión de Servicios';

// --- PROTECCIÓN DE VARIABLES ---
// Si el controlador no envía estas variables, les asignamos valores por defecto
$model = isset($model) ? $model : new \backend\models\Servicios(); // PROTECCIÓN LÍNEA 114
$totalOrders = isset($totalOrders) ? $totalOrders : 0;
$totalSales = isset($totalSales) ? $totalSales : 0;
$tipopago = isset($tipopago) ? $tipopago : [];
$tipovehiculo = isset($tipovehiculo) ? $tipovehiculo : [];
$salesData = isset($salesData) ? $salesData : [];

// --- PROCESAMIENTO DE DATOS PARA GRÁFICOS ---
$ar_pagos = '';
foreach ($tipopago as $key => $val) {
    $cant = isset($val->id_servicio) ? $val->id_servicio : 0;
    $name = isset($val->tipo_pago) ? $val->tipo_pago : 'N/A';
    $slice = ($key == 0) ? ',"sliced":true,"selected":true' : '';
    $ar_pagos .= '{"name":"' . $name . ' (' . $cant . ')","y":' . $cant . ' ' . $slice . '},';
}
$ar_pagos = rtrim($ar_pagos, ',');

// --- LÓGICA DE FORMULARIO ---
$dataClientes = ArrayHelper::map(Cliente::find()->all(), 'id_cliente', 'nombre_apellido');
$dataRutas = ArrayHelper::map(TipoTrasladoRuta::find()->where(['estatus' => 1])->all(), 'id', 'nombre_traslado_ruta');

$meses = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
    7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];
?>

<div class="row">
    <div class="col-md-12">
        <div class="box" style="border-radius: 0px; border-top: 3px solid #00a65a;">
            <div class="box-header with-border">
                <h3 class="box-title"><strong><i class="fa fa-dashboard"></i> Resumen del Mes: <?= $meses[date('n')] ?></strong></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="info-box" style="border-radius: 10px;">
                            <span class="info-box-icon bg-green"><i class="fa fa-shopping-cart"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Servicios Totales</span>
                                <span class="info-box-number"><?= number_format($totalOrders, 0, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box" style="border-radius: 10px; box-shadow: 2px 2px 5px rgba(0,0,0,0.1);">
                            <span class="info-box-icon bg-blue"><i class="fa fa-money"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Ventas Totales</span>
                                <span class="info-box-number">Bs. <?= number_format($totalSales, 2, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-info" style="border-radius: 10px; margin-bottom: 0px;">
                            <i class="fa fa-info-circle"></i> Datos actualizados al <?= date('d/m/Y H:i') ?>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary" style="border-radius: 0px;">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-plus-circle"></i> Registrar Nuevo Servicio</h3>
            </div>
            <div class="box-body">
                <?php $form = ActiveForm::begin(['id' => 'servicio-form']); ?>

                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($model, 'id_tipo_vehiculo')->dropDownList(
                            ArrayHelper::map(BaseTipoVehiculo::find()->all(), 'id', 'nombre_tipo_vehiculo'),
                            ['prompt' => 'Seleccione Vehículo...', 'style' => 'border-radius:8px;']
                        ) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'id_tipo_traslado_ruta')->dropDownList(
                            $dataRutas,
                            ['prompt' => 'Seleccione Ruta...', 'style' => 'border-radius:8px;']
                        ) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'fecha_servicio')->input('date', ['style' => 'border-radius:8px;']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'id_cliente')->widget(Select2::classname(), [
                            'data' => $dataClientes,
                            'options' => ['id' => 'select-cliente', 'placeholder' => 'Buscar cliente...'],
                            'pluginOptions' => ['allowClear' => true],
                        ]); ?>
                    </div>
                    <div class="col-md-3">
                        <label>Teléfono Principal</label>
                        <input type="text" id="info-telefono" class="form-control" readonly
                            style="border-radius:8px; background:#f4f4f4; font-weight:bold;">
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'id_estatus')->dropDownList(
                            ArrayHelper::map(Estatus::find()->all(), 'id', 'estatus'),
                            ['style' => 'border-radius:8px;']
                        ) ?>
                    </div>
                </div>

                <div id="alert-no-grato" class="alert alert-danger" style="display:none; border-radius:10px; font-weight:bold;">
                    <i class="fa fa-warning"></i> ATENCIÓN: El cliente seleccionado es NO GRATO.
                </div>

                <div class="form-group text-right">
                    <?= Html::submitButton('Guardar Servicio', ['class' => 'btn btn-success', 'style' => 'border-radius:20px; padding: 10px 30px;']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box box-default" style="border-radius: 0px;">
            <div class="box-header with-border">
                <h3 class="box-title">Distribución de Pagos</h3>
            </div>
            <div class="box-body">
                <?= Highcharts::widget([
                    'scripts' => ['highcharts-3d'],
                    'options' => [
                        'chart' => ['type' => 'pie', 'options3d' => ['enabled' => true, 'alpha' => 45]],
                        'title' => ['text' => ''],
                        'series' => [['name' => 'Cantidad', 'data' => json_decode('[' . $ar_pagos . ']', true)]]
                    ]
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-default" style="border-radius: 0px;">
            <div class="box-header with-border">
                <h3 class="box-title">Histórico de Ventas</h3>
            </div>
            <div class="box-body">
                <?php
                $months = []; $sales = [];
                foreach ($salesData as $data) {
                    $months[] = $data['month'];
                    $sales[] = (float)$data['total_sales'];
                }
                echo Highcharts::widget([
                    'options' => [
                        'title' => ['text' => ''],
                        'xAxis' => ['categories' => $months],
                        'series' => [['name' => 'Ventas', 'data' => $sales, 'color' => '#00a65a']]
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

<?php
$urlInfo = Url::to(['servicios/info-cliente']);
$this->registerJs("
$('#select-cliente').on('change', function() {
    var id = $(this).val();
    if (id) {
        $.ajax({
            url: '{$urlInfo}',
            type: 'GET',
            data: {id: id},
            success: function(data) {
                if (data.success) {
                    $('#info-telefono').val(data.telefono);
                    if (data.grato == 0) { $('#alert-no-grato').slideDown(); } 
                    else { $('#alert-no-grato').slideUp(); }
                }
            }
        });
    } else {
        $('#info-telefono').val('');
        $('#alert-no-grato').slideUp();
    }
});
");
?>