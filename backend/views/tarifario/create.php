<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tarifario */

$this->title = 'Registro de Tarifario';
$this->params['breadcrumbs'][] = ['label' => 'Tarifarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarifario-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
