<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->registerCss("
    .modal-cierre { border: 2px solid white; background: #fff; border-radius: 0px !important; }
    .form-control { border-radius: 0px !important; }
    .btn-cierre { border-radius: 25px !important; font-weight: bold; padding: 10px 30px; }
");
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="box box-danger" style="border-radius: 0px !important;">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-lock"></i> Procesar Cierre Diario</h3>
            </div>
            
            <?php $form = ActiveForm::begin(); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Fecha de Cierre</label>
                        <?= $form->field($model, 'fecha_cierre')->textInput(['readonly' => true])->label(false) ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label>Saldo en Sistema (VES)</label>
                        <?= $form->field($model, 'saldo_sistema')->textInput([
                            'readonly' => true, 
                            'style' => 'background:#f9f9f9; font-weight:bold; color: #3c8dbc'
                        ])->label(false) ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label>Saldo Real en Banco</label>
                        <?= $form->field($model, 'saldo_real')->textInput([
                            'placeholder' => '0,00',
                            'type' => 'number',
                            'step' => '0.01',
                            'required' => true
                        ])->label(false) ?>
                    </div>

                    <div class="col-md-12">
                        <label>Observaciones de Cierre</label>
                        <?= $form->field($model, 'observaciones')->textArea(['rows' => 3, 'placeholder' => 'Indique si hay descuadres...'])->label(false) ?>
                    </div>
                </div>
            </div>

            <div class="box-footer text-right">
                <?= Html::submitButton('<i class="fa fa-check"></i> Finalizar y Guardar Cierre', [
                    'class' => 'btn btn-danger btn-cierre'
                ]) ?>
            </div>
            <?php ActiveForm::end();