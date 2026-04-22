<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tasadia */

$this->title = 'Actualizar Tasa de Cambio: ' ;
$this->params['breadcrumbs'][] = ['label' => 'Tasadias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tasadia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
