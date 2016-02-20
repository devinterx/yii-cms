<?php namespace backend;

use Yii;
use yii\base\Module as BaseModule;
use yii\helpers\ArrayHelper;

class Module extends BaseModule
{
    public $defaultRoute = 'dashboard';

    public $layout = 'main';
    public $layoutPath = __DIR__ . '/views/layouts';
    public $viewPath = __DIR__ . '/views';

    public function init()
    {
        parent::init();

        $config = ArrayHelper::merge(
            require(__DIR__ . '/config/main.php'),
            require(__DIR__ . '/config/main-local.php')
        );

        Yii::configure($this, $config);
        $this->registerTranslations();
        $this->registerErrorAction();
        $this->registerLoginAction();
    }

    public function registerLoginAction()
    {
        Yii::$app->user->enableAutoLogin = true;
        Yii::$app->user->loginUrl = ['admin/security/login'];
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['acp*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@backend/messages',
        ];
    }

    public function registerErrorAction()
    {
        Yii::$app->errorHandler->errorAction = 'admin/security/error';
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/admin/' . $category, $message, $params, $language);
    }
}
