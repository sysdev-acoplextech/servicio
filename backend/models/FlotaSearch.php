<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Flota;

/**
 * FlotaSearch represents the model behind the search form of `\backend\models\Flota`.
 */
class FlotaSearch extends Flota
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_tipo_vehiculo', 'id_condicion', 'id_estado', 'id_municipio', 'id_parroquia', 'id_usuario','id_marca', 'id_modelo'], 'integer'],
            [['tercerizado', 'asignado'], 'boolean'],
            [['foto1', 'foto2','color','foto_rcv', ], 'string'],
            [['placa', 'gerencia', 'nombre_gerente', 'fecha_asignacion', 'fecha_registro','fecha_vencimiento_rcv'], 'safe'],
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
        $query = Flota::find();

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
            'id_tipo_vehiculo' => $this->id_tipo_vehiculo,
            'id_condicion' => $this->id_condicion,
            'tercerizado' => $this->tercerizado,
            'id_marca' => $this->id_marca,
            'id_modelo' => $this->id_modelo,
            'id_estado' => $this->id_estado,
            'id_municipio' => $this->id_municipio,
            'id_parroquia' => $this->id_parroquia,
            'asignado' => $this->asignado,
            'fecha_vencimiento_rcv' => $this->fecha_vencimiento_rcv,
            'fecha_registro' => $this->fecha_registro,
            'id_usuario' => $this->id_usuario,
        ]);

        $query->andFilterWhere(['ilike', 'placa', $this->placa])
            ->andFilterWhere(['ilike', 'gerencia', $this->gerencia])
            ->andFilterWhere(['ilike', 'color', $this->color]);

        return $dataProvider;
    }
}
