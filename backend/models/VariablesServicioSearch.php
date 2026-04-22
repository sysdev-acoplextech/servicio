<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\VariablesServicio;

/**
 * VariablesServicioSearch represents the model behind the search form of `\backend\models\VariablesServicio`.
 */
class VariablesServicioSearch extends VariablesServicio
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_variable', 'estatus'], 'integer'],
            [['nombre_variable', 'descripcion'], 'safe'],
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
        $query = VariablesServicio::find();

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
            'id_variable' => $this->id_variable,
            'estatus' => $this->estatus,
        ]);

        $query->andFilterWhere(['like', 'nombre_variable', $this->nombre_variable])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
