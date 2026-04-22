<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Conductor */

$this->title = 'Registrar Conductor';
$this->params['breadcrumbs'][] = ['label' => 'Conductor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conductor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
