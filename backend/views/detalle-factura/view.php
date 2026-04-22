<?php

use backend\models\Cliente;
use backend\models\Pasajero;
use backend\models\PasajeroServicio;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DetalleFactura */

$this->title = " Detalle de la Factura: " . $model->num_factura;
$this->params['breadcrumbs'][] = ['label' => 'Detalle Facturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="detalle-factura-view">
    <div class="box box-widget widget-user-2">
        <div class="box box-primary">
            <div class="box-body">



                <div class="row">
                    <div class="col-md-12">
                        <h4>Detalle de la Factura</h4>
                    </div>
                    <div class="col-md-12">
                        <table class='table table-bordered' width=100%>
                            <tr style="background-color: #394B8B; color: white">
                                <th>Fecha de Factura</th>
                                <th>Monto ($)</th>
                                <th>Tasa</th>
                                <th>Subtotal (Bs)</th>
                                <th>Iva</th>
                                <th>Monto Total (Bs)</th>
                                <th>Fecha de Emisión</th>
                                <th>Cliente</th>
                            </tr>
                            <tr>
                                <th><?= Yii::$app->formatter->asDate($model->fecha_factura, 'php:d-m-Y') ?></th>
                                <th><?= Yii::$app->formatter->asDecimal($model->monto_facturado, 2);   ?></th>
                                <th><?= Yii::$app->formatter->asDecimal($model->tasa_dia, 2);   ?></th>
                                <th><?= Yii::$app->formatter->asDecimal($model->subtotal, 2);   ?></th>
                                <th><?= Yii::$app->formatter->asDecimal($model->iva, 2);   ?></th>
                                <th><?= Yii::$app->formatter->asDecimal($model->monto_bs, 2);   ?></th>
                                <th><?= Yii::$app->formatter->asDate($model->fecha_emision, 'php:d-m-Y') ?></th>
                                <th>
                                    <?php
                                    $cliente = Cliente::find()->where(['id_cliente' => $model->id_cliente])->one();
                                    echo "<b>" . $cliente->nombre_apellido . "</b>";
                                    ?>
                                </th>
                            </tr>
                        </table>

                    </div>
                    <div class="col-md-12">
                        <h4>Servicios Asociados</h4>
                    </div>
                    <div class="col-md-12">
                        <table class='table table-bordered' width=100%>
                            <tr style="background-color: #394B8B; color: white">
                                <th>Fecha de Servicio</th>
                                <th>Monto ($)</th>
                                <th>Pasajeros</th>
                                <th>Origen</th>
                                <th>Destino</th>
                            </tr>
                            <tr>
                                <?php for ($i = 0; $i < count($model3); $i++) { ?>
                                    <td><?= Yii::$app->formatter->asDate($model3[$i]['fecha_servicio'], 'php:d-m-Y') ?></td>
                                    <td><?= Yii::$app->formatter->asDecimal($model3[$i]['monto'], 2); ?></td>
                                    <?php
                                    $pax = PasajeroServicio::find()->where(['id_servicio' => $model3[$i]['id_servicio']])->all();
                                    foreach ($pax as $key => $value) {
                                        $det_pax = Pasajero::find()->where(['id_pasajero' => $value->id_pasajero])->one();
                                    ?>
                                        <td><?= $det_pax['nombre_apellido']; ?></td>
                                        <td><?= $value->origen; ?></td>
                                        <td><?= $value->destino; ?></td>
                                    <?php
                                    }
                                    ?>

                                <?php } ?>
                            </tr>
                        </table>


                    </div>
                </div>



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
                                for ($i = 0; $i < count($model2); $i++) {
                                ?>
                            <tr>
                                <td>
                                    <?php
                                    $fecha = explode("-", $model2[$i]['fecha_pago']);
                                    $fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];

                                    echo $fecha;
                                    ?>
                                </td>
                                <td>
                                    <?php echo number_format($model2[$i]['monto'], 2, ',', '.');
                                    ?>
                                </td>
                                <td>
                                    <?php echo $model2[$i]['id_tipo_moneda']; ?>
                                </td>
                                <td>
                                    <?php echo $model2[$i]['referencia']; ?>
                                </td>
                                <td>
                                    <?php echo $model2[$i]['tipo_pago']; ?>
                                </td>
                                <td>
                                    <?php echo $model2[$i]['observacion_pago']; ?>
                                </td>


                            </tr>
                        <?php
                                }
                        ?>

                        </tr>
                        </table>

                    </div>

                </div>

                <div class="form-group">
                    <div class="box-tools pull-right">
                        <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> <b>Regresar</b>', ['v-servicios-proyecto/facturas', 'id_cliente' => $model->id_cliente], ['class' => 'btn btn-warning btn']) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>