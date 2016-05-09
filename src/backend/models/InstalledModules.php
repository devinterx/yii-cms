<?php namespace backend\models;

use common\models\behaviors\DateTimeBehavior;
use DateTime;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%modules}}".
 *
 * @property integer $id
 * @property string $folder
 * @property string $title
 * @property string $version
 * @property integer $status
 * @property integer $image_id
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
class InstalledModules extends ActiveRecord
{
    const STATUS_NOT_INSTALLED = 0;
    const STATUS_INSTALLED = 1;
    const STATUS_HAS_UPDATE = 2;
    const STATUS_MODULE_INTERRUPT = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%modules}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            DateTimeBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['folder', 'title', 'version', 'status'], 'required'],
            [['image_id'], 'integer'],
            [['status'], 'integer', 'max' => 3],
            [['created_at', 'updated_at'], 'safe'],
            [['folder', 'title', 'version'], 'string', 'max' => 255],
        ];
    }
}
