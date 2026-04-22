<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cliente_proyecto".
 *
 * @property int $id_cliente_proyecto
 * @property string $nombre_autorizada_servicio
 * @property string $telefono_p_autorizada_servicio
 * @property string $telefono_a_autorizada_servicio
 * @property string $correo_persona_autorizada
 * @property string $cargo
 * @property string $nombre_contacto_paga
 * @property string $telefono_p_paga
 * @property string $telefono_a_paga
 * @property string $correo_paga
 * @property string $cargo_paga
 * @property string $correo_envio_retenciones
 */
class ClienteProyecto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cliente_proyecto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           
            [['nombre_autorizada_servicio', 'correo_persona_autorizada', 'nombre_contacto_paga', 'correo_paga', 'correo_envio_retenciones'], 'string', 'max' => 80],
            [['telefono_p_autorizada_servicio', 'telefono_a_autorizada_servicio', 'telefono_p_paga', 'telefono_a_paga'], 'string', 'max' => 11],
            [['cargo', 'cargo_paga'], 'string', 'max' => 50],
            [['correo_persona_autorizada', 'correo_paga'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cliente_proyecto' => 'Id Cliente Proyecto',
            'nombre_autorizada_servicio' => 'Nombre y apellido',
            'telefono_p_autorizada_servicio' => 'Teléfono principal',
            'telefono_a_autorizada_servicio' => 'Teléfono alterno',
            'correo_persona_autorizada' => 'Correo',
            'cargo' => 'Cargo ',
            'nombre_contacto_paga' => 'Nombre y apellido',
            'telefono_p_paga' => 'Teléfono principal',
            'telefono_a_paga' => 'Teléfono alterno',
            'correo_paga' => 'Correo',
            'cargo_paga' => 'Cargo',
            'correo_envio_retenciones' => 'Correo para el envío de las retenciones',
        ];
    }
}
