<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ServicioPago;

/**
 * ServicioPagoSearch represents the model behind the search form of `\backend\models\ServicioPago`.
 */
class ServicioPagoSearch extends ServicioPago
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pago', 'id_servicio', 'id_metodo', 'banco_origen'], 'integer'],
            [['fecha_pago', 'referencia', 'tipo_pago', 'procedencia', 'observacion_pago'], 'safe'],
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
        $query = ServicioPago::find();

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
            'id_pago' => $this->id_pago,
            'id_servicio' => $this->id_servicio,
            'fecha_pago' => $this->fecha_pago,
            'monto' => $this->monto,
            'id_metodo' => $this->id_metodo,
            'banco_origen' => $this->banco_origen,
        ]);

        $query->andFilterWhere(['like', 'referencia', $this->referencia])
            ->andFilterWhere(['like', 'tipo_pago', $this->tipo_pago])
            ->andFilterWhere(['like', 'procedencia', $this->procedencia])
            ->andFilterWhere(['like', 'observacion_pago', $this->observacion_pago]);

        return $dataProvider;
    }
}
