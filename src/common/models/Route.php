<?php namespace common\models;

use yii\base\Model;

/**
 * Class Route
 * @package backend\models
 */
class Route extends Model
{
    /**
     * @var string Route value.
     */
    public $route;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['route'], 'safe'],
        ];
    }
}
