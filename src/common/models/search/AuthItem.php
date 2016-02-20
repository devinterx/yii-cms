<?php namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\rbac\Item;
use yii\rbac\ManagerInterface as Manager;

/**
 * Class AuthItem
 * @package common\models\search
 */
class AuthItem extends Model
{

    const TYPE_ROUTE = 101;

    public $name;
    public $type;
    public $description;
    public $rule;
    public $data;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description',], 'safe'],
            [['type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('acp', 'Name'),
            'item_name' => Yii::t('acp', 'Name'),
            'type' => Yii::t('acp', 'Type'),
            'description' => Yii::t('acp', 'Description'),
            'ruleName' => Yii::t('acp', 'Rule Name'),
            'data' => Yii::t('acp', 'Data'),
        ];
    }

    /**
     * Search authitem
     * @param array $params
     * @return \yii\data\ActiveDataProvider|\yii\data\ArrayDataProvider
     */
    public function search($params)
    {
        /* @var Manager $authManager */
        $authManager = Yii::$app->authManager;
        if ($this->type == Item::TYPE_ROLE) {
            $items = $authManager->getRoles();
        } else {
            $items = [];
            if ($this->type == Item::TYPE_PERMISSION) {
                foreach ($authManager->getPermissions() as $name => $item) {
                    if ($name[0] !== '/') {
                        $items[$name] = $item;
                    }
                }
            } else {
                foreach ($authManager->getPermissions() as $name => $item) {
                    if ($name[0] === '/') {
                        $items[$name] = $item;
                    }
                }
            }
        }
        if ($this->load($params) && $this->validate() && (trim($this->name) !== '' || trim($this->description) !== '')) {
            $search = strtolower(trim($this->name));
            $desc = strtolower(trim($this->description));
            $items = array_filter($items, function ($item) use ($search, $desc) {
                return (empty($search) || strpos(strtolower($item->name), $search) !== false) && (empty($desc) || strpos(strtolower($item->description), $desc) !== false);
            });
        }

        return new ArrayDataProvider([
            'allModels' => $items,
        ]);
    }

}
