<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cotizacion_rapida".
 *
 * @property int $id_cotizacion
 * @property string $cliente_nombre
 * @property string $telefono
 * @property string $fecha_servicio
 * @property string $hora_servicio
 * @property int $id_tarifario
 * @property string $ruta_detalle
 * @property int $id_tipo_vehiculo
 * @property string $forma_pago
 * @property string $adicionales_json
 * @property string $monto_base
 * @property string $monto_recargo
 * @property string $monto_viatico
 * @property string $monto_total
 * @property string $creado_el
 */
class CotizacionRapida extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cotizacion_rapida';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_servicio', 'hora_servicio', 'creado_el'], 'safe'],
            [['id_tarifario', 'id_tipo_vehiculo'], 'integer'],
            [['ruta_detalle', 'adicionales_json'], 'string'],
            [['monto_base', 'monto_recargo', 'monto_viatico', 'monto_total'], 'number'],
            [['cliente_nombre'], 'string', 'max' => 255],
            [['telefono'], 'string', 'max' => 11],
            [['forma_pago'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cotizacion' => 'Id Cotizacion',
            'cliente_nombre' => 'Cliente Nombre',
            'telefono' => 'Telefono',
            'fecha_servicio' => 'Fecha Servicio',
            'hora_servicio' => 'Hora Servicio',
            'id_tarifario' => 'Id Tarifario',
            'ruta_detalle' => 'Ruta Detalle',
            'id_tipo_vehiculo' => 'Id Tipo Vehiculo',
            'forma_pago' => 'Forma Pago',
            'adicionales_json' => 'Adicionales Json',
            'monto_base' => 'Monto Base',
            'monto_recargo' => 'Monto Recargo',
            'monto_viatico' => 'Monto Viatico',
            'monto_total' => 'Monto Total',
            'creado_el' => 'Creado El',
        ];
    }
}
