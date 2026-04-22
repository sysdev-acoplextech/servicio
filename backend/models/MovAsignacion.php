<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "mov_asignacion".
 *
 * @property int $id
 * @property int $id_flota
 * @property string $gerencia
 * @property string $nombre_gerente
 * @property string $fecha_asignacion
 * @property string $observacion
 * @property int $id_usuario
 * @property int $ultimo
 */
class MovAsignacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mov_asignacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_flota', 'observacion', 'id_usuario'], 'required'],
            [['id_flota', 'id_usuario', 'ultimo'], 'integer'],
            [['fecha_asignacion'], 'safe'],
            [['gerencia', 'nombre_gerente', 'observacion'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_flota' => 'Id Flota',
            'gerencia' => 'Gerencia',
            'nombre_gerente' => 'Nombre Gerente',
            'fecha_asignacion' => 'Fecha de Asignación',
            'observacion' => 'Observación',
            'id_usuario' => 'Id Usuario',
            'ultimo' => 'Último',
        ];
    }
}
