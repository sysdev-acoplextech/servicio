<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "categoria_cliente".
 *
 * @property int $id_categoria
 * @property string $nombre_categoria
 * @property int $desde_viajes
 * @property int $hasta_viajes
 * @property string $descripcion
 * @property int $estatus
 */
class CategoriaCliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categoria_cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_categoria', 'desde_viajes', 'hasta_viajes', 'descripcion'], 'required'],
            [['desde_viajes', 'hasta_viajes', 'estatus'], 'integer'],
            [['nombre_categoria'], 'string', 'max' => 50],
            [['descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_categoria' => 'Id Categoria',
            'nombre_categoria' => 'Nombre de la Categoría',
            'desde_viajes' => 'Desde Viajes',
            'hasta_viajes' => 'Hasta Viajes',
            'descripcion' => 'Descripción',
            'estatus' => 'Estatus',
        ];
    }
}
