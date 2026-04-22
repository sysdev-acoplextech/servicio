<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pasajero_servicio".
 *
 * @property int $id_pax_servicio
 * @property int $id_servicio
 * @property int $id_pasajero
 * @property string $hora
 * @property string $origen
 * @property string $destino
 * @property string $fecha
 * @property string|null $google_map
 */
class PasajeroServicio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pasajero_servicio';
    }

    // Propiedades virtuales (si las sigues necesitando para formularios dinámicos)
    public $hora1; public $fecha1; public $origen1; public $destino1;
    public $hora2; public $fecha2; public $origen2; public $destino2;
    public $hora3; public $fecha3; public $origen3; public $destino3;
    public $hora4; public $fecha4; public $origen4; public $destino4;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_servicio', 'id_pasajero', 'fecha'], 'required'],
            [['id_servicio', 'id_pasajero'], 'integer'],
            [['hora', 'fecha', 'google_map'], 'safe'],
            [['origen', 'destino'], 'string', 'max' => 200],
            [['fecha'], 'date', 'format' => 'php:Y-m-d'],
            // Usamos la nueva validación corregida
            [['fecha'], 'validateFechaNoPasada'],
        ];
    }

    /**
     * VALIDACIÓN CORREGIDA:
     * Ahora permite fechas de HOY en adelante (Futuro).
     * Solo da error si la fecha es de AYER o más atrás.
     */
    public function validateFechaNoPasada($attribute, $params)
    {
        if (strtotime($this->$attribute) < strtotime(date('Y-m-d'))) {
            $this->addError($attribute, 'La fecha del servicio no puede ser una fecha pasada.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pax_servicio' => 'ID',
            'id_servicio' => 'Servicio',
            'id_pasajero' => 'Pasajero',
            'hora' => 'Hora',
            'origen' => 'Origen',
            'destino' => 'Destino',
            'fecha' => 'Fecha del Servicio',
        ];
    }
}