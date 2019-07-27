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
use yii\base\InvalidArgumentException as ArgException;
use yii\bootstrap4\BootstrapAsset as BS4Asset;
use yii\helpers\Html;
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
     * The selected theme
     *
     * @var mixed
     */
    public $theme = 'bigdrop';

    const THEME_BIGDROP = 'bigdrop';
    const THEME_LEFTNAV = 'leftnav';
    const THEME_DROPUP = 'dropup';

    /**
     * Supported themes
     *
     * @var array
     */
    protected $themesSupported = [
        self::THEME_BIGDROP => 'BigDrop',
        self::THEME_LEFTNAV => 'LeftNav',
        self::THEME_DROPUP => 'DropUp'
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
    }

    /**
     * Sets the options for the selected theme
     *
     * @return null
     */
    private function _setThemeOptions()
    {
        $themeSpecificOptions = [
            self::THEME_BIGDROP => function () {
                $this->submenuTemplate = "\n<ul class='menu-dropdown-icon'>\n{items}</ul>\n";
                $this->activateParents = true;
                $this->hideEmptyItems=false;
                //theme big drop
                echo Html::beginTag('div', ['class' => 'multimenu-container']);
                echo Html::beginTag('div', ['class' => 'multimenu']);
                //call the parent
                parent::run();
                echo Html::endTag('div');
                echo Html::endTag('div');
            },
            self::THEME_LEFTNAV => function () {
                $this->options = array_merge_recursive(
                    $this->options,
                    [
                        'class' => 'list',
                        'style' => 'overflow: hidden; width: inherit; height:inherit'
                    ]
                );

                $this->encodeLabels = false;
                $this->labelTemplate = '<a href="#."><i class="material-icons">donut_large</i><span>{label}</span></a>';
                $this->linkTemplate = '<a href="{url}"><i class="material-icons">donut_large</i><span>{label}</span></a>';
                $this->submenuTemplate = "\n<ul class='ml-menu'>\n{items}\n</ul>\n";

                echo Html::tag('a', '', ['href' => 'javascript:void(0)', 'class' => 'bars']);

                echo Html::beginTag('div', ['class' => 'leftnav-container', 'id' => 'leftsidebar']);
                echo Html::beginTag('div', ['class' => 'leftnav']);
                //call the parent
                parent::run();
                echo Html::endTag('div');
                echo Html::endTag('div');
                echo Html::tag('div', '', ['class' => 'overlay']);
            },
            self::THEME_DROPUP => function () {
                $this->options = array_merge_recursive(
                    $this->options,
                    [
                        'class' => 'dropup-menu',
                    ]
                );

                echo Html::tag('a', '', ['href' => 'javascript:void(0)', 'class' => 'bars']);

                
                echo Html::beginTag('div', ['class' => 'dropup']);
                //call the parent
                parent::run();
                echo Html::endTag('div');
            }
        ];

        isset($themeSpecificOptions[$this->theme]) && $themeSpecificOptions[$this->theme]();
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
        throw new ArgException('You must select the correct theme');
        return;
        // $themeAsset = __NAMESPACE__ . '\\assetbundles\\bs' .
        // $this->_bsVersion . '\\Theme' .
        // $this->themesSupported['bigdrop'] . 'Asset';
        // $themeAsset::register($view);
        // $this->theme = 'bigdrop';
        // return;
    }
}
