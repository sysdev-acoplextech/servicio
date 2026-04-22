<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BaseTipoVehiculo;

/**
 * BaseTipoVehiculoSearch represents the model behind the search form of `\backend\models\BaseTipoVehiculo`.
 */
class BaseTipoVehiculoSearch extends BaseTipoVehiculo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nombre_tipo_vehiculo'], 'safe'],
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
        $query = BaseTipoVehiculo::find()->orderBy(['nombre_tipo_vehiculo'=>SORT_ASC]);

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

        $query->andFilterWhere(['ilike', 'nombre_tipo_vehiculo', $this->nombre_tipo_vehiculo]);

        return $dataProvider;
    }
}
