<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CierreDiario;

/**
 * CierreDiarioSearch represents the model behind the search form of `\backend\models\CierreDiario`.
 */
class CierreDiarioSearch extends CierreDiario
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idcierre', 'id_operador'], 'integer'],
            [['fecha_cierre', 'numero_cuenta', 'observaciones'], 'safe'],
            [['saldo_sistema', 'saldo_bancario', 'diferencia'], 'number'],
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
        $query = CierreDiario::find();

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
            'idcierre' => $this->idcierre,
            'fecha_cierre' => $this->fecha_cierre,
            'saldo_sistema' => $this->saldo_sistema,
            'saldo_bancario' => $this->saldo_bancario,
            'diferencia' => $this->diferencia,
            'id_operador' => $this->id_operador,
        ]);

        $query->andFilterWhere(['like', 'numero_cuenta', $this->numero_cuenta])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
