<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "base_tipo_cliente".
 *
 * @property int $id
 * @property string $nombre_tipo_cliente
 * @property bool $estatus
 */
class BaseTipoCliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_tipo_cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_tipo_cliente'], 'required'],
            [['estatus'], 'boolean'],
            [['nombre_tipo_cliente'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_tipo_cliente' => 'Nombre Tipo Cliente',
            'estatus' => '¿Activo?',
        ];
    }
}
