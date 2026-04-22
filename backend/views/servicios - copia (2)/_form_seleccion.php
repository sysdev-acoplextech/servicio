<?php

use backend\models\Cliente;
use backend\models\ListaPrecio;
use backend\models\Pasajero;
use backend\models\Tarifario;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\touchspin\TouchSpin;
use yii\web\JsExpression;
use kartik\date\DatePicker;
use kartik\widgets\TimePicker;


?>


<div class="servicios-form">
    <div class="box box-widget widget-user-2">
        <div class="box box-primary">
            <div class="box-body">

            <div class="col-lg-6 col-xs-10">




            <div class="small-box bg-yellow">
              <!-- <div class="small-box bg-aqua"> -->
                <div class="inner">
                  <h4> 
                      <?= Html::a('Particular', ['create', 'model' => $model,
                        'model2' => $model2,
                        'model3' => $model3,
                        'model4' => $model4,
                        'model5' => $model5,
                        'model6' => $model6], ['class' => 'small-box bg-yellow']) 
                      ?>
                  </h4>
                  <h3>
                  <?= Html::a('Registrar', ['create', 'model' => $model,
                        'model2' => $model2,
                        'model3' => $model3,
                        'model4' => $model4,
                        'model5' => $model5,
                        'model6' => $model6], ['class' => 'small-box bg-yellow']) 
                      ?>  
                </h3>

              </div>
              <div class="icon">
                <i class="icofont-user"></i>
              </div>
            </div>


            

            </div>
          <div class="col-lg-6 col-xs-10">
              <div class="small-box bg-green">
              <!-- <div class="small-box bg-aqua"> -->
                <div class="inner">
                  <h4> 
                    <?= Html::a('Empresa', ['createproyecto', 'model' => $model,
                        'model2' => $model2,
                        'model3' => $model3,
                        'model4' => $model4,
                        'model5' => $model5,
                        'model6' => $model6,], ['class' => 'small-box bg-green']) ?>
                  </h4>
                  <h3>
                    
                   <?= Html::a('Registrar', ['createproyecto', 'model' => $model,
                        'model2' => $model2,
                        'model3' => $model3,
                        'model4' => $model4,
                        'model5' => $model5,
                        'model6' => $model6,], ['class' => 'small-box bg-green']) ?>

                </h3>

              </div>
              <div class="icon">
                <i class="icofont-businessman"></i>
              </div>
            </div>


          </div>
            </div>
        </div>
    </div>
</div>