<?php

use backend\models\BaseTipoVehiculo;
use backend\models\Cliente;
use backend\models\Estatus;
use backend\models\ListaPrecio;
use backend\models\Pasajero;
use backend\models\PasajeroServicio;
use backend\models\ServicioVariables;
use backend\models\Tarifario;
use backend\models\TipoRuta;
use backend\models\TipoTrasladoRuta;
use backend\models\User;
use backend\models\VariablesServicio;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\touchspin\TouchSpin;
use yii\web\JsExpression;
use kartik\date\DatePicker;
use kartik\widgets\TimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Servicios */
/* @var $form yii\widgets\ActiveForm */

$tarifario_base = Tarifario::find()->one();
$this->registerJsFile('@web/js/solicitudes.js');

?>
<?php $form = ActiveForm::begin([
    'action' => ['modificar-pasajeros', 'id' => $_GET['id']],
    'method' => 'post',
]); ?>

<div class="box box-widget widget-user-2">

    <div class="box box-primary">
        <div class="box-body">
            <div id="pasajeros_div" style="display:block">


                <div class="row">
                    <div class="col-md-6">

                        <?php
                        $data = Pasajero::find()
                            ->select([
                                'nombre_apellido as value',
                                'nombre_apellido as label',
                                'id_pasajero as id',
                                'telefono'
                            ])
                            ->asArray()
                            ->all();
                        ?>
                        <?= $form->field($model6, 'nombre_apellido')->widget(\yii\jui\AutoComplete::classname(), [
                            'clientOptions' => [
                                'source' => $data,
                                'autoFill' => true,
                                'class' => 'form-control',
                                'minLength' => '1',

                                'select' => new JsExpression("function( event, ui ) {
                        var str = ui.item.label;
                        var matches = str.match(/[A-Z]/g);
                        var acronym = matches.join('');
                        $('#nombre_apellido').val(ui.item.nombre_apellido);
                        $('#telefono_pax').val(ui.item.telefono);
                        }")
                            ],
                            'options' => [
                                'class' => 'form-control',
                            ]
                        ]) ?>

                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model6, 'telefono')->textInput(['id' => 'telefono_pax', 'maxlength' => true]) ?>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model7, 'fecha')->input('date', [
                            'max' => date('Y-m-d'),
                        ])->widget(DatePicker::className(), []) ?>

                    </div>
                    <div class="col-md-6">
                        <label>Hora</label>
                        <?php
                        echo TimePicker::widget([
                            'name' => 'hora',
                            'options' => [
                                'readonly' => true,
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model7, 'origen')->textarea(['rows' => 3])  ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model7, 'destino')->textarea(['rows' => 3])  ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-success" style="width: 30%;" onclick="add_pax()">Agregar Ruta</button>
                    </div>
                </div>
                <?php

                if ($registros) {
                ?>
                    <div class="row" id="resumen_pasajeros" style="display: block;">
                        <div class="col-md-12">
                            <br>
                            <fieldset>
                                <legend>Pasajeros por rutas (Nuevos)</legend>
                                <?= $form->field($model6, 'num_pax')->hiddenInput(['id' => 'num_pax', 'value' => 1])->label(false) ?>

                                <div class="col-md-12" id='pax_1' style="display: none;">
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'nombre1')->textInput(['id' => 'nombre1', 'maxlength' => true])->label('Nombre') ?>
                                    </div>
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'telefono1')->textInput(['id' => 'telefono1', 'maxlength' => true])->label('Teléfono') ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model7, 'fecha1')->textInput(['id' => 'fecha1', 'maxlength' => true])->label('Fecha') ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model7, 'hora1')->textInput(['id' => 'hora1', 'maxlength' => true])->label('Hora') ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model7, 'origen1')->textInput(['id' => 'origen1', 'maxlength' => true])->label('Origen') ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model7, 'destino1')->textInput(['id' => 'destino1', 'maxlength' => true])->label('Destino') ?>
                                    </div>
                                </div>

                                <div class="col-md-12" id='pax_2' style="display: none;">
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'nombre2')->textInput(['id' => 'nombre2', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'telefono2')->textInput(['id' => 'telefono2', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model7, 'fecha2')->textInput(['id' => 'fecha2', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model7, 'hora2')->textInput(['id' => 'hora2', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model7, 'origen2')->textInput(['id' => 'origen2', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model7, 'destino2')->textInput(['id' => 'destino2', 'maxlength' => true])->label(false) ?>
                                    </div>
                                </div>

                                <div class="col-md-12" id='pax_3' style="display: none;">
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'nombre3')->textInput(['id' => 'nombre3', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'telefono3')->textInput(['id' => 'telefono3', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model7, 'fecha3')->textInput(['id' => 'fecha3', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model7, 'hora3')->textInput(['id' => 'hora3', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model7, 'origen3')->textInput(['id' => 'origen3', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model7, 'destino3')->textInput(['id' => 'destino3', 'maxlength' => true])->label(false) ?>
                                    </div>
                                </div>

                                <div class="col-md-12" id='pax_4' style="display: none;">
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'nombre4')->textInput(['id' => 'nombre4', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-2">
                                        <?= $form->field($model6, 'telefono4')->textInput(['id' => 'telefono4', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model7, 'fecha4')->textInput(['id' => 'fecha4', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-1">
                                        <?= $form->field($model7, 'hora4')->textInput(['id' => 'hora4', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model7, 'origen4')->textInput(['id' => 'origen4', 'maxlength' => true])->label(false) ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model7, 'destino4')->textInput(['id' => 'destino4', 'maxlength' => true])->label(false) ?>
                                    </div>
                                </div>
                            </fieldset>
                            <legend>Pasajeros previamente registrados</legend>
                            <table class="table">
                                <tr style="background-color: #ededed;">
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                    <th>Acción</th>
                                </tr>
                                <tr>
                                    <?php
                                    $pax = PasajeroServicio::find()->where(['id_servicio' => $model->id_servicio])->all();
                                    for ($i = 0; $i < count($pax); $i++) {
                                    ?>
                                <tr>
                                    <td>
                                        <?= $i + 1; ?>
                                    </td>
                                    <td>
                                        <?php $pax_dato = Pasajero::find()->where(['id_pasajero' => $pax[$i]['id_pasajero']])->one(); ?>
                                        <?= $pax_dato->nombre_apellido; ?>
                                    </td>
                                    <td>
                                        <?= $pax_dato->telefono; ?>
                                    </td>
                                    <td>
                                        <?= Yii::$app->formatter->asDate($pax[$i]['fecha'], 'php:d-m-Y') ?>
                                    </td>
                                    <td>
                                        <?= $pax[$i]['hora'] ?>
                                    </td>
                                    <td>
                                        <?= $pax[$i]['origen'] ?>
                                    </td>
                                    <td>
                                        <?= $pax[$i]['destino'] ?>
                                    </td>
                                    <td>
                                        <?= Html::a('Borrar', ['delete-pax', 'id' => $pax[$i]['id_pasajero'], 'id_servicio' =>$_GET['id']], [
                                            'class' => 'btn btn-danger',
                                            'data' => [
                                                'confirm' => '¿Seguro desea eliminar el Registro ?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php
                                    }
                            ?>
                            </table>
                            <fieldset>

                            </fieldset>
                        </div>
                    </div>
                <?php }?>
                <div class="form-group">
                    <div class="box-tools pull-right">
                        <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> <b>Regresar</b>', ['index'], ['class' => 'btn btn-warning btn']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> <b>Guardar</b>', ['class' => 'btn btn-primary btn']) ?>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

</div>
<?php ActiveForm::end(); ?>
</div>