<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->title = 'Gestión Bancaria';
$this->params['breadcrumbs'][] = ['label' => 'Banco', 'url' => ['/estado-cuenta/configuraciones']];

$this->registerJs("
    $(function(){
        $('.showModalButton').click(function(){
            $('#modal-bancos').find('#modalContent').load($(this).attr('value'));
            $('#modal-bancos').modal('show');
        });
    });
");
?>

<style>
    /* Estilo de Fichas Modernas */
    .ficha-bancaria {
        transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
        border-radius: 25px !important;
        border: none !important;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
        overflow: hidden;
    }

    .ficha-bancaria:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12) !important;
    }

    /* Botones Estilo Misacdi */
    .btn-banco-modulo {
        border-radius: 18px !important;
        padding: 15px 25px;
        font-weight: bold;
        border: none;
        transition: 0.3s;
        letter-spacing: 0.5px;
    }

    .text-money {
        font-family: 'Averta', 'Monospace';
        font-weight: 700;
    }
</style>

<div class="gestion-bancaria-index" style="padding: 30px; background-color: #F8FAFC; min-height: 100vh;">

    <div class="row" style="margin-bottom: 30px; display: flex; align-items: center;">
        <div class="col-md-6">
            <p style="color: #64748B; font-size: 11pt; margin-top: 5px;">Control de flujos de efectivo y conciliaciones.</p>
        </div>
        <div class="col-md-6 text-right">
            <?= Html::button('<i class="fa fa-university"></i> NUEVA CUENTA', [
                'value' => Url::to(['cuentas-bancarias/create']),
                'class' => 'btn btn-banco-modulo showModalButton',
                'style' => 'background-color: #1B242D; color: white; box-shadow: 0 8px 15px rgba(27,36,45,0.2);'
            ]) ?>
            <?= Html::a('<i class="fa fa-lock"></i> CIERRE DIARIO', ['cierre-diario/create'], [
                'class' => 'btn btn-banco-modulo',
                'style' => 'background-color: #EA4C2D; color: white; margin-left: 10px; box-shadow: 0 8px 15px rgba(234,76,45,0.2);'
            ]) ?>
        </div>
    </div>

    <div class="row" style="margin-bottom: 30px;">
        <div class="col-md-4">
            <div class="ficha-bancaria" style="background: linear-gradient(135deg, #1B242D 0%, #334155 100%); padding: 30px; color: white;">
                <span style="opacity: 0.7; font-size: 9pt; letter-spacing: 1px;">TOTAL DISPONIBLE (VES)</span>

                <div class="text-money" style="font-size: 26pt; margin-top: 10px;">
                    <?= number_format($disponibleTotal, 2, ',', '.') ?>
                </div>

                <div style="margin-top: 15px; display: flex; align-items: center;">
                    <span class="label" style="background: rgba(16, 185, 129, 0.2); color: #10B981; border-radius: 8px;">
                        <i class="fa fa-level-up"></i> ACTUALIZADO
                    </span>
                    <span style="font-size: 8pt; margin-left: 10px; opacity: 0.6;">Saldos + Movimientos</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ficha-bancaria" style="background: #FFFFFF; padding: 30px; border-left: 6px solid #EA4C2D !important;">
                <span style="color: #64748B; font-size: 9pt; font-weight: bold; letter-spacing: 1px;">PENDIENTE POR CATEGORIZAR</span>

                <div class="text-money" style="font-size: 26pt; margin-top: 10px; color: #1B242D;">
                    <?= $pendientesCategorizar ?>
                </div>

                <div style="margin-top: 15px;">
                    <?= Html::a(
                        'CONCILIAR AHORA <i class="fa fa-arrow-right"></i>',
                        ['estado-cuenta/index', 'EstadoCuentaSearch[id_categoria]' => ''], // Filtro directo al index
                        ['style' => 'color: #EA4C2D; font-weight: bold; font-size: 9pt; text-decoration: none;']
                    ) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
    <div class="ficha-bancaria" style="background: #FFFFFF; padding: 30px; border-left: 6px solid #98C1D9 !important;">
        <span style="color: #64748B; font-size: 9pt; font-weight: bold; letter-spacing: 1px;">ÚLTIMO MOVIMIENTO</span>
        
        <?php if ($ultimoMovimiento): ?>
            <div style="font-size: 14pt; margin-top: 10px; font-weight: bold; color: #1B242D; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <?= Html::encode($ultimoMovimiento->referencia ?: 'Sin Referencia') ?>
            </div>
            <div style="margin-top: 5px; color: #64748B; font-size: 10pt;">
                <i class="fa fa-calendar-o"></i> <?= date("d-m-Y", strtotime($ultimoMovimiento->fecha_transaccion)) ?> 
                <i class="fa fa-clock-o" style="margin-left: 5px;"></i> <?= date("g:i A", strtotime($ultimoMovimiento->hora)) ?>
            </div>
        <?php else: ?>
            <div style="font-size: 14pt; margin-top: 10px; font-weight: bold; color: #94A3B8;">
                Sin movimientos
            </div>
            <div style="margin-top: 5px; color: #CBD5E1; font-size: 10pt;">
                No hay registros recientes
            </div>
        <?php endif; ?>
    </div>
