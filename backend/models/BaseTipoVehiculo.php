<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "base_tipo_vehiculo".
 *
 * @property int $id
 * @property string $nombre_tipo_vehiculo
 * @property bool $estatus
 */
class BaseTipoVehiculo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_tipo_vehiculo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_tipo_vehiculo'], 'required'],
            [['estatus'], 'boolean'],
            [['nombre_tipo_vehiculo'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_tipo_vehiculo' => 'Nombre Tipo de Vehículo',
            'estatus' => '¿Activo?',
        ];
    }
}
