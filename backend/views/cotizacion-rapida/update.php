<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CotizacionRapida */

$this->title = 'Update Cotizacion Rapida: ' . $model->id_cotizacion;
$this->params['breadcrumbs'][] = ['label' => 'Cotizacion Rapidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_cotizacion, 'url' => ['view', 'id' => $model->id_cotizacion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cotizacion-rapida-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
