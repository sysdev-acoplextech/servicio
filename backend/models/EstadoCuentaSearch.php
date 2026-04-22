<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EstadoCuenta;

/**
 * EstadoCuentaSearch represents the model behind the search form of `\backend\models\EstadoCuenta`.
 */
class EstadoCuentaSearch extends EstadoCuenta
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idestado_cuenta', 'operador', 'conciliado', 'eliminado', 'id_categoria'], 'integer'],
            [['fecha_transaccion', 'referencia', 'fecha_registro', 'hora', 'numero_cuenta', 'tipo_transaccion'], 'safe'],
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
        $query = EstadoCuenta::find();

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
            'idestado_cuenta' => $this->idestado_cuenta,
            'fecha_transaccion' => $this->fecha_transaccion,
            'monto' => $this->monto,
            'operador' => $this->operador,
            'fecha_registro' => $this->fecha_registro,
            'hora' => $this->hora,
            'conciliado' => $this->conciliado,
            'eliminado' => $this->eliminado,
            'id_categoria' => $this->id_categoria,
        ]);

        $query->andFilterWhere(['like', 'referencia', $this->referencia])
            ->andFilterWhere(['like', 'numero_cuenta', $this->numero_cuenta])
            ->andFilterWhere(['like', 'tipo_transaccion', $this->tipo_transaccion]);

        return $dataProvider;
    }
}
