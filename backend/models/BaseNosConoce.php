<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "base_nos_conoce".
 *
 * @property int $id
 * @property string $nombre_nos_conoce
 * @property bool $estatus
 */
class BaseNosConoce extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_nos_conoce';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_nos_conoce'], 'required'],
            [['estatus'], 'boolean'],
            [['nombre_nos_conoce'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_nos_conoce' => '¿Cómo nos conoció?',
            'estatus' => '¿Activo?',
        ];
    }
}
