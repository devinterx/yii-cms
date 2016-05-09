<?php namespace common\models\behaviors;

use common\models\File;
use yii\base\Behavior;
use yii\base\Model;
use yii\db\BaseActiveRecord;
use yii\web\UploadedFile;

/**
 * Class FileUploaderBehavior
 *
 * @package common\models\behaviors
 */
class FileUploaderBehavior extends Behavior
{
    const EVENT_AFTER_FILE_SAVE = 'afterFileSave';

    /** @var Model */
    public $owner;

    /** @var string */
    public $uploadAttribute;

    /** @var string */
    public $relatedAttribute;

    /** @var string */
    public $category = 'files/others';

    /** @var boolean */
    public $unlinkOnDelete = true;

    /** @var UploadedFile */
    protected $file;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function beforeValidate()
    {
        if ($this->owner->{$this->uploadAttribute} instanceof UploadedFile) {
            $this->file = $this->owner->{$this->uploadAttribute};
            return;
        }

        $this->file = UploadedFile::getInstance($this->owner, $this->uploadAttribute);

        if (empty($this->file)) {
            $this->file = UploadedFile::getInstanceByName($this->uploadAttribute);
        }

        if ($this->file instanceof UploadedFile) {
            $this->owner->{$this->uploadAttribute} = $this->file;
        }
    }

    public function beforeSave()
    {
        if ($this->file instanceof UploadedFile) {
            $file = File::fromUploadedFile($this->file);
            $file->type = $this->category;
            $file->save();

            $this->owner->{$this->relatedAttribute} = $file;
            $this->owner->trigger(static::EVENT_AFTER_FILE_SAVE);
        }
    }

    public function afterDelete()
    {
        /** @var File $file */
        $file = $this->owner->{$this->relatedAttribute};
        
        if ($this->unlinkOnDelete && $file) {
            $file->delete();
        }
    }
}
