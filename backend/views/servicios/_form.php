<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->registerCss("
    .service-container { display: flex; gap: 20px; padding: 20px; background: #F8FAFC; }
    .steps-section { flex: 3; background: white; border-radius: 20px; padding: 25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    .summary-section { flex: 1; }
    .summary-card { position: sticky; top: 20px; background: #1E293B; color: white; border-radius: 20px; padding: 20px; }
    .total-amount { font-size: 24pt; font-weight: bold; color: #10B981; }
    .line-item { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 9pt; border-bottom: 1px solid #334155; padding-bottom: 5px; }
");
?>

<div class="service-container">
    <div class="steps-section">
        <?php $form = ActiveForm::begin(['id' => 'form-servicio-moderno']); ?>

        <?php
        $items = [
            [
                'label' => '<i class="fa fa-info-circle"></i> Datos Básicos',
                'content' => $this->render('_tab_basicos', ['form' => $form, 'model' => $model]),
                'active' => true
            ],
            [
                'label' => '<i class="fa fa-users"></i> Pasajeros',
                'content' => $this->render('_tab_pasajeros', ['form' => $form, 'model' => $model]),
            ],
            [
                'label' => '<i class="fa fa-money"></i> Tarifas y Variables',
                'content' => $this->render('_tab_tarifas', ['form' => $form, 'model' => $model]),
            ],
        ];

        echo TabsX::widget([
            'items' => $items,
            'position' => TabsX::POS_ABOVE,
            'encodeLabels' => false,
            'pluginOptions' => ['enableCache' => false],
        ]);
        ?>

        <div class="form-group mt-4">
            <?= Html::submitButton('CONFIRMAR Y AGENDAR SERVICIO', ['class' => 'btn btn-success btn-block', 'style' => 'border-radius: 15px; padding: 15px; font-weight: bold;']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="summary-section">
        <div class="summary-card">
            <h4 style="color: #94A3B8; font-size: 10pt; text-transform: uppercase;">Resumen del Servicio</h4>
            <hr style="border-color: #334155;">
            
            <div id="resumen-calculo">
                <div class="line-item"><span>Costo Base:</span> <span id="base-val">0,00</span></div>
                <div class="line-item"><span>Recargo Horario:</span> <span id="recargo-val">0,00</span></div>
                <div class="line-item"><span>Variables Extras:</span> <span id="extras-val">0,00</span></div>
                <div class="line-item"><span>Viáticos:</span> <span id="viatico-val">0,00</span></div>
                
                <div style="margin-top: 20px;">
                    <small style="color: #94A3B8;">TOTAL ESTIMADO</small>
                    <div class="total-amount">$ <span id="total-final">0,00</span></div>
                </div>
            </div>
        </div>
    </div>
</div>