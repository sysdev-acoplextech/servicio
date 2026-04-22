<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "categoria_gastos".
 *
 * @property int $id_categoria_gasto
 * @property string $nombre_categoria
 * @property int $estatus
 * @property int $id_fondo
 */
class CategoriaGastos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categoria_gastos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estatus', 'id_fondo'], 'integer'],
            [['nombre_categoria'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_categoria_gasto' => 'Id Categoria Gasto',
            'nombre_categoria' => 'Nombre Categoria',
            'estatus' => 'Estatus',
            'id_fondo' => 'Id Fondo',
        ];
    }
}
