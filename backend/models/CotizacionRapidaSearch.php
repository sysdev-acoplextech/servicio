<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CotizacionRapida;

/**
 * CotizacionRapidaSearch represents the model behind the search form of `\backend\models\CotizacionRapida`.
 */
class CotizacionRapidaSearch extends CotizacionRapida
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cotizacion', 'id_tarifario', 'id_tipo_vehiculo'], 'integer'],
            [['cliente_nombre', 'telefono', 'fecha_servicio', 'hora_servicio', 'ruta_detalle', 'forma_pago', 'adicionales_json', 'creado_el'], 'safe'],
            [['monto_base', 'monto_recargo', 'monto_viatico', 'monto_total'], 'number'],
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
        $query = CotizacionRapida::find();

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
            'id_cotizacion' => $this->id_cotizacion,
            'fecha_servicio' => $this->fecha_servicio,
            'hora_servicio' => $this->hora_servicio,
            'id_tarifario' => $this->id_tarifario,
            'id_tipo_vehiculo' => $this->id_tipo_vehiculo,
            'monto_base' => $this->monto_base,
            'monto_recargo' => $this->monto_recargo,
            'monto_viatico' => $this->monto_viatico,
            'monto_total' => $this->monto_total,
            'creado_el' => $this->creado_el,
        ]);

        $query->andFilterWhere(['like', 'cliente_nombre', $this->cliente_nombre])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'ruta_detalle', $this->ruta_detalle])
            ->andFilterWhere(['like', 'forma_pago', $this->forma_pago])
            ->andFilterWhere(['like', 'adicionales_json', $this->adicionales_json]);

        return $dataProvider;
    }
}
