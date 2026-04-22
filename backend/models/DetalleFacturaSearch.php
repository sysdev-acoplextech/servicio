<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DetalleFactura;

/**
 * DetalleFacturaSearch represents the model behind the search form of `backend\models\DetalleFactura`.
 */
class DetalleFacturaSearch extends DetalleFactura
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_detallefactura',  'pagada'], 'integer'],
            [['num_factura', 'fecha_factura', 'observacion', 'id_servicios', 'fecha_emision'], 'safe'],
            [['monto_facturado', 'subtotal', 'iva', 'tasa_dia', 'monto_bs'], 'number'],
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
    public function search($params, $id_cliente)
    {
        $query = DetalleFactura::find();

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
            'id_detallefactura' => $this->id_detallefactura,
            'fecha_factura' => $this->fecha_factura,
            'monto_facturado' => $this->monto_facturado,
            'subtotal' => $this->subtotal,
            'iva' => $this->iva,
            'tasa_dia' => $this->tasa_dia,
            'fecha_emision' => $this->fecha_emision,
            'monto_bs' => $this->monto_bs,
            'id_cliente' => $id_cliente,
            'pagada' => $this->pagada,
        ]);

        $query->andFilterWhere(['like', 'num_factura', $this->num_factura])
            ->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'id_servicios', $this->id_servicios]);

        return $dataProvider;
    }
}
