<?php


namespace backend\models;

use backend\models\User;
use mdm\admin\components\Configs;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * UserSearch represents the model behind the search form of `backend\models\User`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'activate', 'id_role', 'cedula'], 'integer'],
            [[
                'username',
                'auth_key',
                'password_hash',
                'password_reset_token',
                'email',
                'accessToken',
                'nombres',
                'apellidos',
                'nacionalidad',
                'telefono_oficina',
                'telefono_celular',
                'cedula',
                'fecha_creado'
            ], 'safe'],
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
        $query = User::find();

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

        $manager = Configs::authManager();
        $redd = $manager->getAssignments(Yii::$app->user->id);
        $co = 0;
        foreach ($redd as $key => $value) {
            if ($value->roleName == 'admin') {
                $co = 1;
            }
        }
        if ($co == 0) {
            $pp = (new Query())->select(new Expression(' user_id::integer as user_id'))->from('auth_assignment')->where(['item_name' => 'admin']);
        } else {
            $pp = 0;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'activate' => $this->activate,
            'id_role' => $this->id_role,
            'fecha_creado' => $this->fecha_creado,
        ]);

        $query->andFilterWhere(['ilike', 'username', $this->username])
            ->andFilterWhere(['ilike', 'auth_key', $this->auth_key])
            ->andFilterWhere(['ilike', 'password_hash', $this->password_hash])
            ->andFilterWhere(['ilike', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'accessToken', $this->accessToken])
            ->andFilterWhere(['ilike', 'nombres', $this->nombres])
            ->andFilterWhere(['ilike', 'apellidos', $this->apellidos])
            ->andFilterWhere(['ilike', 'nacionalidad', $this->nacionalidad])
            ->andFilterWhere(['ilike', 'telefono_oficina', $this->telefono_oficina])
            ->andFilterWhere(['ilike', 'telefono_celular', $this->telefono_celular])
            ->andFilterWhere(['ilike', 'cedula', $this->cedula])
            ->andFilterWhere(['not in', 'id', [$pp]]);

        return $dataProvider;
    }
}
