<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "base_metodos_pago".
 *
 * @property int $id_metodo
 * @property string $nombre_metodo
 * @property string $num_cuenta
 * @property string $banco
 * @property string $telefono
 * @property string $identificacion
 * @property bool $estatus
 */
class BaseMetodosPago extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_metodos_pago';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_metodo'], 'required'],
            [['estatus'], 'boolean'],
            [['nombre_metodo','email'], 'string', 'max' => 50],
            [['email'], 'email'],
            [['num_cuenta'], 'string', 'max' => 20],
            [['banco'], 'string', 'max' => 20],
            [['telefono'], 'string', 'max' => 12],
            [['identificacion'], 'string', 'max' => 70],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_metodo' => 'Id Metodo',
            'nombre_metodo' => 'Nombre Método',
            'num_cuenta' => 'Número de Cuenta asociado',
            'banco' => 'Banco',
            'telefono' => 'Teléfono',
            'identificacion' => 'Identificación',
            'estatus' => '¿Activo?',
            'email ' => 'Correo',
        ];
    }
}
