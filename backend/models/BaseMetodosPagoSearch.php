<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BaseMetodosPago;

/**
 * BaseMetodosPagoSearch represents the model behind the search form of `\backend\models\BaseMetodosPago`.
 */
class BaseMetodosPagoSearch extends BaseMetodosPago
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_metodo'], 'integer'],
            [['nombre_metodo', 'num_cuenta', 'banco', 'telefono', 'identificacion'], 'safe'],
            [['estatus'], 'boolean'],
            [['email'], 'email'],
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
        $query = BaseMetodosPago::find()->orderBy(['nombre_metodo'=>SORT_ASC]);

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
            'id_metodo' => $this->id_metodo,
            'estatus' => $this->estatus,
        ]);

        $query->andFilterWhere(['ilike', 'nombre_metodo', $this->nombre_metodo])
            ->andFilterWhere(['ilike', 'num_cuenta', $this->num_cuenta])
            ->andFilterWhere(['ilike', 'banco', $this->banco])
            ->andFilterWhere(['ilike', 'telefono', $this->telefono])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'identificacion', $this->identificacion]);

        return $dataProvider;
    }
}
