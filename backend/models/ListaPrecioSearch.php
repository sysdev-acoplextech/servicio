<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ListaPrecio;

/**
 * ListaPrecioSearch represents the model behind the search form of `\backend\models\ListaPrecio`.
 */
class ListaPrecioSearch extends ListaPrecio
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_lista', 'id_variable', 'id_moneda'], 'integer'],
            [['monto'], 'number'],
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
        $query = ListaPrecio::find();

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
            'id_lista' => $this->id_lista,
            'id_variable' => $this->id_variable,
            'monto' => $this->monto,
            'id_moneda' => $this->id_moneda,
        ]);

        return $dataProvider;
    }
}
