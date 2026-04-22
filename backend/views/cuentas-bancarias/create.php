<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CuentasBancarias */

$this->title = 'Create Cuentas Bancarias';
$this->params['breadcrumbs'][] = ['label' => 'Cuentas Bancarias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuentas-bancarias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
