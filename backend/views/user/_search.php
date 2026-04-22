<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'auth_key') ?>

    <?= $form->field($model, 'password_hash') ?>

    <?= $form->field($model, 'password_reset_token') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'accessToken') ?>

    <?php // echo $form->field($model, 'activate') ?>

    <?php // echo $form->field($model, 'id_role') ?>

    <?php // echo $form->field($model, 'nombres') ?>

    <?php // echo $form->field($model, 'apellidos') ?>

    <?php // echo $form->field($model, 'nacionalidad') ?>

    <?php // echo $form->field($model, 'telefono_oficina') ?>

    <?php // echo $form->field($model, 'telefono_celular') ?>

    <?php // echo $form->field($model, 'cedula') ?>

    <?php // echo $form->field($model, 'id_conjunto') ?>

    <?php // echo $form->field($model, 'fecha_creacion') ?>

    <?php // echo $form->field($model, 'fecha_modifica') ?>

    <?php // echo $form->field($model, 'codigo_convenio') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
