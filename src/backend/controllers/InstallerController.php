<?php namespace backend\controllers;

use backend\models\InstalledModules;
use backend\models\search\InstalledModulesSearch;
use backend\Module;
use common\components\dependencies\FolderDependency;
use Yii;
use yii\web\Controller;

class InstallerController extends Controller
{
    private $modulesPath;

    public function init()
    {
        parent::init();

        /** @var Module $module */
        $module = Yii::$app->getModule('admin');
        $this->modulesPath = dirname($module->modulePath) . '/modules';
    }

    public function actionIndex()
    {
        $searchModel = new InstalledModulesSearch();
        $this->checkModulesFromFolder($searchModel);

        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * @param InstalledModulesSearch $searchModel
     * @return array
     */
    private function checkModulesFromFolder($searchModel)
    {
        $directories = scandir($this->modulesPath);
        $result = Yii::$app->cache->get('installer-modules-in-folder');

        if (!$result) {
            $result = [];
            foreach ($directories as $directory) {
                if ($directory !== '..' && $directory !== '.' && $this->checkForInstaller($directory)) {
                    $result[] = $directory;
                }
            }
            Yii::$app->cache->set('installer-modules-in-folder', $result, 0, new FolderDependency([
                'folder' => $this->modulesPath
            ]));

            $installed = $searchModel->getListModules();
            foreach ($installed as $module) {
                if (in_array($module['folder'], $result)) {
                    $this->checkModuleForUpdate($module['folder'], $module['version']);
                } else {
                    $this->addModuleToDelete($module['folder']);
                }
                if (($key = array_search($module['folder'], $result)) !== false) {
                    unset($result[$key]);
                }
            }
            foreach ($result as $module) {
                $this->addModuleToInstall($module);
            }
        }
        return $result;
    }

    private function checkForInstaller($module)
    {
        if (file_exists($this->modulesPath . '/' . $module . '/Install.php')
            && !is_dir($this->modulesPath . '/' . $module . '/Install.php')
        ) {
            return true;
        }
        return false;
    }

    private function addModuleToInstall($folder)
    {
        $moduleInfo = $this->getModuleInfo($folder);

        if ($moduleInfo && is_array($moduleInfo)) {
            $module = new InstalledModules();
            $module->folder = $folder;

            $module->title = $moduleInfo['title'];
            $module->version = $moduleInfo['version'];
            $module->status = InstalledModules::STATUS_NOT_INSTALLED;
            $module->save();

            var_dump($module->getErrors());
        }
    }

    private function checkModuleForUpdate($module, $version)
    {
        $moduleInfo = $this->getModuleInfo($module);

        if (!$moduleInfo || !is_array($moduleInfo)) {
            $module = (new InstalledModulesSearch())->findOne(['folder' => $module]);
            $module->status = InstalledModules::STATUS_MODULE_INTERRUPT;
            return $module->save();
        }

        if ($moduleInfo && is_array($moduleInfo) && version_compare($moduleInfo['version'], $version, '>')) {
            $module = (new InstalledModulesSearch())->findOne(['folder' => $module]);
            $module->status = InstalledModules::STATUS_HAS_UPDATE;
            return $module->save();
        }
        return false;
    }

    private function getModuleInfo($module)
    {
        if (is_file($this->modulesPath . '/' . $module . '/Install.php'))
            return include $this->modulesPath . '/' . $module . '/Install.php';
        return false;
    }

    private function addModuleToDelete($module)
    {
        $module = (new InstalledModulesSearch())->findOne(['folder' => $module]);
        $module->status = InstalledModules::STATUS_MODULE_INTERRUPT;
        return $module->save();
    }
}
