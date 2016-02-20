<?php namespace backend\controllers;

use common\models\User;
use Yii;
use common\models\search\Assignment as AssignmentSearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use yii\web\Response;
use yii\rbac\Item;

/**
 * Class AssignmentController
 * @package backend\controllers
 */
class AssignmentController extends Controller
{
    public $userClassName;
    public $idField = 'id';
    public $emailField = 'email';
    public $searchClass;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['BViewAssignments'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view', 'assign', 'roleSearch'],
                        'roles' => ['BUpdateAssignments'],
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $action->controller->redirect(Url::toRoute('dashboard/dashboard'));
                }
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->userClassName === null) {
            $this->userClassName = Yii::$app->getUser()->identityClass;
            $this->userClassName = $this->userClassName ?: 'common\models\User';
        }
    }

    /**
     * Lists all Assignment models.
     * @return mixed
     */
    public function actionIndex()
    {

        if ($this->searchClass === null) {
            $searchModel = new AssignmentSearch;
        } else {
            $class = $this->searchClass;
            $searchModel = new $class;
        }

        $dataProvider = $searchModel->search(\Yii::$app->request->getQueryParams(), $this->userClassName, $this->emailField);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'idField' => $this->idField,
            'emailField' => $this->emailField,
        ]);
    }

    /**
     * Displays a single Assignment model.
     * @param  integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $authManager = Yii::$app->authManager;
        $available = [];
        $assigned = [];
        foreach ($authManager->getRolesByUser($id) as $role) {
            $type = $role->type;
            $assigned[$type == Item::TYPE_ROLE ? 'Roles' : 'Permissions'][$role->name] = $role->name;
        }
        foreach ($authManager->getRoles() as $role) {
            if (!isset($assigned['Roles'][$role->name])) {
                $available['Roles'][$role->name] = $role->name;
            }
        }
        /*foreach ($authManager->getPermissions() as $role) {
            if ($role->name[0] !== '/' && !isset($assigned['Permissions'][$role->name])) {
                $available['Permissions'][$role->name] = $role->name;
            }
        }*/

        return $this->render('view', [
            'model' => $model,
            'available' => $available,
            'assigned' => $assigned,
            'idField' => $this->idField,
            'emailField' => $this->emailField,
        ]);
    }

    /**
     * Assign or revoke assignment to user
     * @param  integer $id
     * @param  string $action
     * @return mixed
     */
    public function actionAssign($id, $action)
    {
        $post = Yii::$app->request->post();
        $roles = $post['roles'];
        $manager = Yii::$app->authManager;
        $error = [];
        if ($action == 'assign') {
            foreach ($roles as $name) {
                try {
                    $item = $manager->getRole($name);
                    $item = $item ?: $manager->getPermission($name);
                    $manager->assign($item, $id);
                } catch (\Exception $exc) {
                    $error[] = $exc->getMessage();
                }
            }
        } else {
            foreach ($roles as $name) {
                try {
                    $item = $manager->getRole($name);
                    $item = $item ?: $manager->getPermission($name);
                    $manager->revoke($item, $id);
                } catch (\Exception $exc) {
                    $error[] = $exc->getMessage();
                }
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;

        return [$this->actionRoleSearch($id, 'available', $post['search_av']),
            $this->actionRoleSearch($id, 'assigned', $post['search_asgn']),
            $error];
    }

    /**
     * Search roles of user
     * @param  integer $id
     * @param  string $target
     * @param  string $term
     * @return string
     */
    public function actionRoleSearch($id, $target, $term = '')
    {
        $authManager = Yii::$app->authManager;
        $available = [];
        $assigned = [];
        foreach ($authManager->getRolesByUser($id) as $role) {
            $type = $role->type;
            $assigned[$type == Item::TYPE_ROLE ? 'Roles' : 'Permissions'][$role->name] = $role->name;
        }
        foreach ($authManager->getRoles() as $role) {
            if (!isset($assigned['Roles'][$role->name])) {
                $available['Roles'][$role->name] = $role->name;
            }
        }
        /*
        foreach ($authManager->getPermissions() as $role) {
            if ($role->name[0] !== '/' && !isset($assigned['Permissions'][$role->name])) {
                $available['Permissions'][$role->name] = $role->name;
            }
        }
        */

        $result = [];
        $var = ${$target};
        if (!empty($term)) {
            foreach (['Roles', 'Permissions'] as $type) {
                if (isset($var[$type])) {
                    foreach ($var[$type] as $role) {
                        if (strpos($role, $term) !== false) {
                            $result[$type][$role] = $role;
                        }
                    }
                }
            }
        } else {
            $result = $var;
        }

        return Html::renderSelectOptions('', $result);
    }

    /**
     * Finds the Assignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer $id
     * @return null|\yii\web\IdentityInterface|static
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /** @var User $class */
        $class = $this->userClassName;
        if (($model = $class::findIdentity($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
