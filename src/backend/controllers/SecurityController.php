<?php
namespace backend\controllers;

use backend\components\AcpSecurityController;
use backend\models\LoginForm;
use backend\models\PasswordResetRequestForm;
use backend\models\RegisterForm;
use backend\models\ResetPasswordForm;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;

/**
 * Security controller
 */
class SecurityController extends AcpSecurityController
{
    public $defaultAction = 'login';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'login', 'register', 'request-password', 'reset-password', 'error', 'test'
                        ],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            /*
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ]
            */
        ];
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegister()
    {
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->register()) {
                if ($user->getId() == 1) {
                    $auth = Yii::$app->authManager;
                    $role = $auth->getRole('admin');
                    $auth->assign($role, $user->getId());
                }
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionRequestPassword()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('acp', 'Check your email for further instructions.'));
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('acp', 'Sorry, we are unable to reset password for email provided.'));
            }
        }

        return $this->render('request-password', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('acp', 'New password was saved.'));
            return $this->goHome();
        }

        return $this->render('reset-password', [
            'model' => $model,
        ]);
    }
}
