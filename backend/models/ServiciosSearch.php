<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Servicios;

/**
 * ServiciosSearch represents the model behind the search form of `\backend\models\Servicios`.
 */
class ServiciosSearch extends Servicios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_servicio', 'id_tipo_vehiculo', 'id_tipo_traslado_ruta', 'id_cliente', 'monto', 'id_conductor', 'id_flota', 'id_estatus', 'id_usuario'], 'integer'],
            [['fecha_registro', 'fecha_servicio', 'observacion_inicial'], 'safe'],
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
    public function search($params,$tipo)
    {
        $idsAIncluir= [4,5,6,7];
        $query = Servicios::find()->where(['in', 'id_estatus', $idsAIncluir])->orderBy(['id_servicio'=>SORT_DESC]);

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
            'id_servicio' => $this->id_servicio,
            'fecha_registro' => $this->fecha_registro,
            'id_tipo_vehiculo' => $this->id_tipo_vehiculo,
            'id_tipo_traslado_ruta' => $this->id_tipo_traslado_ruta,
            'id_cliente' => $this->id_cliente,
            'fecha_servicio' => $this->fecha_servicio,
            'monto' => $this->monto,
            'id_conductor' => $this->id_conductor,
            'id_flota' => $this->id_flota,
            'id_estatus' => $this->id_estatus,
            'id_usuario' => $this->id_usuario,
            'tipo_servicio'=> $tipo,
        ]);

        $query->andFilterWhere(['like', 'observacion_inicial', $this->observacion_inicial]);

        return $dataProvider;
    }
}
