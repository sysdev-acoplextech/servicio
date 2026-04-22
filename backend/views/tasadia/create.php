<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Tasadia */

$this->title = 'Create Tasadia';
$this->params['breadcrumbs'][] = ['label' => 'Tasadias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasadia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
