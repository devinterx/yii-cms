<?php

namespace backend\controllers;

use backend\models\search\UserSearch;
use Yii;
use common\models\User;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['BViewUsers'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['BCreateUsers'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['edit'],
                        'roles' => ['BUpdateUsers'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['BDeleteUsers'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return $action->controller->redirect(Url::toRoute('dashboard/dashboard'));
                }
            ]
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->new_password !== null) {
                $model->setPassword($model->new_password);
            }
            $model->generateAuthKey();
            if ($model->save()) {
                return $this->redirect(['user/edit', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->new_password !== null) {
                $model->setPassword($model->new_password);
            }
            $model->generateAuthKey();
            if ($model->save()) {
                return $this->redirect(['user/edit', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @throws Exception
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($id === 1) throw new Exception("You can't delete grant users?");
        if ($id != Yii::$app->user->id) {
            $this->findModel($id)->delete();
        } else {
            throw new Exception('You really wants to delete yourself?');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
