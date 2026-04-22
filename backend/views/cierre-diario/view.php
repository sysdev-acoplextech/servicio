<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CierreDiario */

$this->title = $model->idcierre;
$this->params['breadcrumbs'][] = ['label' => 'Cierre Diarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cierre-diario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idcierre], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idcierre], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idcierre',
            'fecha_cierre',
            'numero_cuenta',
            'saldo_sistema',
            'saldo_bancario',
            'diferencia',
            'id_operador',
            'observaciones:ntext',
        ],
    ]) ?>

</div>