</div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="ficha-bancaria" style="background: white; padding: 0;">
                <div style="padding: 25px; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between;">
                    <h3 style="margin: 0; font-weight: bold; color: #1B242D; font-size: 14pt;"><i class="fa fa-university text-info"></i> Cuentas Activas</h3>
                    <?= Html::a('Ver Todo', ['cuentas-bancarias/index'], ['class' => 'btn btn-xs', 'style' => 'background: #F1F5F9; border-radius: 10px; padding: 5px 15px;']) ?>
                </div>
                <div class="table-responsive" style="padding: 10px 25px 25px 25px;">
                    <table class="table table-hover" style="border-collapse: separate; border-spacing: 0 8px;">
                        <thead>
                            <tr style="color: #64748B; font-size: 9pt; border: none;">
                                <th style="border: none;">BANCO / CUENTA</th>
                                <th style="border: none; text-align: right;">SALDO DISPONIBLE</th>
                                <th style="border: none; text-align: center;">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cuentasActivas as $cuenta): ?>
                                <?php
                                // Calcular movimientos específicos de ESTA cuenta
                                $sumaMovimientos = (new \yii\db\Query())
                                    ->from('estado_cuenta')
                                    ->where(['numero_cuenta' => $cuenta->numero_cuenta, 'eliminado' => 0])
                                    ->sum('monto') ?: 0;

                                $saldoReal = $cuenta->saldo + $sumaMovimientos;
                                ?>
                                <tr style="background: #F8FAFC; margin-bottom: 10px;">
                                    <td style="border: none; border-radius: 15px 0 0 15px; vertical-align: middle; padding: 15px;">
                                        <div style="font-weight: bold; color: #1B242D; text-transform: uppercase;">
                                            <?= $cuenta->banco ? Html::encode($cuenta->banco->nom_corto) : 'BANCO' ?>
                                            <span style="font-weight: 400; color: #64748B;">- <?= Html::encode($cuenta->descripcion) ?></span>
                                        </div>
                                        <small style="color: #94A3B8; font-family: monospace;"><?= $cuenta->numero_cuenta ?></small>
                                    </td>

                                    <td style="border: none; vertical-align: middle; text-align: right; font-weight: bold; color: #1B242D;" class="text-money">
                                        <?= number_format($saldoReal, 2, ',', '.') ?>
                                        <small style="color: #64748B; font-size: 8pt;">
                                            <?= $cuenta->tipoMoneda ? $cuenta->tipoMoneda->cod_moneda : '' ?>
                                        </small>
                                    </td>

                                    <td style="border: none; border-radius: 0 15px 15px 0; vertical-align: middle; text-align: center;">
                                        <?= Html::a('<i class="fa fa-eye"></i>', ['cuentas-bancarias/view', 'id' => $cuenta->id_cuentas], [
                                            'class' => 'badge',
                                            'style' => 'background: #ECFDF5; color: #10B981; border-radius: 8px; padding: 8px 12px; border: none;'
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (empty($cuentasActivas)): ?>
                                <tr>
                                    <td colspan="3" class="text-center" style="padding: 20px; color: #94A3B8;">
                                        No hay cuentas bancarias activas registradas.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="ficha-bancaria" style="background: #FFF; padding: 25px; margin-bottom: 20px;">
                <h4 style="font-weight: bold; color: #1B242D; margin-bottom: 20px;">Relación de Movimientos</h4>
                <?= Html::a('<div style="display: flex; align-items: center; background: #F8FAFC; padding: 15px; border-radius: 18px;">
                    <div style="background: #1B242D; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <i class="fa fa-file-text-o" style="color: white;"></i>
                    </div>
                    <div>
                        <b style="color: #1B242D; display: block;">Estado de Cuenta</b>
                        <small style="color: #64748B;">Cargar y procesar archivos</small>
                    </div>
                </div>', ['estado-cuenta/index'], ['style' => 'text-decoration: none; display: block; margin-bottom: 15px;']) ?>

                <?= Html::a('<div style="display: flex; align-items: center; background: #F8FAFC; padding: 15px; border-radius: 18px;">
                    <div style="background: #98C1D9; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <i class="fa fa-list" style="color: #1B242D;"></i>
                    </div>
                    <div>
                        <b style="color: #1B242D; display: block;">Historial Completo</b>
                        <small style="color: #64748B;">Ver todos los movimientos</small>
                    </div>
                </div>', ['relacion-movimientos/index'], ['style' => 'text-decoration: none; display: block;']) ?>
            </div>
        </div>
    </div>
</div>

<?php
Modal::begin([
    'id' => 'modal-bancos',
    'size' => 'modal-lg',
    'header' => '<h3 style="color: #FFF; margin:0; font-weight: bold;">GESTIÓN BANCARIA</h3>',
    'headerOptions' => [
        'style' => 'background-color: #1B242D; border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom: none; padding: 25px;'
    ],
    'options' => ['style' => 'border-radius: 20px;'],
]);
echo "<div id='modalContent' style='padding: 20px;'></div>";
Modal::end();
?>