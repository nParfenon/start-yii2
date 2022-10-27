<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/build';

    public $css = [];
    public $js = [];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap4\BootstrapAsset',
    ];

    public function init()
    {
        $this->css[] = $this->glob('css');
        $this->js[] = $this->glob('js');
    }

    private function glob($ext)
    {
        foreach (glob("build/bundle*.$ext") as $filename) {
            return basename($filename);
        }
    }
}
