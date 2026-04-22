<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

$form = ActiveForm::begin([
    'action' => ['resumen-servicios'],
    'method' => 'post',
]); ?>
<div class="modal modal-default fade" id="modal-pagotec">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Servicios Concluidos a la fecha</b></h4>
              </div>
        <div class="modal-body">
	        <!-- <div class="col-sm-6  col-xs-12">
            <?php
                /*echo $form->field($model, 'fecha_registro_desde')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Seleccione'],
                    'pluginOptions' => [
                        'orientation' => 'bottom',
                        'format' => 'dd-mm-yyyy',
                        'autoclose'=>true
                    ]
                ])->label('Fecha de registro desde');*/
                ?>
	        </div>-->
	        <!--<div class="col-sm-6  col-xs-12">
            <?php
              /*  echo $form->field($model, 'fecha_registro_hasta')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Seleccione'],
                    'pluginOptions' => [
                        'orientation' => 'bottom',
                        'format' => 'dd-mm-yyyy',
                        'autoclose'=>true
                    ]
                ])->label('Fecha de registro hasta');*/
                ?>
	        </div>-->
          
      </div>
        <div class="modal-body">
	        <div class="col-sm-6  col-xs-12">
            <?php
                echo $form->field($model, 'fecha_servicio_desde')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Seleccione'],
                    'pluginOptions' => [
                        'orientation' => 'bottom',
                        'format' => 'dd-mm-yyyy',
                        'autoclose'=>true
                    ]
                ])->label('Fecha de servicio desde');
                ?>
	        </div>
	        <div class="col-sm-6  col-xs-12">
            <?php
                echo $form->field($model, 'fecha_servicio_hasta')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Seleccione'],
                    'pluginOptions' => [
                        'orientation' => 'bottom',
                        'format' => 'dd-mm-yyyy',
                        'autoclose'=>true
                    ]
                ])->label('Fecha de servicio hasta');
                ?>
	        </div>
          
      </div>
     <br><br><br>
	      <div class="modal-footer">
          <div class="row">
            <div class="col-sm-12 col-xs-12">
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-ban"></i><b> Cancelar</b></button>
                  <?= Html::submitButton(Yii::t('app', '<i class="fa fa-file-excel-o"></i> <b>Descargar EXCEL</b>'), ['class' => 'btn btn-success','name' => 'bt', 'value' => 0]) ?>
                    <?php // Html::submitButton(Yii::t('app', '<i class="fa fa-file-pdf-o"></i> <b>Descargar PDF</b>'), ['class' => 'btn btn-danger','name' => 'bt', 'value' => 1]) ?>
                </div>
            </div>
        </div>
      </div>
	  </div>
  </div>
</div>
        <?php ActiveForm::end(); ?>
