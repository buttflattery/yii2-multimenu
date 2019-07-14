<?php
namespace buttflattery\multimenu\assetbundles\bs3;

use buttflattery\multimenu\assetbundles\bs3\ThemeBase;

class ThemeBigDropAsset extends ThemeBase
{
    /**
     * Css files associated with the theme
     *
     * @var array
     */
    public $css = [
        'ionicons.css',
        'css/theme/bigdrop.css'
    ];

    public function init()
    {
        parent::init();
        array_push($this->js, 'js/theme/bigdrop.js');
    }
}
