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
use Exception;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\Menu;
use RecursiveArrayIterator;
use yii\helpers\ArrayHelper;
use RecursiveIteratorIterator;
use yii\bootstrap4\BootstrapAsset as BS4Asset;
use yii\base\InvalidConfigException as CfgException;
use yii\base\InvalidArgumentException as ArgException;

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
     * The Container HTML options
     *
     * @var array
     */
    public $containerCssClasses = [];

    /**
     * Adds a search form in the navigation
     *
     * @var mixed
     */
    public $enableSearch = false;

    /**
     * @var string
     */
    public $searchFormContent = '';

    /**
     * The layout for the menu
     *
     * @var string
     */
    public $layoutTemplate = "{brand}{multimenu}";

    /**
     * Enable default icon with the menu labels
     *
     * @var mixed
     */
    public $enableIcons = false;

    /**
     * Default options for the multimenu plugin
     *
     * @var array|string
     */
    const MULTIMENU_DEFAULTS = [
        'theme' => self::THEME_BIGDROP,          //selected theme default
        'themeColorFile' => '',                  //color option to use for the navigation
        'mobileView' => true,                    //enable mobile view true|false
        'enableWavesPlugin' => true,             //enable the waves effect plugin for links true|false
        'wavesEffect' => SELF::WAVES_CYAN,       //waves effect color
        'wavesType' => self::WAVES_TYPE_DEFAULT, //waves type circular|default
        'mobileBreakPoint' => 1200,              //default breakpoint for mobile view,
        self::THEME_BIGDROP => [
            'enableTransitionEffects' => true,             //enable transition effects on the menu
            'transitionEffect' => self::ANIMATE_FLIP_IN_X, //transition effect to sho the menu
            'transitionDelay' => self::ANIMATE_FASTER,     //animate speed for the transition "fast"|"faster"|"slow"|"slower"|""
        ],
        self::THEME_DROPUP => [
            'enableTransitionEffects' => true,           //enable transition effects on the menu
            'transitionEffect' => self::ANIMATE_FADE_IN, //transition effect to sho the menu
            'transitionDelay' => self::ANIMATE_SLOW,     //animate speed for the transition "fast"|"faster"|"slow"|"slower"|""
        ],
        self::THEME_LEFTNAV => [
            'position' => self::LEFT_NAV_DEFAULT,
            'enableTransitionEffects' => true,             //enable transition effects on the menu
            'transitionEffect' => self::ANIMATE_FLIP_IN_X, //transition effect to sho the menu
            'transitionDelay' => self::ANIMATE_FASTER,     //animate speed for the transition "fast"|"faster"|"slow"|"slower"|""
            'slimScroll' => [
                'scrollColor' => 'rgba(0,0,0,0.8)',
                'scrollWidth' => '4px',
                'scrollAlwaysVisible' => false,
                'scrollBorderRadius' => '0',
                'scrollRailBorderRadius' => '0',
                'scrollActiveItemWhenPageLoad' => true,
            ],
        ],
    ];

    /**
     * Constants for left nav position
     */
    const LEFT_NAV_FIXED = 'fixed';
    const LEFT_NAV_ABSOLUTE = 'absolute';
    const LEFT_NAV_DEFAULT = 'default';

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
        self::THEME_DROPUP => 'DropUp',
    ];

    /**
     * Initializes the plugin
     *
     * @return null
     */
    public function run()
    {
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }

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
     * @return mixed
     */
    private function _arrayMergeRecursive()
    {

        if (func_num_args() < 2) {
            trigger_error(__FUNCTION__ . ' needs two or more array arguments', E_USER_WARNING);
            return;
        }
        $arrays = func_get_args();
        $merged = array();
        while ($arrays) {
            $array = array_shift($arrays);
            if (!is_array($array)) {
                trigger_error(__FUNCTION__ . ' encountered a non array argument', E_USER_WARNING);
                return;
            }
            if (!$array) {
                continue;
            }

            foreach ($array as $key => $value) {
                if (is_string($key)) {
                    if (is_array($value) && array_key_exists($key, $merged) && is_array($merged[$key])) {
                        $merged[$key] = $this->_arrayMergeRecursive($merged[$key], $value);
                    } else {
                        $merged[$key] = $value;
                    }
                } else {
                    $merged[] = $value;
                }
            }

        }
        return $merged;
    }

    /**
     * Returns the plugin options
     *
     * @return array options
     */
    public function getPluginOptions($optionName = null)
    {

        $allOptions = $this->_arrayMergeRecursive(self::MULTIMENU_DEFAULTS, $this->multimenuOptions);

        if (null !== $optionName) {
            $arrIt = new RecursiveIteratorIterator(new RecursiveArrayIterator($allOptions));
            foreach ($arrIt as $key => $sub) {
                if ($key == $optionName) {
                    return $sub;
                }
            }
            throw new Exception("Unknown option name $optionName");
        } else {
            return $allOptions;
        }
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
                $containerOptions = [
                    'class' => 'multimenu-bigdrop-container',
                ];

                //add the custom classes to the container
                Html::addCssClass($containerOptions, $this->containerCssClasses);

                //theme big drop
                echo Html::beginTag('div', $containerOptions);
                echo Html::beginTag('nav', ['class' => 'multimenu-bigdrop']);
                echo Html::beginTag('div', ['class' => 'container-fluid clearfix']);

                //add the brand section
                $brandHtml = $this->addBrand();

                //build menu
                $menuHtml = $this->buildMenu();

                echo $this->renderMenuItems($brandHtml, $menuHtml);

                echo Html::endTag('div');
                echo Html::endTag('nav');
                echo Html::endTag('div');

            },
            self::THEME_LEFTNAV => function () {

                $containerOptions = [
                    'class' => 'leftnav-container',
                    'id' => 'leftsidebar',
                ];

                //add the custom classes to the container
                Html::addCssClass($containerOptions, $this->containerCssClasses);
                $position = $this->getPluginOptions('position');

                if ($position !== 'default') {
                    Html::addCssClass($containerOptions, 'container-' . $position);
                }

                echo Html::beginTag('div', $containerOptions);
                $brandHtml = $this->addBrand();
                $menuHtml = Html::beginTag('div', ['class' => 'leftnav']);
                //call the parent
                $menuHtml .= $this->buildMenu();
                $menuHtml .= Html::endTag('div');

                echo $this->renderMenuItems($brandHtml, $menuHtml);

                echo Html::endTag('div');
                echo Html::tag('div', '', ['class' => 'overlay']);
            },
            self::THEME_DROPUP => function () {
                $containerOptions = [
                    'class' => 'multimenu-dropup-container',
                ];

                $fixedBottomClass = $this->_bsVersion === 3 ? 'navbar-fixed-bottom' : 'fixed-bottom';

                //add the custom classes to the container
                Html::addCssClass($containerOptions, $this->containerCssClasses);
                echo Html::beginTag('div', $containerOptions);
                echo Html::beginTag('nav', ['class' => "navbar $fixedBottomClass"]);
                echo Html::beginTag('div', ['class' => 'container-fluid']);

                //html brand
                $brandHtml = $this->addBrand();

                //build menu
                $menuHtml = $this->buildMenu();

                echo $this->renderMenuItems($brandHtml, $menuHtml);

                echo Html::endtag('div');
                echo Html::endTag('nav');
                echo Html::endTag('div');
            },
        ];

        isset($themeSpecificHtml[$theme]) && $themeSpecificHtml[$theme]();
    }

    /**
     * @param $brandHtml
     * @param $menuHtml
     */
    public function renderMenuItems($brandHtml, $menuHtml)
    {
        $template = $this->layoutTemplate;

        return strtr($template, [
            '{brand}' => $brandHtml,
            '{multimenu}' => $menuHtml,
        ]);
    }

    public function buildMenu()
    {
        $items = $this->normalizeItems($this->items, $hasActiveChild);
        if (!empty($items)) {
            $options = $this->options;
            $tag = ArrayHelper::remove($options, 'tag', 'ul');

            return Html::tag($tag, $this->renderItems($items), $options);
        }
    }

    /**
     * Adds the brand section for the nav
     *
     * @return $htmlBrand
     */
    public function addBrand()
    {
        //add the brand options
        if ($this->brandImage !== false) {
            $this->brandLabel = Html::img($this->brandImage);
        }
        if ($this->brandLabel !== false) {
            Html::addCssClass($this->brandOptions, ['widget' => 'navbar-brand']);
            return $this->_bs3Brand();

        }
    }

    private function _bs4Brand()
    {
        echo Html::a($this->brandLabel, $this->brandUrl === false ? Yii::$app->homeUrl : $this->brandUrl, $this->brandOptions);
    }

    /**
     * @return mixed
     */
    private function _bs3Brand()
    {
        $html = '';
        $html .= Html::beginTag('div', ['class' => 'navbar-header']);
        $html .= Html::a($this->brandLabel, $this->brandUrl === false ? Yii::$app->homeUrl : $this->brandUrl, $this->brandOptions);
        $html .= Html::endTag('div');
        return $html;
    }

    /**
     * Compares the user supplied options with default
     *
     * @return array
     */
    private function _checkOptions()
    {
        $userOptions = $this->getAllOptions($this->multimenuOptions);
        $defaultOptions = $this->getAllOptions(self::MULTIMENU_DEFAULTS);
        $invalidOptions = [];

        foreach ($userOptions as $option) {
            if (!in_array($option, $defaultOptions)) {
                $invalidOptions[] = $option;
            }
        }
        return $invalidOptions;
    }

    /**
     * Extracts all the keys from the associative array as option names
     *
     * @param array $options the options array
     *
     * @return array $options
     */
    public function getAllOptions($options)
    {
        $optionsName = [];
        foreach ($options as $key => $val) {

            if (!is_array($val)) {
                $optionsName[] = $key;
            } else {
                $subOptions = $this->getAllOptions($val);
                $optionsName = array_merge($optionsName, $subOptions);
            }
        }
        return $optionsName;
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
        $theme = $this->getPluginOptions('theme');

        //theme default options
        $themeSpecificOptions = [
            self::THEME_BIGDROP => function () {
                $this->submenuTemplate = "\n<ul>\n{items}</ul>\n";
                $this->activateParents = true;
                $this->hideEmptyItems = false;
                $this->options = array_merge_recursive(
                    $this->options, [
                        'class' => 'collapse navbar navbar-collapse',
                        'id' => 'bigdrop-navbar-collapse',
                    ]
                );
            },
            self::THEME_DROPUP => function () {
                $this->options = array_merge_recursive(
                    $this->options,
                    [
                        'class' => 'collapse navbar-collapse multimenu-dropup', 'id' => 'navbar-collapse',
                    ]
                );
            },
            self::THEME_LEFTNAV => function () {
                $this->options = array_merge_recursive(
                    $this->options,
                    [
                        'class' => 'list',
                        'style' => 'overflow: hidden; width: inherit; height:inherit',
                    ]
                );
                $this->encodeLabels = false;

                if ($this->labelTemplate == '{label}') {
                    $defaultIcon = $this->enableIcons ? '<i class="material-icons">donut_large</i>' : '';
                    $this->labelTemplate = '<a href="#."><span>' . $defaultIcon . '{label}</span></a>';
                }

                if ($this->linkTemplate == '<a href="{url}">{label}</a>') {
                    $defaultIcon = $this->enableIcons ? '<i class="material-icons">donut_large</i>&nbsp' : '';
                    $this->linkTemplate = '<a href="{url}"><span>' . $defaultIcon . '{label}</span></a>';
                }

                $this->submenuTemplate = "\n<ul class='ml-menu'>\n{items}\n</ul>\n";

            },
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
            $themeAsset = __NAMESPACE__ . '\\assetbundles\\bs' .
            $this->_bsVersion . '\\Theme' .
            $this->themesSupported[$themeSelected] . 'Asset';

            //register default theme assets
            $themeAsset::register($view);

            //load custom color theme if provided by user
            $themeColorFile = $this->getPluginOptions('themeColorFile');
            if ($themeColorFile !== '' && class_exists($themeColorFile)) {
                $themeColorFile::register($view);
            }
            return;
        }
        throw new ArgException('You must select the correct theme');

    }
}
