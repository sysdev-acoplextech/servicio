<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Flota */

$this->title = 'Registrar Flota';
$this->params['breadcrumbs'][] = ['label' => 'Flotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flota-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
