<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tarifario */

$this->title = 'Editar Tarifario: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Tarifarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_tarifario, 'url' => ['view', 'id' => $model->descripcion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tarifario-update">

<?php

echo $this->render('_form', [
    'model' => $model,
    'detalles' => $detalles, // <--- Verifica que se pase aquí también
]);
?>

</div>
