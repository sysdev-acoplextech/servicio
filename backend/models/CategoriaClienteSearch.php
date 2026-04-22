<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CategoriaCliente;

/**
 * CategoriaClienteSearch represents the model behind the search form of `\backend\models\CategoriaCliente`.
 */
class CategoriaClienteSearch extends CategoriaCliente
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_categoria', 'desde_viajes', 'hasta_viajes', 'estatus'], 'integer'],
            [['nombre_categoria', 'descripcion'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CategoriaCliente::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_categoria' => $this->id_categoria,
            'desde_viajes' => $this->desde_viajes,
            'hasta_viajes' => $this->hasta_viajes,
            'estatus' => $this->estatus,
        ]);

        $query->andFilterWhere(['like', 'nombre_categoria', $this->nombre_categoria])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
