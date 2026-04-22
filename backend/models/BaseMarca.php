<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "base_marca".
 *
 * @property int $id
 * @property string $nombre_marca
 * @property bool $estatus
 */
class BaseMarca extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_marca';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_marca'], 'required'],
            [['estatus'], 'boolean'],
            [['nombre_marca'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_marca' => 'Nombre Marca',
            'estatus' => '¿Activo?',
        ];
    }
}
