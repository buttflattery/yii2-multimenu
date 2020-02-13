# Yii2-multimenu

## What is this repository for?

A Yii2 widget that creates a navigation menu based on the `yii\widgets\Menu`, and provides you with multiple layout options that include a **Big Drop** style top navigation, a **Left Menu** navigation and a **Sticky drop-up** footer menu just by using this single widget. it uses multilple 3rd party plugins for animating the menu. It provide an extra helper component to build menu from the model.

![preview](https://tinyii2.local/theme/assets/img/multimenu.jpg)

## External Libraries Used

- [jQuery>= v2.2.4](https://jquery.com/download/)
- [Bootstrap v3.3.7](https://getbootstrap.com/docs/3.3/) && [Bootstrap v4](http://getbootstrap.com/)
- [Waves Plugin](https://github.com/fians/Waves/blob/master/LICENSE).
- [Animate](https://daneden.github.io/animate.css/)
- [Slim Scroll](http://rocha.la)

---

## About Bootstrap Version Usage

The extension detects if you are using the `yiisoft/yii2-bootstrap` or `yiisoft/yii2-bootstrap4` and loads the appropriate assets for the extension. It will check first the `"yiisoft/yii2-bootstrap4"` if it exists then it will load bootstrap4 resources otherwise it will fall back to use bootstrap3. So make sure you are following the correct guide to use the [`yiisoft/yii2-bootstrap4"`](https://github.com/yiisoft/yii2-bootstrap4) and remove the `"yiisoft/yii2-bootstrap": "~2.0.0",` from you `composer.json` and change the `minimum-stability:"dev"` here is the complete [guide](https://github.com/yiisoft/yii2-bootstrap4/blob/master/docs/guide/README.md).

## Demos

- [Big Drop](https://yii2plugins.omaraslam.com/multimenu/bigdrop)
- [Left Navigation](https://yii2plugins.omaraslam.com/multimenu/leftnav)
- [Sticky Drop-up Footer Navigation](https://yii2plugins.omaraslam.com/multimenu/dropup)

## Usage

```php
<?php
        echo MultiMenu::widget(
            [
                'activeCssClass' => 'active',
                'items' => Yii::$app->menuhelper->getMenuItems(),
                'brandLabel' => 'Left Navigation',
                'brandImage' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAB+0lEQVR4AcyYg5LkUBhG+1X2PdZGaW3btm3btm3bHttWrPomd1r/2Jn/VJ02TpxcH4CQ/dsuazWgzbIdrm9dZVd4pBz4zx2igTaFHrhvjneVXNHCSqIlFEjiwMyyyOBilRgGSqLNF1jnwNQdIvAt48C3IlBmHCiLQHC2zoHDu6zG1iXn6+y62ScxY9AODO6w0pvAqf23oSE4joOfH6OxfMoRnoGUm+de8wykbFt6wZtA07QwtNOqKh3ZbS3Wzz2F+1c/QJY0UCJ/J3kXWJfv7VhxCRRV1jGw7XI+gcO7rEFFRvdYxydwcPsVsC0bQdKScngt4iUTD4Fy/8p7PoHzRu1DclwmgmiqgUXjD3oTKHbAt869qdJ7l98jNTEblPTkXMwetpvnftA0LLHb4X8kiY9Kx6Q+W7wJtG0HR7fdrtYz+x7iya0vkEtUULIzCjC21wY+W/GYXusRH5kGytWTLxgEEhePPwhKYb7EK3BQuxWwTBuUkd3X8goUn6fMHLyTT+DCsQdAEXNzSMeVPAJHdF2DmH8poCREp3uwm7HsGq9J9q69iuunX6EgrwQVObjpBt8z6rdPfvE8kiiyhsvHnomrQx6BxYUyYiNS8f75H1w4/ISepDZLoDhNJ9cdNUquhRsv+6EP9oNH7Iff2A9g8h8CLt1gH0Qf9NMQAFnO60BJFQe0AAAAAElFTkSuQmCC',
                'brandUrl' => 'https://yii2plugins.omaraslam.com',
                'activateParents' => true,
                'layoutTemplate'=>'{multimenu}{brand}',
                'enableIcons'=>true,
                'multimenuOptions' => [
                    'theme' => MultiMenu::THEME_LEFTNAV,
                    'mobileView' => true,
                    MultiMenu::THEME_LEFTNAV => [
                        'position'=>MultiMenu::LEFT_NAV_FIXED,
                        'slimScroll' => [
                            'scrollColor' => 'rgba(0,0,0,0.75)'
                        ]
                    ]
                ]
            ]
        );
    ?>
```

## Available Options for the Widget

You can use the available default options for the [`yii\widgets\Menu`](https://www.yiiframework.com/doc/api/2.0/yii-widgets-menu) along with the following options

### `$brandImage (string|bool)`

Src of the brand image or false if it's not used. Note that this param will override `$this->brandLabel` param. Default value is `false`.

### `$brandLabel (string|bool)`

The text of the brand or `false` if it's not used. Note that this is not HTML-encoded. Default value is `false`.

### `$brandOptions (array)`

The HTML attributes of the brand link. `\yii\helpers\Html::renderTagAttributes()` for details on how attributes are being rendered.

### `$brandUrl (bool)`

The URL for the brand's hyperlink tag. This parameter will be processed by `[[\yii\helpers\Url::to()]]` and will be used for the "href" attribute of the brand link. Default value is `false` that means `[[\yii\web\Application::homeUrl]]` will be used. You may set it to `null` if you want to have no link at all.

### `$containerCssClasses (array)`

The Container HTML options.

### `$layoutTemplate (string)`

The layout template used to draw the menu and rearrange the brand and menu items placement. Default value is `{brand}{multimenu}`.

### `$enableIcons (bool)`

If default icon should be enabled along with the labels of the menu. It uses the `Multmenu::DEFAULT_ICON` which has the value `<i class="ion-android-menu"></i>`

### `$multimenuOptions (array)`

You can pass the plugin specific settings here for the multimenu and settings depending on the type of the menu you are using.

- #### `theme (string)`

  The theme of the menu you want to use, it can be any of the `bigdrop`,`leftnav` and `dropup`, you can use the available constants `THEME_BIGDROP`, `THEME_LEFTNAV` and `THEME_DROPUP`. See available constants section.

- ### `themeColorFile (string)`

  The name space of the theme color file you want to load with the menu you can customize classes for the menu and load via this option. Default value is empty `''`. See wiki for creating the theme file.

- ### `mobileView (bool)`

  If enabled, the menu will be responsive in the mobile view. This option comes handy when you want to use 2 menus on the same page and want one of them to be show for the mobile view, you can turn the other one off. Default value is `true`.

- ### `enableWavesPlugin (bool)`

  If the [Waves](https://materializecss.com/waves.html#!). plugin should be enabled when clicking on the menu items. Default value is `true`.

- ### `wavesEffect (string)`

  The color of the waves effect see https://materializecss.com/waves.html#! . Default value is `waves-cyan`.

- ### `wavesType (string) circular|default`

  The waves type effect, `circular` or `default`. Default value is `default`. See the constants section to see all available effects you can use.

- ### `mobileBreakPoint (int)`

  The mobile view break point where the javascript plugin should recalculate sizes. Default value is `1200`. (_Note: dont change this option unless you know what you are doing as changing it will require you to update the media queries for the themes too._)

There are menu/theme specific options that are applicable to specific menu types only. See details below.

- ### `bigdrop (array)`

  It accepts the following settings to be used for bigdrop menu only.

  - `enableTransitionEffects (bool)` : Enable transition effects on the menu, uses `animate.css`. default is `true`.

  - `transitionEffect (string)` : Transition effect to show the menu. default value `flipInX` . See `animate.css` for trasition effect types.

  - `transitionDelay (string)` : Animate speed for the transition `"fast"|"faster"|"slow"|"slower"|""`. Default value `faster`. See available constants.

- ### `dropup (array)`

  It accepts the the same set of settings as above for the bigdrop but uses different default values

  - `enableTransitionEffects` => true
  - `transitionEffect` => 'fadeIn`
  - `transitionDelay` => 'slow'

- ### `leftnav (array)`

  It accepts the the same set of settings as above for the bigdrop with different default values, and some extra options for the leftnav.

  - `enableTransitionEffects` => true

  - `transitionEffect` => 'fadeIn`

  - `transitionDelay` => 'slow'

  - `position (string) default|fixed|absolute` : the position of the left menu, the default value is `default` and the leftnav will be rendered relative to it's parent container.

  - `slimScroll (array)` : The options for the [slimscroll](http://rocha.la/jQuery-slimScroll) plugin used for the left nav.

    - `scrollColor (string)` : The scroll bar color, default value is `rgba(0,0,0,0.8)`.

    - `scrollWidth (string)` : Width of the scroll bar, default value is `4px`.

    - `scrollAlwaysVisible (bool)` : If `true` scroll will always be visible, default value is `false`.

    - `scrollBorderRadius` : The scroll bar border radius, default value is `0`.

    - `scrollRailBorderRadius` : Sets border radius of the rail, default value is `0`.

    - `scrollActiveItemWhenPageLoad` : If `true`, will always scroll to the active menu item link after the page loads, default value is `true`.

## BigDrop minimal options with brand text

```php
<?php
    use buttflattery\multimenu\MultiMenu;
    $items = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            [
                'label' => 'Dropdown',
                'url' => 'javascript:void(0)',
                'items' => [
                    ['label' => 'Level 1  Dropdown A', 'url' => '#'],
                    ['label' => 'Level 1  Dropdown B', 'url' => '#'],
                ],
            ],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
        ),
    ];
    echo MultiMenu::widget(
        [
            'activeCssClass' => 'active',
            'items' => $items,
            'layoutTemplate' => '{multimenu}{brand}',
            'enableIcons'=>true,
            'brandUrl' => 'https://plugins.omaraslam.com',
            'brandLabel'=>'Yii2 Multimenu',
            'activateParents' => true,
            'multimenuOptions' => [
                'theme' => MultiMenu::THEME_BIGDROP,
            ],
        ]
    );

?>
```

## Leftnav Minimal options with brand image

```php
<?php
    use buttflattery\multimenu\MultiMenu;
    $items = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            [
                'label' => 'Dropdown',
                'url' => 'javascript:void(0)',
                'items' => [
                    ['label' => 'Level 1  Dropdown A', 'url' => '#'],
                    ['label' => 'Level 1  Dropdown B', 'url' => '#'],
                ],
            ],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
        ),
    ];

    echo MultiMenu::widget(
        [
            'activeCssClass' => 'active',
            'items' => $items,
            'brandLabel' => 'Left Navigation',
            'brandImage' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAB+0lEQVR4AcyYg5LkUBhG+1X2PdZGaW3btm3btm3bHttWrPomd1r/2Jn/VJ02TpxcH4CQ/dsuazWgzbIdrm9dZVd4pBz4zx2igTaFHrhvjneVXNHCSqIlFEjiwMyyyOBilRgGSqLNF1jnwNQdIvAt48C3IlBmHCiLQHC2zoHDu6zG1iXn6+y62ScxY9AODO6w0pvAqf23oSE4joOfH6OxfMoRnoGUm+de8wykbFt6wZtA07QwtNOqKh3ZbS3Wzz2F+1c/QJY0UCJ/J3kXWJfv7VhxCRRV1jGw7XI+gcO7rEFFRvdYxydwcPsVsC0bQdKScngt4iUTD4Fy/8p7PoHzRu1DclwmgmiqgUXjD3oTKHbAt869qdJ7l98jNTEblPTkXMwetpvnftA0LLHb4X8kiY9Kx6Q+W7wJtG0HR7fdrtYz+x7iya0vkEtUULIzCjC21wY+W/GYXusRH5kGytWTLxgEEhePPwhKYb7EK3BQuxWwTBuUkd3X8goUn6fMHLyTT+DCsQdAEXNzSMeVPAJHdF2DmH8poCREp3uwm7HsGq9J9q69iuunX6EgrwQVObjpBt8z6rdPfvE8kiiyhsvHnomrQx6BxYUyYiNS8f75H1w4/ISepDZLoDhNJ9cdNUquhRsv+6EP9oNH7Iff2A9g8h8CLt1gH0Qf9NMQAFnO60BJFQe0AAAAAElFTkSuQmCC',
            'brandUrl' => 'http://omaraslam.com',
            'activateParents' => true,
            'layoutTemplate'=>'{multimenu}{brand}',
            'enableIcons'=>true,
            'multimenuOptions' => [
                'theme' => MultiMenu::THEME_LEFTNAV,
                'mobileView' => true,
                MultiMenu::THEME_LEFTNAV => [
                    'position'=>MultiMenu::LEFT_NAV_FIXED,
                    'slimScroll' => [
                        'scrollColor' => 'rgba(0,0,0,0.75)'
                    ]
                ]
            ]
        ]
    );
?>
```

## Dropup menu with custom color theme Asset Class

```php
<?php
    use buttflattery\multimenu\MultiMenu;

    $items = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            [
                'label' => 'Dropdown',
                'url' => 'javascript:void(0)',
                'items' => [
                    ['label' => 'Level 1  Dropdown A', 'url' => '#'],
                    ['label' => 'Level 1  Dropdown B', 'url' => '#'],
                ],
            ],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
        ),
    ];

    echo MultiMenu::widget(
        [
            'activeCssClass' => 'active',
            'items' => Yii::$app->menuhelper->getMenuItems('menu_name'),
            'activateParents' => true,
            'brandLabel' => 'Yii2 Multimenu',
            'enableIcons'=>true,
            'brandUrl' => 'https://plugins.omaraslam.com',
            'layoutTemplate'=>'{multimenu}{brand}',
            'multimenuOptions' => [
                'theme' => MultiMenu::THEME_DROPUP,
                'themeColorFile' => \app\assets\DropUpBisqueRed::class,
                'mobileView' => true,
                MultiMenu::THEME_DROPUP => [
                    'transitionEffect' => MultiMenu::ANIMATE_DEFAULT,
                ],
            ],
        ]
    );
?>
```

Your theme asset class code

```php
<?php
// @codingStandardsIgnoreStart
namespace app\assets;

use buttflattery\multimenu\assetbundles\bs3\ThemeDropUpAsset;

class DropUpBisqueRed extends ThemeDropUpAsset
{
    //@codingStandardsIgnoreEnd

    public function init()
    {
        parent::init();
        array_push($this->css, '/css/theme/dropup/bisque-red.css');
    }
}

```

## Menu items from Database

A helper component `buttflattery\multimenu\helpers\MenuHelper` is added that come in handy if you want to just add all the menu items in the database table and leave the rest on this component to generate the `items` array for the menu.

If you dont have a menu table added yet you can run the migration and use the model provided `buttflattery\multimenu\models\Menu`.

### **Running migrations**

Run the following command on terminal to run the migrations

`php ./yii migrate/up --migrationPath=@vendor/buttflattery/yii2-multimenu/src/migrations`

```mysql
+-----------+-------------+------+-----+---------+----------------+
| Field     | Type        | Null | Key | Default | Extra          |
+-----------+-------------+------+-----+---------+----------------+
| id        | int(11)     | NO   | PRI | NULL    | auto_increment |
| label     | varchar(50) | NO   |     | NULL    |                |
| link      | text        | YES  |     | NULL    |                |
| parent_id | int(11)     | YES  |     | NULL    |                |
+-----------+-------------+------+-----+---------+----------------+
```

### **Configure the Component**

Open `config/web.php` if you are using `yii2-basic` or the `common/config/main.php` if you are using `advance-app` and add the following under the `components` array.

```php
'components' => [
    'menuhelper' => [
        'class' => 'buttflattery\multimenu\helpers\MenuHelper',
        'model' => 'buttflattery\multimenu\models\Menu',
    ],
```

If you wish to use your custom model and have a menu table already you can provide your own model namespace and set the field names appropriately for the component to work correctly. See below for a full set of options you can configure for the component.

```php
'components' => [
    'menuhelper' => [
        'class' => 'buttflattery\multimenu\helpers\MenuHelper',
        'model' => 'app\models\Menus',
        'linkField'=>'menu_link',
        'labelField'=>'menu_name',
        'idField'=>'menu_id',
        'parentIdField'=>'menu_parent_id',
    ],
```

Now you can call the `function getMenuItems(orderByField)` to get the `$items` array like below.

```php
<?php
    use buttflattery\multimenu\MultiMenu;

    echo MultiMenu::widget(
        [
            'activeCssClass' => 'active',
            'items' => Yii::$app->menuhelper->getMenuItems(),
            'layoutTemplate' => '{multimenu}{brand}',
            'enableIcons'=>true,
            'brandUrl' => 'https://plugins.omaraslam.com',
            'brandLabel'=>'Yii2 Multimenu',
            'activateParents' => true,
            'multimenuOptions' => [
                'theme' => MultiMenu::THEME_BIGDROP,
            ],
        ]
    );

?>
```

## Available Constants

```php

  /**
  * For use with leftnav `position` option
  */
  const LEFT_NAV_FIXED = 'fixed';
  const LEFT_NAV_ABSOLUTE = 'absolute';
  const LEFT_NAV_DEFAULT = 'default';

  /**
   * Supported Transition effects by animate.css
   * https://daneden.github.io/animate.css/
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

  /**
   * delay types for `transitionDelay` option
   * under the menu specific options
   */
  const ANIMATE_DEFAULT = '';
  const ANIMATE_FAST = 'fast';
  const ANIMATE_FASTER = 'faster';
  const ANIMATE_SLOW = 'slow';
  const ANIMATE_SLOWER = 'slower';

  /**
   * Waves plugin effects http://fian.my.id/Waves/#examples
   * used for the option `wavesEffect`
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
   * Themes available used for the `theme` option
   * under `multimenuOptions` option
   */
  const THEME_BIGDROP = 'bigdrop';
  const THEME_LEFTNAV = 'leftnav';
  const THEME_DROPUP = 'dropup';
```

### Who do I talk to?

- buttflattery@gmail.com
- yii2plugins@omaraslam.com
