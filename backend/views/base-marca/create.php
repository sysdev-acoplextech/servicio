<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseMarca */

$this->title = 'Create Base Marca';
$this->params['breadcrumbs'][] = ['label' => 'Base Marcas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-marca-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
