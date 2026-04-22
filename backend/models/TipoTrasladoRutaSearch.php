<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TipoTrasladoRuta;

/**
 * TipoTrasladoRutaSearch represents the model behind the search form of `\backend\models\TipoTrasladoRuta`.
 */
class TipoTrasladoRutaSearch extends TipoTrasladoRuta
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estatus'], 'integer'],
            [['nombre_traslado_ruta'], 'safe'],
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
        $query = TipoTrasladoRuta::find();

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
            'id' => $this->id,
            'estatus' => $this->estatus,
        ]);

        $query->andFilterWhere(['like', 'nombre_traslado_ruta', $this->nombre_traslado_ruta]);

        return $dataProvider;
    }
}
