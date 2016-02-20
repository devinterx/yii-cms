<?php namespace backend\models\search;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class AuthRule
 * @package backend\models\search
 */
class UserSearch extends User
{
    public $email;
    public $created_at;

    public function rules()
    {
        return [
            ['email', 'safe'],
            ['created_at', 'safe'],
            ['created_at', 'date', 'format' => 'Y-m-d']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'created_at', $this->created_at]);

        $query->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
