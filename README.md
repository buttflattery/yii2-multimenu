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

You can pass the plugin specific settings here. You can pass generic settings for the multimenu plugin and settings depending on the type of the menu you are using

- #### `theme (string)`

  The theme of the menu you want to use, it can be any of the `bigdrop`,`leftnav` and `dropup`, you can use the available constants `THEME_BIGDROP`, `THEME_LEFTNAV` and `THEME_DROPUP`.

- ### `themeColorFile (string)`

  The name space of the theme color file you want to load with the menu you can customize classes for the menu and load via this option. Default value is `''`.
- ### `mobileView (bool)`
  
  If enable the menu in mobile view too. This option comes handy when you want to use 2 menus on the same page and want one of them to be show for the mobile view, you can turn the other one off. Default value is `true`.

- ### `enableWavesPlugin (bool)`

  If the [Waves](https://materializecss.com/waves.html#!). plugin should be enabled when clicking on the menu items. Default value is `true`.

- ### `wavesEffect (string)`

  The color of the waves effect see https://materializecss.com/waves.html#! . Default value is `waves-cyan`.

- ### `wavesType (string) circular|default`

  The waves type effect, `circular` or `default`. Default value is `default`.

- ### `mobileBreakPoint (int)`

  The mobile view break point where the javascript plugin should recalculate sizes. Default value is `1200`.

  There are menu/theme specific options that are applicable to specific menu types only. See details below.

- ### `bigdrop (array)`

  It accepts the following settings to be used for bigdrop menu only.

  - `enableTransitionEffects (bool)` : Enable transition effects on the menu, uses `animate.css`. default is `true`.

  - `transitionEffect (string)` : Transition effect to show the menu. default value `flipInX` . See `animate.css` for trasition effect types.

  - `transitionDelay (string)` : animate speed for the transition `"fast"|"faster"|"slow"|"slower"|""`. Default value `faster`.

- ### `dropup (array)`

  It accepts the the same set of settings as above for the bigdrop but uses different default values

  - `enableTransitionEffects` => true
  - `transitionEffect` => 'fadeIn`
  - `transitionDelay` => 'slow'

Set theme for the menu. Available options `bigdrop`,`leftnav` and `dropup`, Default value `bigdrop`. You can use the available constants `Multimenu::THEME_BIGDROP`, `Multimenu::THEME_LEFTNAV`,`Multimenu::THEME_DROPUP`,

## Running migrations

- Windows (Command Prompt)

  `php yii migrate/up --migrationPath=@vendor/buttflattery/yii2-multimenu/src/migrations`

- ubuntu (Bash)

  `php ./yii migrate/up --migrationPath=@vendor/buttflattery/yii2-multimenu/src/migrations`
