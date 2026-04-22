<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "flota".
 *
 * @property int $id
 * @property int $id_tipo_vehiculo
 * @property int $id_condicion
 * @property bool $tercerizado
 * @property int $id_marca
 * @property int $id_modelo
 * @property string $placa
 * @property int $id_estado
 * @property int $id_municipio
 * @property int $id_parroquia
 * @property bool $asignado
 * @property string $gerencia
 * @property string $nombre_gerente
 * @property string $fecha_asignacion
 * @property string $fecha_registro
 * @property int $id_usuario
 * @property int $foto1
 * @property int $foto2
 * @property int $fecha_vencimiento_rcv
 * @property int $color
 *
 * @property BaseTipoVehiculo $id0
 */
class Flota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

     public $condicion_anterior;

    public static function tableName()
    {
        return 'flota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipo_vehiculo', 'id_condicion', 'id_marca', 'id_modelo', 'placa', 'id_estado','fecha_vencimiento_rcv'], 'required'],
            [['id_tipo_vehiculo', 'id_condicion', 'id_marca', 'id_modelo', 'id_estado', 'id_municipio', 'id_parroquia', 'id_usuario'], 'default', 'value' => null],
            [['id_tipo_vehiculo', 'id_condicion', 'id_marca', 'id_modelo', 'id_estado', 'id_municipio', 'id_parroquia', 'id_usuario','condicion_anterior'], 'integer'],
            [['tercerizado', 'asignado'], 'boolean'],
            [['fecha_asignacion', 'fecha_registro', 'fecha_vencimiento_rcv'], 'safe'],
            [['placa'], 'string', 'max' => 7],
            [['gerencia'], 'string', 'max' => 50],
            [['color'], 'string', 'max' => 20],
            [['foto1','foto2','foto_rcv'], 'string', 'max' => 100],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => BaseTipoVehiculo::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tipo_vehiculo' => 'Tipo de Vehículo',
            'id_condicion' => 'Condición',
            'tercerizado' => 'Tercerizado',
            'id_marca' => 'Marca',
            'id_modelo' => 'Modelo',
            'placa' => 'Placa',
            'id_estado' => 'Estado',
            'id_municipio' => 'Municipio',
            'id_parroquia' => 'Parroquia',
            'asignado' => 'Asignado',
            'gerencia' => 'Gerencia',
            'fecha_asignacion' => 'Fecha Asignacion',
            'fecha_registro' => 'Fecha Registro',
            'id_usuario' => 'Id Usuario',
            'foto1' => 'Foto principal',
            'foto2' => 'Foto secundaria',
            'fecha_vencimiento_rcv' => 'Fecha de Vencimiento del RCV',
            'color' => 'Color',
            'foto_rcv' => 'Foto del RCV'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(BaseTipoVehiculo::className(), ['id' => 'id']);
    }
}
