<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "v_servicios".
 *
 * @property int $id_servicio
 * @property string $fecha_registro
 * @property int $id_tipo_vehiculo
 * @property string $nombre_tipo_vehiculo
 * @property int $id_tipo_traslado_ruta
 * @property string $nombre_traslado_ruta
 * @property int $id_cliente
 * @property int $id_tipo_cliente
 * @property string $cedula
 * @property string $nombre_apellido
 * @property string $telefono_principal
 * @property string $telefono_alterno
 * @property string $correo
 * @property int $id_estado
 * @property int $id_municipio
 * @property int $id_parroquia
 * @property string $direccion
 * @property int $empresa
 * @property int $id_referido
 * @property string $lugar_contacto
 * @property int $id_nos_conoce
 * @property string $fecha_cumpleanos
 * @property string $viaja_frecuente
 * @property int $recibir_correo
 * @property int $cliente_grato
 * @property int $id_categoria
 * @property int $id_proyecto
 * @property int $nuevo
 * @property string $fecha_servicio
 * @property int $km_servicio
 * @property int $monto
 * @property int $id_conductor
 * @property int $id_flota
 * @property int $id_estatus
 * @property string $observacion_inicial
 * @property int $id_usuario
 */
class VServicios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $total;

    public $fecha_registro_desde;
    public $fecha_registro_hasta;
    public $fecha_servicio_desde;
    public $fecha_servicio_hasta;

    public $fecha_gestion_pago_desde;
    public $fecha_gestion_pago_hasta;

    public $tipo_pago;
    public $num_factura;

    public static function tableName()
    {
        return 'v_servicios';
    }

    public static function primaryKey()
    {
        return ['id_servicio'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_servicio', 'id_tipo_vehiculo', 'id_tipo_traslado_ruta', 'id_cliente', 'id_tipo_cliente', 'id_estado', 'id_municipio', 'id_parroquia', 'empresa', 'id_referido', 'id_nos_conoce', 'recibir_correo', 'cliente_grato', 'id_categoria', 'id_proyecto', 'nuevo', 'km_servicio', 'monto', 'id_conductor', 'id_flota', 'id_estatus', 'id_usuario'], 'integer'],
            [['fecha_registro', 'id_tipo_vehiculo', 'nombre_tipo_vehiculo', 'id_tipo_traslado_ruta', 'nombre_traslado_ruta', 'id_tipo_cliente', 'telefono_principal', 'km_servicio', 'monto', 'id_estatus', 'observacion_inicial', 'id_usuario'], 'required'],
            [['fecha_registro', 'fecha_cumpleanos'], 'safe'],
            [['direccion', 'fecha_servicio'], 'string'],
            [['nombre_tipo_vehiculo', 'nombre_traslado_ruta', 'viaja_frecuente'], 'string', 'max' => 50],
            [['cedula'], 'string', 'max' => 10],
            [['nombre_apellido', 'correo', 'lugar_contacto'], 'string', 'max' => 80],
            [['telefono_principal', 'telefono_alterno'], 'string', 'max' => 12],
            [['observacion_inicial'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_servicio' => 'Id Servicio',
            'fecha_registro' => 'Fecha Registro',
            'id_tipo_vehiculo' => 'Id Tipo Vehiculo',
            'nombre_tipo_vehiculo' => 'Nombre Tipo Vehiculo',
            'id_tipo_traslado_ruta' => 'Id Tipo Traslado Ruta',
            'nombre_traslado_ruta' => 'Nombre Traslado Ruta',
            'id_cliente' => 'Id Cliente',
            'id_tipo_cliente' => 'Id Tipo Cliente',
            'cedula' => 'Cedula',
            'nombre_apellido' => 'Nombre Apellido',
            'telefono_principal' => 'Telefono Principal',
            'telefono_alterno' => 'Telefono Alterno',
            'correo' => 'Correo',
            'id_estado' => 'Id Estado',
            'id_municipio' => 'Id Municipio',
            'id_parroquia' => 'Id Parroquia',
            'direccion' => 'Direccion',
            'empresa' => 'Empresa',
            'id_referido' => 'Id Referido',
            'lugar_contacto' => 'Lugar Contacto',
            'id_nos_conoce' => 'Id Nos Conoce',
            'fecha_cumpleanos' => 'Fecha Cumpleanos',
            'viaja_frecuente' => 'Viaja Frecuente',
            'recibir_correo' => 'Recibir Correo',
            'cliente_grato' => 'Cliente Grato',
            'id_categoria' => 'Id Categoria',
            'id_proyecto' => 'Id Proyecto',
            'nuevo' => 'Nuevo',
            'fecha_servicio' => 'Fecha Servicio',
            'km_servicio' => 'Km Servicio',
            'monto' => 'Monto',
            'id_conductor' => 'Id Conductor',
            'id_flota' => 'Id Flota',
            'id_estatus' => 'Id Estatus',
            'observacion_inicial' => 'Observacion Inicial',
            'id_usuario' => 'Id Usuario',
        ];
    }
}
