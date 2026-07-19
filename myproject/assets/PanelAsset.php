<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

declare(strict_types=1);

namespace app\assets;

use yii\bootstrap5\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\View;
use yii\web\YiiAsset;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PanelAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        
        '/fontawesome/all.css',
        '/css/style.css',
        
        "panel/panel-webeto-style.css",
        'panel/css/bootstrap.min.css',
        "panel/css/global.css",
    ];
    public $js = [
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', 

        '/panel/js/panel-webeto.js',
        '/panel/js/global.js',
        '/js/jquery.min.js',
        '/js/bootstrap.bundle.min.js',
        '/js/main.js',
    ];
    public $jsOptions = [
        'position' => View::POS_END,
    ];
    public $depends = [
        YiiAsset::class,
    ];
}
