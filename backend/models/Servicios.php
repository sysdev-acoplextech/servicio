<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "servicios".
 *
 * @property int $id_servicio
 * @property string $fecha_registro
 * @property int $id_tipo_vehiculo
 * @property int $id_tipo_traslado_ruta
 * @property int $id_cliente
 * @property string $fecha_servicio
 * @property int $monto
 * @property int $id_conductor
 * @property int $id_flota
 * @property int $id_estatus
 * @property string $observacion_inicial
 * @property int $id_usuario
 *
 * @property MovServicio $servicio
 */
class Servicios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $item_km;
    public $desc_km;
    public $item_tipo_vehiculo;
    public $item_ruta;
    public $item_horario;


    public $flota_conductor;


    // PROPIEDADES PARA EL CÁLCULO DE TARIFARIO (STEP 3)
    public $monto_base;
    public $monto_recargo;
    public $viaticos;
    public $monto_total;


    public static function tableName()
    {
        return 'servicios';
    }
   


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
       return [
        [['fecha_servicio', 'id_cliente', 'id_tipo_vehiculo', 'monto', 'id_tipo_traslado_ruta'], 'required'],
        [['id_tipo_vehiculo', 'id_tipo_traslado_ruta', 'id_conductor', 'id_flota', 'id_estatus', 'id_usuario', 'id_tipo_ruta', 'id_forma_pago', 'facturado', 'tipo_servicio'], 'integer'],
        [['fecha_registro', 'fecha_servicio', 'monto_base', 'monto_recargo', 'viaticos', 'monto_total', 'total_viatico', 'flota_conductor'], 'safe'],
        [['faltante'], 'number'],
        [['observacion_inicial'], 'string', 'max' => 200],
        [['item_tipo_vehiculo', 'item_ruta', 'item_horario'], 'string'],
        [['id_servicio'], 'exist', 'skipOnError' => true, 'targetClass' => MovServicio::className(), 'targetAttribute' => ['id_servicio' => 'id_mov_servicio']],
    ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_servicio' => 'Num.',
            'fecha_registro' => 'Fecha de Registro',
            'id_tipo_vehiculo' => 'Tipo de Vehículo',
            'id_tipo_traslado_ruta' => 'Ruta',
            'id_cliente' => 'Cliente',
            'fecha_servicio' => 'Fecha del servicio',
            'monto' => 'Monto ($)',
            'id_conductor' => 'Conductor',
            'id_flota' => 'Flota',
            'id_estatus' => 'Estatus',
            'observacion_inicial' => 'Observacion Inicial',
            'id_usuario' => 'Usuario',
            'flota_conductor' => 'Flotas asignadas',
            'id_tipo_ruta' => 'Tipo de ruta',
            'total_viatico' => 'Monto del Viático',
            'id_forma_pago' => 'Forma de pago',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicio()
    {
        return $this->hasOne(MovServicio::className(), ['id_mov_servicio' => 'id_servicio']);
    }

    public function getCliente()
    {
        // Relaciona el id_cliente de la tabla servicios con el id_cliente de la tabla cliente
        return $this->hasOne(Cliente::class, ['id_cliente' => 'id_cliente']);
    }

    public function getEstatusRelacion()
    {
        // Cambia 'Estatus' por el nombre de tu modelo de estados
        // y 'id_estatus' por la columna que los une
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus']);
    }
}
