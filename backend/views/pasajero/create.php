<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Pasajero */

$this->title = 'Create Pasajero';
$this->params['breadcrumbs'][] = ['label' => 'Pasajeros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pasajero-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
