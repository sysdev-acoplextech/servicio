<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use backend\models\CuentasBancarias;
use backend\models\CategoriaGastos;

/** @var yii\web\View $this */
/** @var backend\models\EstadoCuentaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Estado de Cuenta';

$this->params['breadcrumbs'][] = ['label' => 'Banco', 'url' => ['configuraciones']];


$this->registerCss("
    /* Contenedor Principal con Aire */
    .estado-cuenta-wrapper {
        padding: 30px;
        background-color: #F8FAFC;
        min-height: 100vh;
    }

    /* Modales: Regla de Borde Recto y Blanco */
    .modal-content {
        border-radius: 0px !important;
        border: 3px solid #FFFFFF !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    .modal-header {
        background-color: #1B242D;
        color: white;
        border-radius: 0px !important;
        border-bottom: none;
        padding: 20px;
    }
    .close { color: white !important; opacity: 1; text-shadow: none; }

    /* Inputs y Selects Rectos */
    .form-control, .select2-selection, .input-group-addon {
        border-radius: 0px !important;
        border: 1px solid #E2E8F0 !important;
        height: 40px !important;
    }

    /* Botones Redondeados */
    .btn-redondo {
        border-radius: 25px !important;
        font-weight: bold;
        padding: 10px 25px;
        transition: all 0.3s;
        border: none;
    }
    .btn-redondo:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* Card de Eliminación Estilo 'Alerta' */
    .card-carga {
        border: none;
        border-left: 6px solid #EF4444;
        background: #FFFFFF;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        margin-bottom: 30px;
        padding: 20px;
    }

    /* Estilo de Tabla Actualizado */
    .grid-view { padding-top: 20px; }
    .table {
        border-collapse: separate !important;
        border-spacing: 0 10px !important;
        background: transparent !important;
    }
    .table thead th {
        background: transparent !important;
        border: none !important;
        color: #64748B;
        text-transform: uppercase;
        font-size: 8.5pt;
        letter-spacing: 1px;
        padding: 15px !important;
    }
    .table tbody tr {
        background: #FFFFFF !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        transition: all 0.2s;
    }
    .table tbody tr:hover {
        transform: scale(1.005);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .table tbody td {
        border: none !important;
        padding: 18px 15px !important;
        vertical-align: middle !important;
    }
    .table tbody td:first-child { border-radius: 12px 0 0 12px; }
    .table tbody td:last-child { border-radius: 0 12px 12px 0; }

    /* Egresos vs Ingresos */
    .monto-egreso { color: #EF4444; }
    .monto-ingreso { color: #10B981; }
    
    /* Paginación */
    .pagination > li > a { border: none; margin: 0 2px; border-radius: 8px; color: #64748B; }
    .pagination > .active > a { background-color: #1B242D !important; border-radius: 8px; }
");

$this->registerJs("
    $(document).on('click', '.btn-categorizar', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var modal = $('#modal-flota'); 
        
        $('#modalHeaderTitle').html('<i class=\"fa fa-tag\"></i> Categorizar Movimiento');
        modal.find('#modalContent').html('<div class=\"text-center\" style=\"padding:40px;\"><i class=\"fa fa-spinner fa-spin fa-3x text-warning\"></i><br><br>Cargando información...</div>');

        modal.modal('show').find('#modalContent').load(url);
    });
");
?>

<div class="estado-cuenta-wrapper">

    <div class="row" style="margin-bottom: 30px; display: flex; align-items: center;">
        <div class="col-md-6">
            <p style="color: #94A3B8; margin-top: 5px;">Visualización y categorización de movimientos bancarios.</p>
        </div>
        <div class="col-md-6 text-right">
            <?= Html::a('<i class="fa fa-upload"></i> IMPORTAR TXT', ['subir-txt'], ['class' => 'btn btn-warning btn-redondo shadow-sm']) ?>
        </div>
    </div>

    <div class="card-carga">
        <h5 style="color: #1B242D; font-weight: bold; margin-bottom: 20px;">
            <i class="fa fa-refresh text-danger"></i> Re-preparar Carga de Datos
        </h5>
        <?= Html::beginForm(['eliminar-por-dia'], 'post') ?>
        <div class="row">
            <div class="col-md-4">
                <label class="small font-weight-bold" style="color: #64748B;">FECHA A LIMPIAR</label>
                <?= DatePicker::widget([
                    'name' => 'fecha_eliminar',
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]); ?>
            </div>
            <div class="col-md-4">
                <label class="small font-weight-bold" style="color: #64748B;">CUENTA ASOCIADA</label>
                <?= Select2::widget([
                    'name' => 'cuenta_eliminar',
                    'data' => ArrayHelper::map(CuentasBancarias::find()->all(), 'numero_cuenta', 'numero_cuenta'),
                    'options' => ['placeholder' => 'Seleccione cuenta...'],
                    'pluginOptions' => ['allowClear' => true],
                ]); ?>
            </div>
            <div class="col-md-4">
                <label>&nbsp;</label>
                <?= Html::submitButton('<i class="fa fa-trash"></i> EJECUTAR LIMPIEZA', [
                    'class' => 'btn btn-danger btn-block btn-redondo',
                    'style' => 'background-color: #EF4444;',
                    'data-confirm' => '¿Está totalmente seguro de eliminar estos registros para volver a cargar?',
                ]) ?>
            </div>
        </div>
        <?= Html::endForm() ?>
    </div>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'summary' => '<div style="color: #94A3B8; font-size: 9pt; margin-bottom: 10px;">Mostrando {begin} - {end} de {totalCount} movimientos</div>',
            'rowOptions' => function ($model) {
                if (!empty($model->id_categoria)) {
                    return ['style' => 'border-left: 6px solid #10B981;']; // Color éxito si ya está categorizado
                }
                return ($model->tipo_transaccion === '-') ? ["style" => "border-left: 6px solid #CBD5E1; opacity: 0.85;"] : ["style" => "border-left: 6px solid #1B242D;"];
            },
            'columns' => [
                [
                    'attribute' => 'fecha_transaccion',
                    'headerOptions' => ['style' => 'width: 120px;'],
                    'format' => ['date', 'php:d-m-Y'],
                ],
                [
                    'attribute' => 'referencia',
                    'value' => function($model) {
                        return strtoupper($model->referencia);
                    }
                ],
                [
                    'attribute' => 'monto',
                    'contentOptions' => ['style' => 'text-align: right; font-weight: bold; font-family: "Averta", monospace; font-size: 11pt;'],
                    'value' => function ($model) {
                        return number_format($model->monto, 2, ',', '.');
                    },
                    'contentOptions' => function ($model) {
                        return [
                            'class' => ($model->monto < 0) ? 'monto-egreso text-right' : 'monto-ingreso text-right',
                            'style' => 'font-weight: bold; font-family: monospace;'
                        ];
                    },
                ],
                [
                    'attribute' => 'id_categoria',
                    'label' => 'Categoría',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if ($model->categoriaGasto) {
                            return '<span class="badge" style="background: #F1F5F9; color: #1B242D; padding: 6px 12px; border-radius: 6px;">' . 
                                   $model->categoriaGasto->nombre_categoria . '</span>';
                        }
                        return '<span style="color: #CBD5E1; font-style: italic;">Pendiente</span>';
                    },
                    'filter' => ArrayHelper::map(CategoriaGastos::find()->all(), 'id_categoria_gasto', 'nombre_categoria'),
                ],
                [
                    'class' => ActionColumn::className(),
                    'header' => 'Acciones',
                    'headerOptions' => ['style' => 'text-align: center; color: #64748B;'],
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'template' => '{view} {categorizar}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<i class="fa fa-eye"></i>', $url, [
                                'class' => 'btn btn-default btn-sm',
                                'style' => 'border-radius: 10px; border: 1px solid #E2E8F0; color: #64748B;',
                                'title' => 'Ver Detalle'
                            ]);
                        },
                        'categorizar' => function ($url, $model) {
                            $noConciliado = ($model->conciliado == 0 || $model->conciliado === null);
                            if ($noConciliado) {
                                return Html::a('<i class="fa fa-tag"></i>', ['categorizar', 'id' => $model->idestado_cuenta], [
                                    'class' => 'btn btn-warning btn-sm btn-categorizar',
                                    'style' => 'border-radius: 10px; margin-left: 5px; color: #1B242D;',
                                    'title' => 'Asignar Categoría'
                                ]);
                            }
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>