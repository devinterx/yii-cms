<?php namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use common\models\AuthRule as MAuthRule;
use common\components\RouteRule;
use yii\rbac\ManagerInterface as Manager;

/**
 * Class AuthRule
 * @package common\models\search
 */
class AuthRule extends Model
{
    /**
     * @var string name of the rule
     */
    public $name;

    public function rules()
    {
        return [
            [['name'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('acp', 'Name'),
        ];
    }

    /**
     * Search BizRule
     * @param array $params
     * @return \yii\data\ActiveDataProvider|\yii\data\ArrayDataProvider
     */
    public function search($params)
    {
        /* @var Manager $authManager */
        $authManager = Yii::$app->authManager;
        $models = [];
        $included = !($this->load($params) && $this->validate() && trim($this->name) !== '');
        foreach ($authManager->getRules() as $name => $item) {
            if ($name != RouteRule::RULE_NAME && ($included || stripos($item->name, $this->name) !== false)) {
                $models[$name] = new MAuthRule($item);
            }
        }

        return new ArrayDataProvider([
            'allModels' => $models,
        ]);
    }
}
