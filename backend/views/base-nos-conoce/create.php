<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseNosConoce */

$this->title = '¿Cómo nos conoció?';
$this->params['breadcrumbs'][] = ['label' => '¿Cómo nos conoció?', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-nos-conoce-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
