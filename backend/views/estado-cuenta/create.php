<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\FinancieroEstadoCuenta $model */

$this->title = 'Create Financiero Estado Cuenta';
$this->params['breadcrumbs'][] = ['label' => 'Financiero Estado Cuentas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financiero-estado-cuenta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
