<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\DetalleFacturaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalle-factura-search">
  <div class="modal fade" id="modal-default2">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="fa fa-search-plus"></span>&nbsp; <b>Búsqueda Avanzada de Facturas del Cliente</b></h4>
        </div>
        <div class="modal-body">
          <?php $form = ActiveForm::begin([
            'action' => ['facturas', 'id_cliente' => $_GET['id_cliente']],
            'method' => 'get',
          ]); ?>

          <?php // echo $form->field($model, 'id_detallefactura') 
          ?>
          <div class="row">
            <div class="col-md-6">
              <?= $form->field($model, 'num_factura') ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'fecha_factura')->input('date', [
                'max' => date('Y-m-d'),
              ])->widget(DatePicker::className(), []) ?>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <?= $form->field($model, 'observacion') ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'monto_facturado') ?>
            </div>
          </div>

          <?php // echo $form->field($model, 'id_servicios') 
          ?>

          <?php // echo $form->field($model, 'subtotal') 
          ?>

          <?php // echo $form->field($model, 'iva') 
          ?>

          <?php // echo $form->field($model, 'tasa_dia') 
          ?>

          <?php // echo $form->field($model, 'fecha_emision') 
          ?>
          <div class="row">
            <div class="col-md-6">
              <?php echo $form->field($model, 'monto_bs') ?>
            </div>
            
            <div class="col-md-6">
            <?php  $form->field($model, 'id_cliente')->hiddenInput(['value' => $_GET['id_cliente']])->label(false); ?>
              <?php
                    echo $form->field($model, 'pagada')->widget(Select2::classname(), [
                        'data' => [0=>'NO',1=>'SI'],
                        'pluginLoading' => false,
                        'value'=> null,
                        'options' => ['placeholder' => 'Seleccione...'],
                        'pluginOptions' => [
                            'multiple' => false,
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
            </div>
          </div>
          <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<?php ActiveForm::end(); ?>

</div>