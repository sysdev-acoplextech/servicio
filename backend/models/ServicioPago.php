<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "servicio_pago".
 *
 * @property int $id_pago
 * @property int $id_servicio
 * @property string $fecha_pago
 * @property double $monto
 * @property string $referencia
 * @property string $tipo_pago
 * @property int $id_metodo
 * @property int $banco_origen
 * @property string $procedencia
 * @property string $observacion_pago
 * @property int $id_tipo_moneda 
 */
class ServicioPago extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $monto_pagar;

    public static function tableName()
    {
        return 'servicio_pago';
    }

    public $id_cliente;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_servicio', 'monto', 'tipo_pago','id_metodo','fecha_pago'], 'required'],
            [['id_servicio',  'banco_origen','id_factura'], 'integer'],
            [['observacion_pago' ,'referencia', 'fecha_pago', 'id_metodo'], 'safe'],
            ['fecha_pago', 'date', 'format' => 'php:Y-m-d'], // Asegúrate de que sea una fecha válida
           // ['fecha_pago', 'compare', 'compareValue' => date('Y-m-d'), 'operator' => '>', 'message' => 'La fecha no puede ser fechas futuraddds.'],

            [['monto','monto_pagar'], 'number'],
            [['referencia'], 'string', 'max' => 20],
            [['tipo_pago'], 'string', 'max' => 40],
            [['procedencia'], 'string', 'max' => 60],
            [['id_tipo_moneda'], 'string', 'max' => 2],
            [['observacion_pago'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pago' => 'Id Pago',
            'id_servicio' => 'Id Servicio',
            'fecha_pago' => 'Fecha del pago',
            'monto' => 'Monto',
            'referencia' => 'Referencia',
            'tipo_pago' => 'Tipo de Pago',
            'id_metodo' => 'Método de pago',
            'banco_origen' => 'Banco de origen',
            'procedencia' => 'Procedencia',
            'observacion_pago' => 'Observación del pago',
            'id_tipo_moneda' => 'Tipo de moneda',
        ];
    }
}
