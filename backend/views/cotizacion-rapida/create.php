<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CotizacionRapida */

$this->title = 'Create Cotizacion Rapida';
$this->params['breadcrumbs'][] = ['label' => 'Cotizacion Rapidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cotizacion-rapida-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
