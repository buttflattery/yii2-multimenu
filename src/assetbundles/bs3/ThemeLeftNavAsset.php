<?php
namespace buttflattery\multimenu\assetbundles\bs3;

use buttflattery\multimenu\assetbundles\bs3\ThemeBase;

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
            'js/theme/leftnav.min.js'
        );

        //add css theme files
        array_push(
            $this->css,
            'css/theme/leftnav.css',
            '//fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext'
        );
    }
}
