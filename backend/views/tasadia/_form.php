<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\Tasadia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasadia-form">

    <?php $form = ActiveForm::begin(); 
    ?>

<div class="panel panel-primary">
        <div class="panel-heading"> <i class="glyphicon glyphicon-bell"></i>  Actualizar Tasa </div> 
        <!--CONTENT-->
      <div class="panel-body">
         <div class="row">
            <div class="col-md-6">
            <?php 
                 /*<?=$form->field($model, 'valor')->textInput()->widget(MaskMoney::classname(), [
                        'pluginOptions' => [
//                            'prefix' => 'Bs ',
                              'suffix' => ' Bs',
                            'thousands' => '.',
                            'decimal' => ',',
                            'precision' => '0',
                            'allowNegative' => true]]);?> 
                            <?=$model['valor'];?>*/
                            ?>

<?= $form->field($model, 'valor')->textInput(['maxlength' => true]) ?>
            </div>
            
        </div>
    </div>
</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Regresar', ['index'], ['class' => 'btn btn-warning']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
