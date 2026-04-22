<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\ChangePassword */

$this->title = "Cambiar Contraseña ($modelUser->username)";
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?php //Html::encode($this->title) ?></h1>
	
	
	
	
	          <!-- Horizontal Form -->
          <div class="box box-info">
            
  <?php $form = ActiveForm::begin(['id' => 'form-change']); ?>
            <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group"> 

                  <div class="col-sm-10">
                     <?= $form->field($model, 'newPassword')->passwordInput()->label('Nueva Contraseña') ?>
                  </div>
                </div>
                <div class="form-group">
                   

                  <div class="col-sm-10">
                    <?= $form->field($model, 'retypePassword')->passwordInput()->label('Confirmar Nueva Contraseña') ?>
                  </div>
                </div> 
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
        <?= Html::a('Regresar', ['/user/index'], ['class' => 'btn btn-warning']) ?>
 <?= Html::submitButton('Cambiar', ['class' => 'btn btn-primary', 'name' => 'change-button']) ?>
              </div>
              <!-- /.box-footer -->
            </form>
			    <?php ActiveForm::end(); ?>
          </div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
   <!-- <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-change']); ?>
                <?php // = $form->field($model, 'oldPassword')->passwordInput()->label('Contraseña Actual') ?>
                <?= $form->field($model, 'newPassword')->passwordInput()->label('Nueva Contraseña') ?>
                <?= $form->field($model, 'retypePassword')->passwordInput()->label('Confirmar Nueva Contraseña') ?>
                <div class="form-group">
				 
                    <?= Html::submitButton('Cambiar', ['class' => 'btn btn-primary', 'name' => 'change-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>-->
</div>
