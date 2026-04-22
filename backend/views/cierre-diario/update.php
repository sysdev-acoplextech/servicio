<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CierreDiario */

$this->title = 'Update Cierre Diario: ' . $model->idcierre;
$this->params['breadcrumbs'][] = ['label' => 'Cierre Diarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idcierre, 'url' => ['view', 'id' => $model->idcierre]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cierre-diario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
