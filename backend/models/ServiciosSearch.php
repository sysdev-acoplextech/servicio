<?php

namespace backend\models;

use Yii;
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
     * @param int|null $tipo (Opcional para evitar errores de argumentos)
     *
     * @return ActiveDataProvider
     */
    public function search($params, $tipo = null)
    {
        // Definimos los estatus que queremos incluir por defecto en la vista principal
        $idsAIncluir = [4, 5, 6, 7, 11];
        
        $query = Servicios::find()
            ->where(['in', 'id_estatus', $idsAIncluir])
            ->orderBy(['id_servicio' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20, // Ajusta según prefieras
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Si la validación falla, retornamos el dataProvider sin filtrar para no romper la vista
            return $dataProvider;
        }

        // Condiciones de filtrado del Grid y Botones
        $query->andFilterWhere([
            'id_servicio' => $this->id_servicio,
            'fecha_registro' => $this->fecha_registro,
            'id_tipo_vehiculo' => $this->id_tipo_vehiculo,
            'id_tipo_traslado_ruta' => $this->id_tipo_traslado_ruta,
            'id_cliente' => $this->id_cliente,
            'fecha_servicio' => $this->fecha_servicio, // Filtro para "Hoy"
            'id_conductor' => $this->id_conductor,
            'id_flota' => $this->id_flota,
            'id_estatus' => $this->id_estatus, // Filtro para botones de estatus
            'id_usuario' => $this->id_usuario,
        ]);

        // Manejo de Montos: Si se filtra por monto, podrías necesitar limpiar el formato aquí 
        // si el usuario escribe con puntos/comas en el filtro del Grid.
        if (!empty($this->monto)) {
             $query->andFilterWhere(['monto' => $this->monto]);
        }

        // Filtro por tipo_servicio solo si se pasa el argumento
        if ($tipo !== null) {
            $query->andFilterWhere(['tipo_servicio' => $tipo]);
        }

        $query->andFilterWhere(['like', 'observacion_inicial', $this->observacion_inicial]);

        return $dataProvider;
    }
}