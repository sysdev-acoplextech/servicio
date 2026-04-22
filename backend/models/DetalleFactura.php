<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "detalle_factura".
 *
 * @property int $id_detallefactura
 * @property int $num_factura
 * @property string $fecha_factura
 * @property string $observacion
 * @property double $monto_facturado
 * @property string $id_servicios
 * @property double $subtotal
 * @property double $iva
 * @property double $tasa_dia
 * @property string $fecha_emision
 */
class DetalleFactura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalle_factura';
    }

    public $item_seleccionados;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_factura', 'fecha_emision'], 'safe'],
            [['monto_facturado', 'subtotal', 'iva', 'tasa_dia','monto_bs'], 'number'],
            [['observacion'], 'string', 'max' => 100],
            [['item_seleccionados','num_factura'], 'string'],
            [['id_cliente'], 'integer'],
            [['id_servicios'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_detallefactura' => 'Id Detallefactura',
            'num_factura' => 'Num. Factura',
            'fecha_factura' => 'Fecha de la factura',
            'observacion' => 'Observación',
            'monto_facturado' => 'Monto facturado ($)',
            'id_servicios' => 'Id Servicios',
            'subtotal' => 'Subtotal',
            'iva' => 'Iva (16%)',
            'tasa_dia' => 'Tasa (Bs.)',
            'fecha_emision' => 'Fecha de emisión',
            'monto_bs' => 'Monto Facturado (Bs.)',
            'id_cliente' => 'Cliente',
        ];
    }
}
