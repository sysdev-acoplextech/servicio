<?php

use backend\models\BaseMetodosPago;
use backend\models\Moneda;
use backend\models\OperadorFinanciero;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\ServicioPago */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="servicio-pago-form">
    <div class="box box-widget widget-user-2">
        <div class="box box-primary">
            <div class="box-body">

                <?php $form = ActiveForm::begin(); ?>
                <div class="row">

                    <div class="col-sm-12">
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Factura N° <?= $model2->num_factura ?></h4>
                            <p>Fecha Factura: <?= Yii::$app->formatter->asDate($model2->fecha_factura, 'php:d-m-Y') ?></p>
                            <p>Monto: <b>Bs. </b><?= Yii::$app->formatter->asDecimal($model2->monto_bs, 2);   ?><b> / $ </b> <?= Yii::$app->formatter->asDecimal($model2->monto_facturado, 2);   ?><b> / Tasa: <?= Yii::$app->formatter->asDecimal($model2->tasa_dia, 2);   ?> </b></p>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-sm-12">
                        <?= $form->field($model, 'id_factura')->hiddenInput(['value' => $model2->id_detallefactura])->label(false); ?>
                        <?= $form->field($model, 'id_cliente')->hiddenInput(['value' => $id_cliente])->label(false); ?>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'fecha_pago')->input('date', [
                            'max' => date('Y-m-d'),
                        ])->widget(DatePicker::className(), []) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'monto')->textInput(['value' => $model2->monto_bs]) ?>
                    </div>

                    <div class="col-sm-4">
                        <?= $form->field($model, 'referencia')->textInput(['maxlength' => true]) ?>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <?php
                        $operadores = Moneda::find()->where(['idestatus' => 1])->all();
                        $listmoneda = ArrayHelper::map($operadores, 'simbolo', 'simbolo');
                        echo $form->field($model, 'id_tipo_moneda')->widget(Select2::classname(), [
                            'data' => $listmoneda,
                            'pluginLoading' => false,
                            'value' => null,
                            'options' => ['placeholder' => 'Seleccione...'],
                            'pluginOptions' => [
                                'multiple' => false,
                                'allowClear' => true,
                            ],
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?= $form->field($model, 'tipo_pago')->widget(Select2::classname(), [
                            'data' =>
                            [
                                'Parcial' => 'Parcial',
                                'Total' => 'Total',
                            ],
                            'options' => ['placeholder' => 'Seleccione...'],
                            'pluginOptions' => [
                                'multiple' => false,
                                'allowClear' => true,
                            ],
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-4">
                        <?php
                        $metodo = BaseMetodosPago::find()->all();
                        $lismetodo = ArrayHelper::map($metodo, 'id_metodo', 'nombre_metodo');
                        echo $form->field($model, 'id_metodo')->widget(Select2::classname(), [
                            'data' => $lismetodo,
                            'pluginLoading' => false,
                            'value' => null,
                            'options' => ['placeholder' => 'Seleccione...'],
                            'pluginOptions' => [
                                'multiple' => false,
                                'allowClear' => true,
                            ],
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-4">
                        <?php
                        $operadores = OperadorFinanciero::find()->all();
                        $lisoperador = ArrayHelper::map($operadores, 'id_operador', 'nombre_operador');
                        echo $form->field($model, 'banco_origen')->widget(Select2::classname(), [
                            'data' => $lisoperador,
                            'pluginLoading' => false,
                            'value' => null,
                            'options' => ['placeholder' => 'Seleccione...'],
                            'pluginOptions' => [
                                'multiple' => false,
                                'allowClear' => true,
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'observacion_pago')->textarea(['rows' => 3])  ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="box-tools pull-right">
                        <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> <b>Regresar</b>', ['index'], ['class' => 'btn btn-warning btn']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> <b>Guardar</b>', ['class' => 'btn btn-primary btn']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
                <div class="row">

<div class="col-sm-12">
    <h4>Historial de Pagos</h4>
    <table class='table table-bordered' width=100%>
        <tr style="background-color: #394B8B; color: white">
            <th>Fecha de Pago</th>
            <th>Monto</th>
            <th>Moneda</th>
            <th>Referencia</th>
            <th>Tipo de pago</th>
            <th>Observación</th>
        </tr>
        <tr>
            <?php
            for ($i = 0; $i < count($model3); $i++) {
            ?>
        <tr>
            <td>
                <?php
                    $fecha = explode("-", $model3[$i]['fecha_pago']);
                    $fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];

                    echo $fecha;
                ?>
             </td>
            <td>
                <?php echo number_format($model3[$i]['monto'], 2, ',', '.');
                ?>
            </td>
            <td>
                <?php echo $model3[$i]['id_tipo_moneda']; ?>
            </td>
            <td>
                <?php echo $model3[$i]['referencia']; ?>
            </td>
            <td>
                <?php echo $model3[$i]['tipo_pago']; ?>
            </td>
            <td>
                <?php echo $model3[$i]['observacion_pago']; ?>
            </td>
       
            
        </tr>
    <?php
            }
    ?>

    </tr>
    </table>

</div>
</div>
            </div>

            
        </div>
    </div>
</div>