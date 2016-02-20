<?php namespace backend\controllers;

use common\models\AuthItem;
use Yii;
use common\models\AuthRule;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\search\AuthRule as AuthRuleSearch;
use yii\web\NotFoundHttpException;

/**
 * Class RuleController
 * @package backend\controllers
 */
class RuleController extends Controller
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
                        'roles' => ['BViewRules'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['BCreateRules'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['BDeleteRules'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['BUpdateRules'],
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $action->controller->redirect(Url::toRoute('dashboard/dashboard'));
                }
            ]
        ];
    }

    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthRuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthRule(null);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->name]);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param  string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->name]);
        }

        return $this->render('update', ['model' => $model,]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Yii::$app->authManager->remove($model->item);
        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $item = Yii::$app->authManager->getRule($id);
        if ($item) {
            return new AuthRule($item);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
