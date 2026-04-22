<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PasajeroServicio;

/**
 * PasajeroServicioSearch represents the model behind the search form of `\backend\models\PasajeroServicio`.
 */
class PasajeroServicioSearch extends PasajeroServicio
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pax_servicio', 'id_servicio'], 'integer'],
            [['hora', 'origen', 'destino', 'fecha'], 'safe'],
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
        $query = PasajeroServicio::find();

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
            'id_pax_servicio' => $this->id_pax_servicio,
            'id_servicio' => $this->id_servicio,
            'hora' => $this->hora,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'origen', $this->origen])
            ->andFilterWhere(['like', 'destino', $this->destino]);

        return $dataProvider;
    }
}
