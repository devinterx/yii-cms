<?php namespace backend\models\search;

use backend\models\InstalledModules;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;

class InstalledModulesSearch extends InstalledModules
{
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
        $query = InstalledModules::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    public function getListModules()
    {
        return (new Query())
            ->select(['folder', 'version'])
            ->from($this->tableName())
            ->orderBy('folder DESC')
            ->all();
    }
}
