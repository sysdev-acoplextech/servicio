<?php
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Flota */
/* @var $form yii\widgets\ActiveForm */

?>


<div class="flota-form">
    <div class="form-container">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'id' => 'dynamic-form'
        ]); ?>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'foto1')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'initialPreview' => $model->foto1 ? ['/servicio/backend/'.$model->foto1] : [],
                        'initialPreviewAsData' => true,
                        'overwriteInitial' => true,
                        'showUpload' => false,
                        'showRemove' => true,
                        'browseLabel' => 'Foto Frontal',
                        'browseIcon' => '<i class="fa fa-camera"></i> ',
                    ],
                ]); ?>
            </div>

            <div class="col-md-4">
                <?= $form->field($model, 'foto2')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'initialPreview' => $model->foto2 ? ['/servicio/backend/'.$model->foto2] : [],
                        'initialPreviewAsData' => true,
                        'overwriteInitial' => true,
                        'showUpload' => false,
                        'showRemove' => true,
                        'browseLabel' => 'Foto Lateral',
                        'browseIcon' => '<i class="fa fa-camera"></i> ',
                    ],
                ]); ?>
            </div>

            <div class="col-md-4">
                <?= $form->field($model, 'foto_rcv')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'initialPreview' => $model->foto_rcv ? ['/servicio/backend/'.$model->foto_rcv] : [],
                        'initialPreviewAsData' => true,
                        'overwriteInitial' => true,
                        'showUpload' => false,
                        'showRemove' => true,
                        'browseLabel' => 'Doc. RCV',
                        'browseIcon' => '<i class="fa fa-file-image-o"></i> ',
                    ],
                ]); ?>
            </div>
        </div>

        <hr style="border-top: 1px solid #F1F5F9; margin: 20px 0;">

        <div class="row">
            <div class="col-md-12 text-right">
                <div class="form-group">
                    
                    <?= Html::submitButton('<i class="fa fa-save"></i> Guardar Unidad', [
                        'class' => 'btn btn-primary',
                        'style' => 'padding: 12px 35px; font-weight: bold; background: #10B981; border: none; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);'
                    ]) ?>
                </div>
 
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>