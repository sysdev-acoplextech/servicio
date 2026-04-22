<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\FinancieroCategoriaGastos;

$this->title = 'Clasificar Egreso: ' . $model->referencia;
$this->params['breadcrumbs'][] = ['label' => 'Cuentas Bancarias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fa fa-tag"></i> Asignar Categoría de Gasto</h5>
            </div>
            <div class="card-body">
                <table class="table table-lg table-bordered mb-8">
                    <tr class="bg-light">
                        <th>Referencia:</th>
                        <td><?= Html::encode($model->referencia) ?></td>
                    </tr>
                    <tr>
                        <th>Monto:</th>
                        <td class="text-danger font-weight-bold"><?= number_format($model->monto, 2) ?></td>
                    </tr>
                    <tr>
                        <th>Cuenta:</th>
                        <td><?= Html::encode($model->numero_cuenta) ?></td>
                    </tr>
                </table>

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'id_categoria')->dropDownList(
                    ArrayHelper::map(
                        FinancieroCategoriaGastos::find()
                            ->where(['id_fondo' => $idFondo, 'estatus' => true])
                            ->all(), 
                        'id_categoria_gasto', 
                        'nombre_categoria'
                    ),
                    ['prompt' => 'Seleccione una categoría...', 'required' => true, 'class' => 'form-control form-control-lg']
                )->label('Categoría de Gasto') ?>

                <div class="form-group mt-4 d-flex justify-content-between">
                    <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
                    <?= Html::submitButton('Guardar Clasificación', ['class' => 'btn btn-success btn-lg']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>