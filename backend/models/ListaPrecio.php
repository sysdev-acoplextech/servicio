<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "lista_precio".
 *
 * @property int $id_lista
 * @property int $id_variable
 * @property double $monto
 * @property int $id_moneda
 */
class ListaPrecio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lista_precio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_variable', 'monto', 'id_moneda'], 'required'],
            [['id_variable', 'id_moneda'], 'integer'],
            [['monto'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_lista' => 'Id Lista',
            'id_variable' => 'Variable de Servicio',
            'monto' => 'Monto',
            'id_moneda' => 'Tipo de moneda',
        ];
    }

        public function getImageName()
    {
        switch ($this->id_variable) {
            case 1:
                return 'maleta.png';
            case 2:
                return 'pax.png';
            case 3:
                return 'tiempo_espera.png';
            case 4:
                return 'espera_aeropuerto.png';
            case 5:
                return 'silla_bebe.png';
            case 6:
                return 'encomienda.png';
            case 7:
                return 'mascota.png';
            default:
                return 'default.png'; // Imagen por defecto
        }
    }
    public function getAltText()
    {
        switch ($this->id_variable) {
            case 1:
                return 'Maleta';
            case 2:
                return 'Pasajero Adicional';
            case 3:
                return 'Tiempo de Espera';
            case 4:
                return 'Espera dentro Aeropuerto';
            case 5:
                return 'Silla para Bebé';
            case 6:
                return 'Encomienda';
            case 7:
                return 'Mascota';
            default:
                return 'Imagen por defecto';
        }
    }
}
