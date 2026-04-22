<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cliente".
 *
 * @property int $id_cliente
 * @property int $id_tipo_cliente
 * @property int $cedula
 * @property int $nombre_apellido
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
 * @property int $id_usuario
 * @property string $fecha_registro
 */
class Cliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cliente';
    }

    public $esreferido;
    public $rif;
    public $razon_social;
    public $mismapersona;
    public $cedula_rif_serv;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipo_cliente', 'telefono_principal'], 'required'],
            [['id_tipo_cliente', 'id_estado', 'id_municipio', 'id_parroquia', 'empresa', 'id_referido', 'id_nos_conoce', 'recibir_correo', 'cliente_grato', 'id_categoria', 'id_proyecto', 'id_usuario','esreferido'], 'integer'],
            [['direccion','razon_social','observacion'], 'string'],
            [['fecha_cumpleanos', 'fecha_registro'], 'safe'],
            [['telefono_principal', 'telefono_alterno'], 'string', 'max' => 11],
            [['rif'], 'string', 'max' => 10],
            [['cedula_rif_serv'], 'string', 'max' => 10],
            [['cedula'], 'string', 'max' => 8],
            [['correo'], 'email'],
            [['correo', 'lugar_contacto'], 'string', 'max' => 80],
            [['viaja_frecuente'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cliente' => 'Id Cliente',
            'id_tipo_cliente' => 'Tipo de Cliente',
            'cedula' => 'Cédula/Rif',
            'nombre_apellido' => 'Nombre y Apellido/Razón Social',
            'rif' => 'Rif',
            'razon_social' => 'Razón Social',
            'telefono_principal' => 'Teléfono Principal',
            'telefono_alterno' => 'Teléfono Alterno',
            'correo' => 'Correo',
            'id_estado' => 'Estado',
            'id_municipio' => 'Municipio',
            'id_parroquia' => 'Parroquia',
            'direccion' => 'Dirección',
            'empresa' => 'Empresa',
            'id_referido' => 'Referido',
            'lugar_contacto' => '¿Desde dónde nos contacta?',
            'id_nos_conoce' => '¿De donde nos Conoce?',
            'fecha_cumpleanos' => 'Fecha de cumpleaños',
            'viaja_frecuente' => 'Viaja con frecuente',
            'recibir_correo' => 'Recibir Correo, Whatsapp',
            'cliente_grato' => 'Cliente no grato',
            'id_categoria' => 'Categoría',
            'id_proyecto' => 'Proyecto',
            'id_usuario' => 'Id Usuario',
            'fecha_registro' => 'Fecha Registro',
            'esreferido' => '¿Cliente referido?',
            'observacion' => 'Observación',
            'nuevo' => 'Nuevo',
            'mismapersona' => 'Copiar contacto',
            'cedula_rif_serv' => 'Cédula/RIF',
        ];
    }
}
