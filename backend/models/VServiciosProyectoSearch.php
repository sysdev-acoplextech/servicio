<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\VServiciosProyecto;

/**
 * VServiciosProyectoSearch represents the model behind the search form of `\backend\models\VServiciosProyecto`.
 */
class VServiciosProyectoSearch extends VServiciosProyecto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_servicio', 'id_tipo_vehiculo', 'id_tipo_traslado_ruta', 'id_cliente', 'id_tipo_cliente', 'id_estado', 'id_municipio', 'id_parroquia', 'empresa', 'id_referido', 'id_nos_conoce', 'recibir_correo', 'cliente_grato', 'id_categoria', 'id_proyecto', 'nuevo', 'km_servicio', 'monto', 'id_conductor', 'id_flota', 'id_estatus', 'id_usuario','servicios'], 'integer'],
            [['fecha_registro', 'cedula', 'nombre_apellido', 'telefono_principal', 'telefono_alterno', 'correo', 'direccion', 'lugar_contacto', 'fecha_cumpleanos', 'viaja_frecuente', 'fecha_servicio', 'observacion_inicial'], 'safe'],
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
        $query = VServiciosProyecto::find();

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
            'id_tipo_cliente' => $this->id_tipo_cliente,
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
            'nuevo' => $this->nuevo,
            'km_servicio' => $this->km_servicio,
            'monto' => $this->monto,
            'id_conductor' => $this->id_conductor,
            'id_flota' => $this->id_flota,
            'id_estatus' => $this->id_estatus,
            'id_usuario' => $this->id_usuario,
        ]);

        $query->andFilterWhere(['like', 'cedula', $this->cedula])
            ->andFilterWhere(['like', 'nombre_apellido', $this->nombre_apellido])
            ->andFilterWhere(['like', 'telefono_principal', $this->telefono_principal])
            ->andFilterWhere(['like', 'telefono_alterno', $this->telefono_alterno])
            ->andFilterWhere(['like', 'correo', $this->correo])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'lugar_contacto', $this->lugar_contacto])
            ->andFilterWhere(['like', 'viaja_frecuente', $this->viaja_frecuente])
            ->andFilterWhere(['like', 'fecha_servicio', $this->fecha_servicio])
            ->andFilterWhere(['like', 'observacion_inicial', $this->observacion_inicial]);

        return $dataProvider;
    }
}
