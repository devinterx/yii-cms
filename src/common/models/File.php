<?php namespace common\models;

use finfo;
use League\Flysystem\FilesystemInterface;
use common\models\behaviors\DateTimeBehavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use DateTime;
use Yii;

/**
 * Class File
 *
 * @property integer $id
 * @property string type
 * @property string source_name
 * @property string name
 * @property string format
 * @property integer size
 * @property DateTime $created_at
 *
 * @package common\models
 */
class File extends ActiveRecord
{
    const TYPE_OTHER_FILE = 'files/others';

    /** @var FilesystemInterface */
    protected $fs;

    /** @var resource */
    protected $content;

    public $upload_dir = 'upload';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%files}}';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->fs = Yii::$app->get('fs');
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
            [['id', 'size'], 'integer'],
            [['type', 'source_name', 'name', 'format'], 'string']
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!$this->type) {
                $this->type = self::TYPE_OTHER_FILE;
            }
            if (!$this->getIsNewRecord() && (
                    $this->isAttributeChanged('name') ||
                    $this->isAttributeChanged('type') ||
                    $this->isAttributeChanged('format'))
            ) {
                $oldPath = $this->getOldAttribute('type') . '/' . $this->getOldAttribute('name');
                if (!$this->fs->rename($oldPath, $this->getPath())) return false;
            }

            if (null !== $this->content && is_resource($this->content) &&
                $this->fs->putStream($this->getPath(), $this->content)
            ) {
                return fclose($this->content);
            }
        }

        return false;
    }


    public function beforeDelete()
    {
        if (parent::beforeDelete() && $this->fs->has($this->getPath())) {
            if (null !== $this->content && is_resource($this->content) && fclose($this->content)) {
                return $this->fs->delete($this->getPath());
            }
        }

        return false;
    }


    public function getPath()
    {
        return $this->upload_dir . '/' . $this->type . '/' . $this->name . '.' . $this->format;
    }

    public function getSizeFormatted($precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $pow = floor(($this->size ? log($this->size) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes = $this->size / pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }


    public function getContent()
    {
        $stream = $this->fs->readStream($this->getPath());
        $content = stream_get_contents($stream);
        fclose($stream);

        return $content;
    }


    public function openStream()
    {
        return $this->content = $this->fs->readStream($this->getPath());
    }


    public function closeStream()
    {
        return fclose($this->content);
    }


    static public function fromUploadedFile(UploadedFile $temp_file, $name = null)
    {
        $file = self::getNewModel();

        $file->source_name = $temp_file->name;
        $file->name = (null === $name) ? md5($temp_file->name . $temp_file->size) : strtolower(self::sanitize($name));
        $file->size = $temp_file->size;
        $file->format = strtolower($temp_file->extension);

        $file->content = fopen($temp_file->tempName, 'r+');

        return $file;
    }

    public static function fromUrl($url, $name = null)
    {
        $file = self::getNewModel();
        if ($resource = fopen($url, 'r')) {
            $temp_file = file_get_contents($url);

            $fileName = basename($url);
            $fileSize = strlen($temp_file);

            $file->source_name = $fileName;
            $file->name = (null === $name) ? md5($fileName . $fileSize) : self::sanitize(strtolower($name));
            $file->size = $fileSize;
            if (extension_loaded('fileinfo')) {
                $file->format = array_reverse(FileHelper::getExtensionsByMimeType(
                    (new finfo(FILEINFO_MIME_TYPE))->buffer($temp_file)
                ))[0];
            } else {
                $ext = pathinfo($url, PATHINFO_EXTENSION);
                $file->format = $ext ? $ext : 'dat';
            }

            $file->content = $resource;
            return $file;
        }
        return false;
    }

    public static function fromBinaryData($data, $name = null)
    {
        $file = self::getNewModel();

        return $file;
    }

    /**
     * @return File
     */
    static protected function getNewModel()
    {
        $classModel = static::class;
        return new $classModel;
    }

    static protected function sanitize($filename)
    {
        $special_chars = [
            '?', '[', ']', '/', '\\', '=', '<', '>', ':', ';', ',', '\"',
            '\'', '&', '$', '#', '*', '(', ')', '|', '~', '`', '!', '{', '}'
        ];
        $filename = str_replace($special_chars, '', $filename);
        $filename = preg_replace('/[\s-]+/', '-', $filename);
        $filename = trim($filename, '.-_');
        return $filename;
    }
}
