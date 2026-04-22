<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TipoServicio;

/**
 * TipoServicioSearch represents the model behind the search form of `\backend\models\TipoServicio`.
 */
class TipoServicioSearch extends TipoServicio
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nombre_servicio'], 'safe'],
            [['estatus'], 'boolean'],
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
        $query = TipoServicio::find()->orderBy(['nombre_servicio'=>SORT_ASC]);

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

        $query->andFilterWhere(['ilike', 'nombre_servicio', $this->nombre_servicio]);

        return $dataProvider;
    }
}
