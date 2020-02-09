<?php
// @codingStandardsIgnoreStart
namespace buttflattery\multimenu\assetbundles\bs4;

use buttflattery\multimenu\assetbundles\bs4\ThemeBase;

class ThemeBigDropAsset extends ThemeBase
{
    // @codingStandardsIgnoreEnd

    /**
     * Init the assets
     *
     * @return null
     */
    public function init()
    {
        //call parent
        parent::init();

        //add js theme file
        array_push($this->js, 'js/theme/bigdrop.js');

        //add css theme files
        array_push(
            $this->css,
            'css/theme/bigdrop.css',
            'css/theme/bigdrop.bs4.css'
        );
    }
}
