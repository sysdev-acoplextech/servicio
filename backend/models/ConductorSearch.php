<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Conductor;

/**
 * ConductorSearch represents the model behind the search form of `\backend\models\Conductor`.
 */
class ConductorSearch extends Conductor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estatus', 'id_usuario'], 'integer'],
            [['cedula', 'nacionalidad', 'nombres', 'apellidos', 'telefono_principal', 'telefono_alterno', 'correo', 'fecha_ingreso', 'fecha_egreso', 'foto'], 'safe'],
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
        $query = Conductor::find();

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
            'fecha_ingreso' => $this->fecha_ingreso,
            'fecha_egreso' => $this->fecha_egreso,
            'estatus' => $this->estatus,
            'id_usuario' => $this->id_usuario,
        ]);

        $query->andFilterWhere(['like', 'cedula', $this->cedula])
            ->andFilterWhere(['like', 'nacionalidad', $this->nacionalidad])
            ->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'telefono_principal', $this->telefono_principal])
            ->andFilterWhere(['like', 'telefono_alterno', $this->telefono_alterno])
            ->andFilterWhere(['like', 'correo', $this->correo])
            ->andFilterWhere(['like', 'foto', $this->foto]);

        return $dataProvider;
    }
}
