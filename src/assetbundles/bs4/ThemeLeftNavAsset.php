<?php
namespace buttflattery\multimenu\assetbundles\bs4;

use buttflattery\multimenu\assetbundles\bs4\ThemeBase;

class ThemeLeftNavAsset extends ThemeBase
{
    // @codingStandardsIgnoreEnd

    public function init()
    {
        //call parent
        parent::init();

        //add js theme file
        array_push(
            $this->js, 
            'js/plugins/jquery.slimscroll.js',
            'js/theme/leftnav.js'
        );

        //add css theme files
        array_push(
            $this->css,
            'css/theme/leftnav.css',
            '//fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext',
            '//fonts.googleapis.com/icon?family=Material+Icons'
        );
    }
}
