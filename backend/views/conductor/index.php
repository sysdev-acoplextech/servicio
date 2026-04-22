<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->registerJs("
    $(function(){
        $('.showModalButton').click(function(){
            $('#modal-misacdi').find('#modalContent').load($(this).attr('value'));
            $('#modal-misacdi').modal('show');
        });
    });
");
?>

<style>
    /* Efecto de elevación suave al pasar el mouse */
    .ficha-flotante {
        transition: transform 0.3s ease, box-shadow 0.3s ease !important;
        border-radius: 20px !important; /* Más redondeado */
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important; /* Sombra de profundidad */
    }
    .ficha-flotante:hover {
        transform: translateY(-5px); /* Se eleva */
        box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
    }
    /* Estilo para los inputs del filtro */
    .table-body input {
        border-radius: 10px !important;
        border: 1px solid #f0f0f0;
    }
</style>

<div class="conductor-index" style="padding: 25px; background-color: #F8FAFC; min-height: 100vh;">

    <div class="row" style="margin-bottom: 25px; display: flex; align-items: center;">
        <div class="col-md-6">
            <h1 class="titulo-principal" style="color: #1B242D; font-weight: bold;"><?= Html::encode($this->title) ?></h1>
            <p class="info-value" style="color: #64748B; font-size: 12pt;">Gestión operativa de conductores y flota.</p>
        </div>
        
        <div class="col-md-6 text-right">
            <?= Html::a('<i class="fa fa-refresh"></i>', ['index'], ['class' => 'btn btn-default', 'style' => 'border-radius:15px; padding:12px 18px; margin-right:5px; border:none; background:#FFF; shadow: 0 4px 6px rgba(0,0,0,0.05)']) ?>
            <?= Html::button('<i class="fa fa-plus-circle"></i> NUEVO REGISTRO', [
                'value' => Url::to(['create']),
                'class' => 'btn btn-orange-misacdi sombra-misacdi showModalButton',
                'style' => 'padding: 15px 30px; font-weight: bold; border: none; border-radius: 15px; width: 100%; max-width: 250px; background-color: #EA4C2D; color: white;'
            ]) ?>
           <?= Html::a('<i class="fa fa-file-pdf-o"></i> GENERAR REPORTE', ['reporte'], [
                'class' => 'btn',
                'target' => '_blank', // Abre en pestaña nueva
                'style' => 'background-color: #1B242D; color: white; padding: 15px 25px; border-radius: 18px; font-weight: bold; margin-right: 10px; box-shadow: 0 6px 15px rgba(27, 36, 45, 0.2);'
            ]) ?>
        </div>




    </div>

    <div class="row" style="margin-bottom: 40px;">
        
        <div class="col-md-3">
            <div class="ficha-grande ficha-flotante" style="background-color: #1B242D; padding: 25px; border: none; color: white;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span class="menu-texto" style="color: #98C1D9; letter-spacing: 1px;">TOTAL</span>
                    <i class="fa fa-users" style="color: #98C1D9; font-size: 24px;"></i>
                </div>
                <div class="valor-grande" style="font-size: 28pt; margin-top: 10px;"><?= $dataProvider->getTotalCount() ?></div>
                <p style="font-size: 9pt; color: #98C1D9; margin: 0;">Conductores en base</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ficha-grande ficha-flotante" style="background-color: #10B981; padding: 25px; border: none; color: white;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span class="menu-texto" style="color: #ECFDF5;">ACTIVOS</span>
                    <i class="fa fa-check-circle" style="color: #ECFDF5; font-size: 24px;"></i>
                </div>
                <div class="valor-grande" style="font-size: 28pt; margin-top: 10px;">
                    <?= \backend\models\Conductor::find()->where(['estatus' => 1])->count() ?>
                </div>
                <p style="font-size: 9pt; color: #ECFDF5; margin: 0;">Disponibles ahora</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ficha-grande ficha-flotante" style="background-color: #98C1D9; padding: 25px; border: none; color: #1B242D;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span class="menu-texto" style="font-weight: bold;">ALIADOS</span>
                    <i class="fa fa-handshake-o" style="font-size: 24px;"></i>
                </div>
                <div class="valor-grande" style="font-size: 28pt; margin-top: 10px;">
                    <?= \backend\models\Conductor::find()->where(['tercerizado' => 1])->count() ?>
                </div>
                <p style="font-size: 9pt; opacity: 0.7; margin: 0;">Flota tercerizada</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ficha-grande ficha-flotante" style="background-color: #EA4C2D; padding: 25px; border: none; color: white;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span class="menu-texto">INACTIVOS</span>
                    <i class="fa fa-ban" style="font-size: 24px;"></i>
                </div>
                <div class="valor-grande" style="font-size: 28pt; margin-top: 10px;">
                    <?= \backend\models\Conductor::find()->where(['estatus' => 0])->count() ?>
                </div>
                <p style="font-size: 9pt; opacity: 0.8; margin: 0;">Fuera de servicio</p>
            </div>
        </div>
    </div>

    <div class="ficha-grande sombra-misacdi" style="border: none; overflow: hidden; background: #FFFFFF; border-radius: 25px !important; box-shadow: 0 15px 40px rgba(0,0,0,0.05) !important;">
        <div style="padding: 25px 30px; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; background: #FFF;">
            <h2 class="titulo-seccion" style="margin:0; font-weight: bold; color: #1B242D;">
                <i class="fa fa-list-alt" style="color: #EA4C2D; margin-right: 10px;"></i> Conductores
            </h2>
            <div class="badge" style="background: #F1F5F9; color: #64748B; padding: 10px 20px; border-radius: 12px; font-size: 10pt;">
                Total Registros: <?= $dataProvider->count ?>
            </div>
        </div>

        <div style="padding: 20px;">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-hover table-body', 'style' => 'border-collapse: separate; border-spacing: 0 10px;'],
                'layout' => "{items}\n<div class='text-center'>{pager}</div>",
                'columns' => [
                    [
                        'attribute' => 'foto',
                        'label' => '',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width: 80px; border:none;'],
                        'contentOptions' => ['style' => 'border:none; vertical-align: middle;'],
                        'value' => function ($model) {
                            $img = $model->foto ? $model->foto : 'img/imagen_vacio.png';
                            return Html::img('@web/'.$img, [
                                'style' => 'width: 50px; height: 50px; border-radius: 15px; object-fit: cover; box-shadow: 0 4px 8px rgba(0,0,0,0.1);',
                            ]);
                        },
                    ],
                    [
                        'attribute' => 'cedula',
                        'label' => 'CÉDULA',
                        'headerOptions' => ['style' => 'border:none; color: #64748B; font-size: 9pt;'],
                        'contentOptions' => ['class' => 'importe', 'style' => 'vertical-align: middle; border:none; font-size: 12pt;'],
                    ],
                    [
                        'attribute' => 'nombres',
                        'label' => 'NOMBRE COMPLETO',
                        'headerOptions' => ['style' => 'border:none; color: #64748B; font-size: 9pt;'],
                        'contentOptions' => ['style' => 'vertical-align: middle; font-weight: 600; color: #1E293B; border:none;'],
                        'value' => function($model) { return strtoupper($model->nombres . ' ' . $model->apellidos); }
                    ],
                    [
                        'attribute' => 'tercerizado',
                        'label' => 'MODALIDAD',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'border:none; text-align:center; color: #64748B; font-size: 9pt;'],
                        'contentOptions' => ['style' => 'vertical-align: middle; text-align:center; border:none;'],
                        'value' => function ($model) {
                            $color = $model->tercerizado ? '#98C1D9' : '#1B242D';
                            $textColor = $model->tercerizado ? '#1B242D' : '#FFFFFF';
                            return "<span class='label' style='background-color: $color; color: $textColor; border-radius: 8px; padding: 6px 12px; font-size: 8pt;'>".($model->tercerizado ? 'TERCERIZADO' : 'PROPIO')."</span>";
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'ACCIONES',
                        'headerOptions' => ['style' => 'border:none; text-align: center; color: #64748B; font-size: 9pt;'],
                        'template' => '{view} {update}',
                        'contentOptions' => ['style' => 'text-align: center; vertical-align: middle; border:none;'],
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::button('<i class="fa fa-eye"></i>', [
                                    'value' => Url::to(['view', 'id' => $model->id]),
                                    'class' => 'btn btn-default showModalButton',
                                    'style' => 'border-radius: 12px; border: none; background: #F1F5F9; color: #1B242D; margin-right: 5px; padding: 8px 12px;'
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::button('<i class="fa fa-pencil"></i>', [
                                    'value' => Url::to(['update', 'id' => $model->id]),
                                    'class' => 'btn btn-default showModalButton',
                                    'style' => 'border-radius: 12px; border: none; background: #F1F5F9; color: #EA4C2D; padding: 8px 12px;'
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

<?php
Modal::begin([
    'id' => 'modal-misacdi',
    'size' => 'modal-lg',
    'header' => '<h3 class="titulo-tarjeta" style="color: #FFF; margin:0; font-family: Averta Semibold;">DETALLE OPERATIVO</h3>',
    'headerOptions' => ['style' => 'background-color: #1B242D; border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom: none; padding: 20px;'],
    'options' => ['style' => 'border-radius: 20px;'],
]);
echo "<div id='modalContent' style='padding: 0;'></div>";
Modal::end();
?>