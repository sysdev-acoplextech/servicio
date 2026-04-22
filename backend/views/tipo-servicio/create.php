<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TipoServicio */

$this->title = 'Registrar Tipo de servicio';
$this->params['breadcrumbs'][] = ['label' => 'Tipo de servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-servicio-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
