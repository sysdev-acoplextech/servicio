<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Cliente;

/**
 * ClienteSearch represents the model behind the search form of `\backend\models\Cliente`.
 */
class ClienteSearch extends Cliente
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
         
            [['id_tipo_cliente', 'id_estado', 'id_municipio', 'id_parroquia', 'empresa', 'id_referido', 'id_nos_conoce', 'recibir_correo', 'cliente_grato', 'id_categoria', 'id_proyecto', 'id_usuario','esreferido'], 'integer'],
            [['direccion','razon_social','observacion','nombre_apellido'], 'string'],
            [['fecha_cumpleanos', 'fecha_registro'], 'safe'],
            [['telefono_principal', 'telefono_alterno'], 'string', 'max' => 11],
            [['rif'], 'string', 'max' => 10],
            [['cedula_rif_serv'], 'string', 'max' => 10],
            [['cedula'], 'string', 'max' => 8],
            [['correo'], 'email'],
            [['correo', 'lugar_contacto'], 'string', 'max' => 80],
            [['viaja_frecuente'], 'string', 'max' => 50],
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
        $query = Cliente::find();

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
            'id_cliente' => $this->id_cliente,
            'id_tipo_cliente' => $this->id_tipo_cliente,
            'cedula' => $this->cedula,
            //'nombre_apellido' => $this->nombre_apellido,
            'rif' => $this->rif,
            'razon_social' => $this->razon_social,
            'id_estado' => $this->id_estado,
            'id_municipio' => $this->id_municipio,
            'id_parroquia' => $this->id_parroquia,
            'empresa' => $this->empresa,
            'id_referido' => $this->id_referido,
            'id_nos_conoce' => $this->id_nos_conoce,
            'fecha_cumpleanos' => $this->fecha_cumpleanos,
            'recibir_correo' => $this->recibir_correo,
            'cliente_grato' => $this->cliente_grato,
            'id_categoria' => $this->id_categoria,
            'id_proyecto' => $this->id_proyecto,
            'id_usuario' => $this->id_usuario,
            'fecha_registro' => $this->fecha_registro,
        ]);

        $query->andFilterWhere(['like', 'telefono_principal', $this->telefono_principal])
            ->andFilterWhere(['like', 'telefono_alterno', $this->telefono_alterno])
            ->andFilterWhere(['like', 'correo', $this->correo])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'lugar_contacto', $this->lugar_contacto])
            ->andFilterWhere(['like', 'nombre_apellido', $this->nombre_apellido])
            ->andFilterWhere(['like', 'viaja_frecuente', $this->viaja_frecuente]);

        return $dataProvider;
    }
}
