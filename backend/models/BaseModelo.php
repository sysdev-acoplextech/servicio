<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "base_modelo".
 *
 * @property int $id
 * @property string $nombre_modelo
 * @property string $id_marca
 * @property bool $estatus
 */
class BaseModelo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_modelo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_modelo'], 'required'],
            [['id_marca'], 'string'],
            [['estatus'], 'boolean'],
            [['nombre_modelo'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_modelo' => 'Nombre Modelo',
            'id_marca' => 'Marcas',
            'estatus' => '¿Activo?',
        ];
    }
}
