<?php 

use yii\helpers\Html; 
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\ServicioPago; 
use yii\helpers\Url;
use kartik\widgets\DatePicker;

$form = ActiveForm::begin(); ?>
<div class="modal modal-default fade" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Reporte de Pago de factura Nro.</h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-3">
                        <?= $form->field($model2, 'fecha_pago')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Fecha pago'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true
                            ]
                        ]); ?>
                        </div>
                        <div class="col-xs-3"> 
                            <?= $form->field($model2, 'monto')->textInput(['id' => 'monto']) ?>
                        </div>
                        <div class="col-sm-12 col-xs-12"> 
                           
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="box-tools pull-right"> 
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                                        Cancelar
                                    </button>
                                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-file-excel-o"></i> Descargar EXCEL'), ['class' => 'btn btn-success','name' => 'bt', 'value' => 0]) ?>
                                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-file-pdf-o"></i> Descargar Pdf'), ['class' => 'btn btn-danger','name' => 'bt', 'value' => 1]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>