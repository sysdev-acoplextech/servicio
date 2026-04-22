<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "v_flota".
 *
 * @property int $id
 * @property int $id_tipo_vehiculo
 * @property int $id_condicion
 * @property int $tercerizado
 * @property int $id_marca
 * @property int $id_modelo
 * @property string $placa
 * @property int $id_estado
 * @property int $id_municipio
 * @property int $id_parroquia
 * @property int $asignado
 * @property string $gerencia
 * @property string $nombre_gerente
 * @property string $fecha_asignacion
 * @property string $fecha_registro
 * @property int $id_usuario
 * @property string $foto1
 * @property string $foto2
 * @property string $fecha_vencimiento_rcv
 * @property string $color
 * @property string $foto_rcv
 * @property string $nombre_tipo_vehiculo
 * @property string $nombre_condicion_flota
 * @property string $nombre_marca
 * @property string $nombre_modelo
 */
class VFlota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'v_flota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_tipo_vehiculo', 'id_condicion', 'tercerizado', 'id_marca', 'id_modelo', 'id_estado', 'id_municipio', 'id_parroquia', 'asignado', 'id_usuario'], 'integer'],
            [['gerencia', 'nombre_gerente', 'fecha_asignacion'], 'required'],
            [['fecha_asignacion', 'fecha_registro', 'fecha_vencimiento_rcv'], 'safe'],
            [['placa'], 'string', 'max' => 10],
            [['gerencia', 'nombre_tipo_vehiculo', 'nombre_condicion_flota', 'nombre_marca', 'nombre_modelo'], 'string', 'max' => 50],
            [['nombre_gerente'], 'string', 'max' => 60],
            [['foto1', 'foto2', 'foto_rcv'], 'string', 'max' => 100],
            [['color'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tipo_vehiculo' => 'Id Tipo Vehiculo',
            'id_condicion' => 'Id Condicion',
            'tercerizado' => 'Tercerizado',
            'id_marca' => 'Id Marca',
            'id_modelo' => 'Id Modelo',
            'placa' => 'Placa',
            'id_estado' => 'Id Estado',
            'id_municipio' => 'Id Municipio',
            'id_parroquia' => 'Id Parroquia',
            'asignado' => 'Asignado',
            'gerencia' => 'Gerencia',
            'nombre_gerente' => 'Nombre Gerente',
            'fecha_asignacion' => 'Fecha Asignacion',
            'fecha_registro' => 'Fecha Registro',
            'id_usuario' => 'Id Usuario',
            'foto1' => 'Foto1',
            'foto2' => 'Foto2',
            'fecha_vencimiento_rcv' => 'Fecha Vencimiento Rcv',
            'color' => 'Color',
            'foto_rcv' => 'Foto Rcv',
            'nombre_tipo_vehiculo' => 'Nombre Tipo Vehiculo',
            'nombre_condicion_flota' => 'Nombre Condicion Flota',
            'nombre_marca' => 'Nombre Marca',
            'nombre_modelo' => 'Nombre Modelo',
        ];
    }
}
