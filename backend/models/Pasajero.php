<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pasajero".
 *
 * @property int $id_pasajero
 * @property string $nombre_apellido
 * @property string $telefono
 */
class Pasajero extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pasajero';
    }

    public $nombre1;
    public $nombre2;
    public $nombre3;
    public $nombre4;
    
    public $telefono1;
    public $telefono2;
    public $telefono3;
    public $telefono4;

    public $num_pax;




    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_apellido', 'telefono'], 'safe'],
            [['nombre_apellido'], 'string', 'max' => 40],
            [['telefono'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pasajero' => 'Id Pasajero',
            'nombre_apellido' => 'Nombre y Apellido',
            'telefono' => 'Teléfono',
        ];
    }
}
