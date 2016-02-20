<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\models\behaviors;

use DateTime;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\BaseActiveRecord;

/**
 * TimestampBehavior automatically fills the specified attributes with the current timestamp.
 *
 * To use TimestampBehavior, insert the following code to your ActiveRecord class:
 *
 * ```php
 * use yii\behaviors\TimestampBehavior;
 *
 * public function behaviors()
 * {
 *     return [
 *         TimestampBehavior::className(),
 *     ];
 * }
 * ```
 *
 * By default, TimestampBehavior will fill the `created_at` and `updated_at` attributes with the current timestamp
 * when the associated AR object is being inserted; it will fill the `updated_at` attribute
 * with the timestamp when the AR object is being updated. The timestamp value is obtained by `time()`.
 *
 * If your attribute names are different or you want to use a different way of calculating the timestamp,
 * you may configure the [[createdAtAttribute]], [[updatedAtAttribute]] and [[value]] properties like the following:
 *
 * ```php
 * use yii\db\Expression;
 *
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => TimestampBehavior::className(),
 *             'createdAtAttribute' => 'create_time',
 *             'updatedAtAttribute' => 'update_time',
 *             'value' => new Expression('NOW()'),
 *         ],
 *     ];
 * }
 * ```
 *
 * In case you use an [[Expression]] object as in the example above, the attribute will not hold the timestamp value, but
 * the Expression object itself after the record has been saved. If you need the value from DB afterwards you should call
 * the [[\yii\db\ActiveRecord::refresh()|refresh()]] method of the record.
 *
 * TimestampBehavior also provides a method named [[touch()]] that allows you to assign the current
 * timestamp to the specified attribute(s) and save them to the database. For example,
 *
 * ```php
 * $model->touch('creation_time');
 * ```
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @since 2.0
 */
class DateTimeBehavior extends Behavior
{
    /**
     * @var string the attribute that will receive timestamp value
     * Set this property to false if you do not want to record the creation time.
     */
    public $createdAtAttribute = 'created_at';
    /**
     * @var string the attribute that will receive timestamp value.
     * Set this property to false if you do not want to record the update time.
     */
    public $updatedAtAttribute = 'updated_at';
    /**
     * @var array list of attributes that are to be automatically filled with the value specified via [[value]].
     * The array keys are the ActiveRecord events upon which the attributes are to be updated,
     * and the array values are the corresponding attribute(s) to be updated. You can use a string to represent
     * a single attribute, or an array to represent a list of attributes. For example,
     *
     * ```php
     * [
     *     ActiveRecord::EVENT_BEFORE_INSERT => ['attribute1', 'attribute2'],
     *     ActiveRecord::EVENT_BEFORE_UPDATE => 'attribute2',
     * ]
     * ```
     */
    public $attributes = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->createdAtAttribute, $this->updatedAtAttribute],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => [$this->createdAtAttribute, $this->updatedAtAttribute],
                BaseActiveRecord::EVENT_AFTER_FIND => [$this->createdAtAttribute, $this->updatedAtAttribute]
            ];
        }
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return array_fill_keys(array_keys($this->attributes), 'evaluateAttributes');
    }

    /**
     * Evaluates the attribute value and assigns it to the current attributes.
     * @param Event $event
     */
    public function evaluateAttributes($event)
    {
        if (!empty($this->attributes[$event->name])) {
            $attributes = (array)$this->attributes[$event->name];

            foreach ($attributes as $attribute) {
                if ($this->owner->hasAttribute($attribute)) {
                    $this->owner->$attribute = $this->getValue($event, $attribute);
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    protected function getValue($event, $attribute = null)
    {
        if ($event->name == BaseActiveRecord::EVENT_AFTER_FIND) {
            if (null !== $this->owner->$attribute)
                return new DateTime($this->owner->$attribute);
        } elseif ($event->name == BaseActiveRecord::EVENT_BEFORE_UPDATE || $event->name == BaseActiveRecord::EVENT_BEFORE_INSERT) {
            if ($event->name == BaseActiveRecord::EVENT_BEFORE_UPDATE) {
                if ($attribute == $this->updatedAtAttribute) {
                    $this->owner->$attribute = new Datetime();
                }
            }
            if ($this->owner->hasAttribute($attribute)) {
                if (null === $this->owner->$attribute) {
                    return (new Datetime())->format("Y-m-d H:i:s");
                } elseif ($this->owner->$attribute instanceof DateTime) {
                    return $this->owner->$attribute->format("Y-m-d H:i:s");
                }
            }
        }
        return null;
    }

    /**
     * Updates a timestamp attribute to the current timestamp.
     *
     * ```php
     * $model->touch('lastVisit');
     * ```
     * @param string $attribute the name of the attribute to update.
     */
    public function touch($attribute)
    {
        $this->owner->updateAttributes(array_fill_keys((array)$attribute, new Datetime()));
    }
}
