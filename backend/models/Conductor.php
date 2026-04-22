<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "conductor".
 *
 * @property int $id
 * @property string $cedula
 * @property string $nacionalidad
 * @property string $nombres
 * @property string $apellidos
 * @property string $telefono_principal
 * @property string $telefono_alterno
 * @property string $correo
 * @property string $fecha_ingreso
 * @property string $fecha_egreso
 * @property string $foto
 * @property int $estatus
 * @property int $id_usuario
 */
class Conductor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conductor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cedula', 'nacionalidad', 'nombres', 'apellidos', 'telefono_principal', 'correo', 'fecha_ingreso'], 'required'],
            [['fecha_ingreso', 'fecha_egreso','foto','id_usuario'], 'safe'],
            [['estatus', 'id_usuario','tercerizado'], 'integer'],
            [['cedula'], 'string', 'max' => 8],
            [['nacionalidad'], 'string', 'max' => 1],
            [['nombres', 'apellidos', 'correo'], 'string', 'max' => 60],
            [['telefono_principal', 'telefono_alterno'], 'string', 'max' => 13],
            [['foto'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cedula' => 'Cédula',
            'nacionalidad' => 'Nacionalidad',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'telefono_principal' => 'Teléfono Principal',
            'telefono_alterno' => 'Teléfono Alterno',
            'correo' => 'Correo',
            'fecha_ingreso' => 'Fecha Ingreso',
            'fecha_egreso' => 'Fecha Egreso',
            'foto' => 'Foto',
            'estatus' => '¿Activo?',
            'id_usuario' => 'Id Usuario',
            'tercerizado' => '¿Tercerizado?', 
            'observacion_inicial' => 'Observación Inicial', 
        ];
    }
}
