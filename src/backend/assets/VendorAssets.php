<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace backend\assets;

use yii\web\AssetBundle;
use Yii;


/**
 * Class VendorAssets
 * @package backend\assets
 */
class VendorAssets extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
        'icheck/skins/square/orange.css'
    ];
    public $js = [
        'slimscroll/jquery.slimscroll.min.js',
        'fastclick/lib/fastclick.js',
        'icheck/icheck.min.js',
        'bootbox/bootbox.js'
    ];

    public function registerAssetFiles($view)
    {
        parent::registerAssetFiles($view);
    }
}
