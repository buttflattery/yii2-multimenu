<?php
// @codingStandardsIgnoreStart
namespace buttflattery\multimenu\assetbundles\bs4;

use yii\web\AssetBundle;

class ThemeBase extends AssetBundle
{
    // @codingStandardsIgnoreStart
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
        'waves.css',
        'animate.css',
        'root-color-schemes.css'
    ];

    /**
     * Js bundle used
     *
     * @var array
     */
    public $js = [
        'waves.js',
        'modernizer.js',
        'merge-helper.js'
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset'
    ];
}
