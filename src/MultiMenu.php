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

use Yii;
use yii\base\InvalidArgumentException as ArgException;
use yii\base\InvalidConfigException as CfgException;
use yii\bootstrap4\BootstrapAsset as BS4Asset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
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
     * Enable Mobile view for the menu
     *
     * @var mixed
     */
    public $mobileView = true;

    /**
     * Array of options for the plugin, see the constant array
     * MULTIMENU_DEFAULTS for the set of options you can pass into this
     *
     * @var array
     */
    public $multimenuOptions = [];

    /**
     * The text of the brand or false if it's not used. Note that this is not HTML-encoded.
     *
     * @var string|bool
     * @see https://getbootstrap.com/docs/3.3/components/#navbar
     */
    public $brandLabel = false;

    /**
     * Src of the brand image or false if it's not used. Note that this param will override `$this->brandLabel` param.
     *
     * @var string|bool
     * @see https://getbootstrap.com/docs/3.3/components/#navbar
     */
    public $brandImage = false;

    /**
     * The URL for the brand's hyperlink tag. This parameter will be processed by [[\yii\helpers\Url::to()]]
     * and will be used for the "href" attribute of the brand link. Default value is false that means
     * [[\yii\web\Application::homeUrl]] will be used.
     * You may set it to `null` if you want to have no link at all.
     *
     * @var array|string|bool
     */
    public $brandUrl = false;

    /**
     * The HTML attributes of the brand link.
     *
     * @var array
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $brandOptions = [];

    /**
     * Default options for the multimenu plugin
     *
     * @var array|string
     */
    const MULTIMENU_DEFAULTS = [
        'theme' => self::THEME_BIGDROP, //selected theme default
        'mobileView' => true, //enable mobile view true|false
        'enableWavesPlugin' => true, //enable the waves effect plugin for links true|false
        'wavesEffect' => SELF::WAVES_CYAN, //waves effect color
        'wavesType' => self::WAVES_TYPE_DEFAULT, //waves type circular|default
        'mobileBreakPoint' => 1200, //default breakpoint for mobile view
        self::THEME_BIGDROP => [
            'enableTransitionEffects' => true, //enable transition effects on the menu
            'transitionEffect' => self::ANIMATE_FLIP_IN_X, //transition effect to sho the menu
            'transitionDelay' => self::ANIMATE_FASTER //animate speed for the transition "fast"|"faster"|"slow"|"slower"|""
        ],
        self::THEME_DROPUP => [
            'enableTransitionEffects' => true, //enable transition effects on the menu
            'transitionEffect' => self::ANIMATE_FADE_IN, //transition effect to sho the menu
            'transitionDelay' => self::ANIMATE_SLOW //animate speed for the transition "fast"|"faster"|"slow"|"slower"|""
        ],
        self::THEME_LEFTNAV => [
            'enableTransitionEffects' => true, //enable transition effects on the menu
            'transitionEffect' => self::ANIMATE_FLIP_IN_X, //transition effect to sho the menu
            'transitionDelay' => self::ANIMATE_FASTER //animate speed for the transition "fast"|"faster"|"slow"|"slower"|""
        ]
    ];

    /**
     * Supported Transition effects by animate.css https://daneden.github.io/animate.css/
     */
    const ANIMATE_BOUNCE_IN = 'bounceIn';
    const ANIMATE_BOUNCE_IN_DOWN = 'bounceInDown';
    const ANIMATE_BOUNCE_IN_UP = 'bounceInUp';
    const ANIMATE_BOUNCE_IN_LEFT = 'bounceInLeft';
    const ANIMATE_BOUNCE_IN_RIGHT = 'bounceInRight';

    const ANIMATE_FADE_IN = 'fadeIn';
    const ANIMATE_FADE_IN_DOWN = 'fadeInDown';
    const ANIMATE_FADE_IN_DOWN_BIG = 'fadeInDownBig';
    const ANIMATE_FADE_IN_LEFT = 'fadeInLeft';
    const ANIMATE_FADE_IN_LEFT_BIG = 'fadeInLeftBig';
    const ANIMATE_FADE_IN_RIGHT = 'fadeInRight';
    const ANIMATE_FADE_IN_RIGHT_BIG = 'fadeInRightBig';

    const ANIMATE_FLIP = 'flip';
    const ANIMATE_FLIP_IN_X = 'flipInX';
    const ANIMATE_FLIP_IN_Y = 'flipInY';

    const ANIMATE_LITE_SPEED_IN = 'lightSpeedIn';

    const ANIMATE_ROTATE_IN = 'rotateIn';
    const ANIMATE_ROTATE_IN_DOWN_LEFT = 'rotateInDownLeft';
    const ANIMATE_ROTATE_IN_DOWN_RIGHT = 'rotateInDownRight';
    const ANIMATE_ROTATE_IN_UP_LEFT = 'rotateInUpLeft';
    const ANIMATE_ROTATE_IN_UP_RIGHT = 'rotateInUpRight';

    const ANIMATE_SLIDE_IN_UP = 'slideInUp';
    const ANIMATE_SLIDE_IN_DOWN = 'slideInDown';
    const ANIMATE_SLIDE_IN_LEFT = 'slideInLeft';
    const ANIMATE_SLIDE_IN_RIGHT = 'slideInRight';

    const ANIMATE_ZOOM_IN = 'zoomIn';
    const ANIMATE_ZOOM_IN_UP = 'zoomInUp';
    const ANIMATE_ZOOM_IN_DOWN = 'zoomInDow';
    const ANIMATE_ZOOM_IN_LEFT = 'zoomInLeft';
    const ANIMATE_ZOOM_IN_RIGHT = 'zoomInRight';

    //delay types
    const ANIMATE_DEFAULT = '';
    const ANIMATE_FAST = 'fast';
    const ANIMATE_FASTER = 'faster';
    const ANIMATE_SLOW = 'slow';
    const ANIMATE_SLOWER = 'slower';

    /**
     * Waves plugin effects http://fian.my.id/Waves/#examples
     */
    const WAVES_TYPE_CIRCLE = 'waves-circle';
    const WAVES_TYPE_DEFAULT = 'default';

    const WAVES_LIGHT = 'waves-light';
    const WAVES_RED = 'waves-red';
    const WAVES_PINK = 'waves-pink';
    const WAVES_PURPLE = 'waves-purple';
    const WAVES_DEEP_PURPLE = 'waves-deep-purple';
    const WAVES_INDIGO = 'waves-indigo';
    const WAVES_BLUE = 'waves-blue';
    const WAVES_LIGHT_BLUE = 'waves-light-blue';
    const WAVES_CYAN = 'waves-cyan';
    const WAVES_TEAL = 'waves-teal';
    const WAVES_GREEN = 'waves-green';
    const WAVES_LIGHT_GREEN = 'waves-light-green';
    const WAVES_LIME = 'waves-lime';
    const WAVES_YELLOW = 'waves-yellow';
    const WAVES_AMBER = 'waves-amber';
    const WAVES_ORANGE = 'waves-orange';
    const WAVES_DEEP_ORANGE = 'waves-deep-orange';
    const WAVES_BROWN = 'waves-brown';
    const WAVES_GREY = 'waves-grey';
    const WAVES_BLUE_GREY = 'waves-blue-grey';
    const WAVES_BLACK = 'waves-black';

    /**
     * Themes available
     */
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

        //register theme specific files
        $themeSelected = ArrayHelper::getValue($this->multimenuOptions, 'theme', self::MULTIMENU_DEFAULTS['theme']);

        //registers the plugin assets
        $this->registerAssets($themeSelected);

        //set the theme option
        $this->_createMenu($themeSelected);

        //register runtime scripts
        $this->registerScript($themeSelected);
    }

    /**
     * Returns the plugin options
     *
     * @return array options
     */
    public function getPluginOptions()
    {

        $allOptions = array_merge(self::MULTIMENU_DEFAULTS, $this->multimenuOptions);
        return array_filter(
            $allOptions,
            function ($val, $key) use ($allOptions) {
                if (!is_array($val)) {
                    return true;
                } elseif (is_array($val) && $key == $allOptions['theme']) {
                    return true;
                }
            },
            ARRAY_FILTER_USE_BOTH
        );
    }

    /**
     * Registers runtime scripts
     *
     * @param string $theme the selected theme
     *
     * @return null
     */
    public function registerScript($theme)
    {
        $pluginOptions = $this->getPluginOptions();
        $options = Json::encode($pluginOptions, true);
        $js = <<<JS
        //merge options with defaults and load
        {$theme}.options=extend(true,{$theme}.options,{$options});

        //init the theme scripts
        {$theme}.init();
JS;
        //get the view
        $view = $this->getView();

        //register script
        $view->registerJs($js, $view::POS_READY);
    }

    /**
     * Sets the options for the selected theme and creaes the menu
     *
     * @param string $theme the selected theme
     *
     * @return null
     */
    private function _createMenu($theme)
    {
        $themeSpecificHtml = [
            self::THEME_BIGDROP => function () {

                //theme big drop
                echo Html::beginTag('div', ['class' => 'multimenu-bigdrop-container']);
                echo Html::beginTag('nav', ['class' => 'multimenu-bigdrop']);
                echo Html::beginTag('div', ['class' => 'container-fluid']);
                $this->_addBrand();
                //call the parent
                parent::run();
                echo Html::endTag('div');
                echo Html::endTag('nav');
                echo Html::endTag('div');

            },
            self::THEME_LEFTNAV => function () {
                echo Html::beginTag('div', ['class' => 'leftnav-container', 'id' => 'leftsidebar']);
                echo Html::beginTag('div', ['class' => 'leftnav']);
                //call the parent
                parent::run();
                echo Html::endTag('div');
                echo Html::endTag('div');
                echo Html::tag('div', '', ['class' => 'overlay']);
            },
            self::THEME_DROPUP => function () {

                echo Html::beginTag('div', ['class' => 'multimenu-dropup-container']);
                echo Html::beginTag('nav', ['class' => 'navbar navbar-fixed-bottom']);
                echo Html::beginTag('div', ['class' => 'container-fluid']);
                $this->_addBrand();
                //call the parent
                parent::run();
                echo Html::endtag('div');
                echo Html::endTag('nav');
                echo Html::endTag('div');
            }
        ];

        isset($themeSpecificHtml[$theme]) && $themeSpecificHtml[$theme]();
    }

    private function _addBrand()
    {
        //add the brand options
        if ($this->brandImage !== false) {
            $this->brandLabel = Html::img($this->brandImage);
        }
        if ($this->brandLabel !== false) {
            Html::addCssClass($this->brandOptions, ['widget' => 'navbar-brand']);
            echo Html::beginTag('div', ['class' => 'navbar-header']);
            echo Html::a($this->brandLabel, $this->brandUrl === false ? Yii::$app->homeUrl : $this->brandUrl, $this->brandOptions);
            echo Html::endTag('div');
        }
    }

    /**
     * Compares the user supplied options with default
     *
     * @return array
     */
    private function _checkOptions()
    {
        $invalidOptions = [];
        foreach ($this->multimenuOptions as $userOptionsKey => $userOptionsValue) {
            if (!array_key_exists($userOptionsKey, self::MULTIMENU_DEFAULTS)) {
                $invalidOptions[$userOptionsKey] = $userOptionsValue;
            } else if (is_array($userOptionsValue)) {
                foreach ($userOptionsValue as $option => $value) {
                    $themeOptions = self::MULTIMENU_DEFAULTS[$userOptionsKey];
                    if (!array_key_exists($option, $themeOptions)) {
                        $invalidOptions[$option] = $value;
                    }
                }
            }
        }
        return $invalidOptions;
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
        //checks for any invalid options provided for the plugin
        if (!empty($invalid = $this->_checkOptions())) {
            throw new CfgException("Invalid multimenuOptions provided see below \n\n" . Json::encode($invalid));
        }

        //get selected theme
        $theme = $this->getPluginOptions()['theme'];

        //theme default options
        $themeSpecificOptions = [
            self::THEME_BIGDROP => function () {
                $this->submenuTemplate = "\n<ul>\n{items}</ul>\n";
                $this->activateParents = true;
                $this->hideEmptyItems = false;
                $this->options = array_merge_recursive(
                    $this->options, [
                        'class' => 'collapse navbar navbar-collapse',
                        'id' => 'bigdrop-navbar-collapse'
                    ]
                );
            },
            self::THEME_DROPUP => function () {
                $this->options = array_merge_recursive(
                    $this->options,
                    [
                        'class' => 'collapse navbar-collapse multimenu-dropup', 'id' => 'navbar-collapse'
                    ]
                );
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

            }
        ];
        //load theme defaults
        isset($themeSpecificOptions[$theme]) && $themeSpecificOptions[$theme]();

        //is bs4 version
        $isBs4 = class_exists(BS4Asset::class);
        $this->_bsVersion = $isBs4 ? 4 : 3;
    }

    /**
     * Registers the necessary AssetBundles for the widget
     *
     * @param string $themeSelected name of the Theme selected
     *
     * @return null
     */
    public function registerAssets($themeSelected)
    {
        $view = $this->getView();

        //is supported theme
        if (in_array($themeSelected, array_keys($this->themesSupported))) {
            $themeAsset = __NAMESPACE__ . '\assetbundles\bs' .
            $this->_bsVersion . '\Theme' .
            $this->themesSupported[$themeSelected] . 'Asset';

            $themeAsset::register($view);
            return;
        }
        throw new ArgException('You must select the correct theme');

    }
}
