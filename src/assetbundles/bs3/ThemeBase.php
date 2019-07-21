<?php
namespace buttflattery\multimenu\assetbundles\bs3;

use yii\web\AssetBundle;

class ThemeBase extends AssetBundle
{
    /**
     * Source path to look for the assets
     *
     * @var mixed
     */
    public $sourcePath = __DIR__ . '/../../assets/';

    /**
     * Base url for the assets
     *
     * @var string
     */
    public $baseUrl = '@web';

    /**
     * @var array
     */
    public $css = [
        'ionicons.css',
        'waves.css'
    ];

    /**
     * Js bundle used
     *
     * @var array
     */
    public $js = [
        'waves.js',
        'modernizer.js'
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
