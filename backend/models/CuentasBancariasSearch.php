<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CuentasBancarias;

/**
 * CuentasBancariasSearch represents the model behind the search form of `\backend\models\CuentasBancarias`.
 */
class CuentasBancariasSearch extends CuentasBancarias
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cuentas', 'estatus', 'id_usuario', 'id_banco', 'id_tipo_moneda', 'id_tipo_cuenta'], 'integer'],
            [['numero_cuenta', 'descripcion', 'fecha_registro', 'hora', 'fecha_saldo_inicial'], 'safe'],
            [['saldo'], 'number'],
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
        $query = CuentasBancarias::find();

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
            'id_cuentas' => $this->id_cuentas,
            'estatus' => $this->estatus,
            'id_usuario' => $this->id_usuario,
            'fecha_registro' => $this->fecha_registro,
            'hora' => $this->hora,
            'id_banco' => $this->id_banco,
            'id_tipo_moneda' => $this->id_tipo_moneda,
            'id_tipo_cuenta' => $this->id_tipo_cuenta,
            'saldo' => $this->saldo,
            'fecha_saldo_inicial' => $this->fecha_saldo_inicial,
        ]);

        $query->andFilterWhere(['like', 'numero_cuenta', $this->numero_cuenta])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
