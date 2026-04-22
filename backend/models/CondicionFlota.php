<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "condicion_flota".
 *
 * @property int $id
 * @property string $nombre_condicion_flota
 * @property bool $estatus
 */
class CondicionFlota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'condicion_flota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_condicion_flota'], 'required'],
            [['estatus'], 'boolean'],
            [['nombre_condicion_flota'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_condicion_flota' => 'Nombre Condicion Flota',
            'estatus' => '¿Activo?',
        ];
    }
}
