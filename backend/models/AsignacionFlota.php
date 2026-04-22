<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "asignacion_flota".
 *
 * @property int $id_asignacion
 * @property int $id_flota
 * @property int $id_conductor
 * @property string $fecha_asignacion
 */
class AsignacionFlota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asignacion_flota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_asignacion', 'fecha_asignacion'], 'required'],
            [['id_asignacion', 'id_flota', 'id_conductor'], 'integer'],
            [['fecha_asignacion'], 'safe'],
            [['ultimo'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_asignacion' => 'Id Asignacion',
            'id_flota' => 'Id Flota',
            'id_conductor' => 'Conductor',
            'fecha_asignacion' => 'Fecha de asignación',
            'ultimo' => 'Último',
        ];
    }
}
