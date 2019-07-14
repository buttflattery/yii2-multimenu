<?php
/**
 * PHP VERSION >=5.6
 *
 * @category  Yii2-Plugin
 * @package   Yii2-multimenu
 * @author    Muhammad Omer Aslam <buttflattery@gmail.com>
 * @copyright 2018 IdowsTECH
 * @license   https://github.com/buttflattery/yii2-multimenu/blob/master/LICENSE BSD License 3.01
 * @link      https://github.com/buttflattery/yii2-multimenu
 */

namespace buttflattery\multimenu;

use buttflattery\multimenu\assetbundles\bs3\MultiMenuAsset as MenuBs3Assets;
use buttflattery\multimenu\assetbundles\bs4\MultiMenuAsset as MenuBs4Assets;
use yii\bootstrap4\BootstrapAsset as BS4Asset;
use yii\widgets\Menu;

/**
 * A yii2 widget to create multiple style menus either top navigation menu or side navigation
 * it uses multiple themes like bootstrap and material design theme.
 *
 * @category  Yii2-Plugin
 * @package   Yii2-multimenu
 * @author    Muhammad Omer Aslam <buttflattery@gmail.com>
 * @copyright 2018 IdowsTECH
 * @license   https://github.com/buttflattery/yii2-multimenu/blob/master/LICENSE BSD License 3.01
 * @version   Release: 1.0
 * @link      https://github.com/buttflattery/yii2-multimenu
 */
class MultiMenu extends Menu
{

    /**
     * The Bootstrap Version to be loaded for the extension
     *
     * @var mixed
     */
    private $_bsVersion;

    /**
     * @var mixed
     */
    public $theme;

    const THEME_BIGDROP = 'bigdrop';

    /**
     * @var array
     */
    protected $themesSupported = [
        self::THEME_BIGDROP => 'BigDrop'
    ];

    /**
     * Initializes the plugin
     *
     * @return null
     */
    public function run()
    {
        //sets the defaults for the extension
        $this->_setDefaults();

        //registers the plugin assets
        $this->registerAssets();

        //set the theme option
        $this->_setThemeOptions();

        //call the parent
        parent::run();
    }

    public function _setThemeOptions(){
        echo $this->theme;
    }

    /**
     * Sets the defaults for the widget and detects to
     * use which version of Bootstrap.
     *
     * @return null
     * @throws ArgException
     */
    private function _setDefaults()
    {
        //is bs4 version
        $isBs4 = class_exists(BS4Asset::class);
        $this->_bsVersion = $isBs4 ? 4 : 3;
    }

    /**
     * Registers the necessary AssetBundles for the widget
     *
     * @return null
     */
    public function registerAssets()
    {
        $view = $this->getView();

        //register theme specific files
        $themeSelected = $this->theme;

        //is supported theme
        if (in_array($themeSelected, array_keys($this->themesSupported))) {
            $themeAsset = __NAMESPACE__ . '\assetbundles\bs' .
            $this->_bsVersion . '\Theme' .
            $this->themesSupported[$themeSelected] . 'Asset';
            $themeAsset::register($view);
            return;
        }
        $themeAsset = __NAMESPACE__ . '\assetbundles\bs' .
        $this->_bsVersion . '\Theme' .
        $this->themesSupported['bigdrop'] . 'Asset';
        $themeAsset::register($view);
    }
}
