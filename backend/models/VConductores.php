<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "v_conductores".
 *
 * @property int $id
 * @property string $cedula
 * @property string $nacionalidad
 * @property string $datos
 * @property string $telefono_principal
 * @property string $telefono_alterno
 * @property string $correo
 * @property string $fecha_ingreso
 * @property string $fecha_egreso
 * @property string $foto
 * @property int $estatus
 * @property int $id_usuario
 * @property string $fecha_registro
 */
class VConductores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'v_conductores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estatus', 'id_usuario'], 'integer'],
            [['cedula', 'nacionalidad', 'telefono_principal', 'correo', 'fecha_ingreso', 'foto', 'id_usuario'], 'required'],
            [['fecha_ingreso', 'fecha_egreso', 'fecha_registro'], 'safe'],
            [['cedula'], 'string', 'max' => 8],
            [['nacionalidad'], 'string', 'max' => 1],
            [['datos'], 'string', 'max' => 121],
            [['telefono_principal', 'telefono_alterno'], 'string', 'max' => 13],
            [['correo'], 'string', 'max' => 60],
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
            'cedula' => 'Cedula',
            'nacionalidad' => 'Nacionalidad',
            'datos' => 'Datos',
            'telefono_principal' => 'Telefono Principal',
            'telefono_alterno' => 'Telefono Alterno',
            'correo' => 'Correo',
            'fecha_ingreso' => 'Fecha Ingreso',
            'fecha_egreso' => 'Fecha Egreso',
            'foto' => 'Foto',
            'estatus' => 'Estatus',
            'id_usuario' => 'Id Usuario',
            'fecha_registro' => 'Fecha Registro',
        ];
    }
}
