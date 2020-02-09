<?php
// @codingStandardsIgnoreStart
namespace buttflattery\multimenu\assetbundles\bs4;

use buttflattery\multimenu\assetbundles\bs4\ThemeBase;

class ThemeDropUpAsset extends ThemeBase
{
    // @codingStandardsIgnoreEnd

    /**
     * Inits the asset bundle for the theme
     * 
     * @return null
     */
    public function init()
    {
        //call parent
        parent::init();

        //add js theme file
        array_push(
            $this->js,
            'js/theme/dropup.js'
        );

        //add css theme files
        array_push(
            $this->css,
            'css/theme/dropup.css',
            'css/theme/dropup.bs4.css'
        );
    }
}
