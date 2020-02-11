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

## Available Options
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

### `$enableSearch (bool)`

Adds a search form in the navigation. Default value is `false`.



### `theme (string)`

Set theme for the menu. Available options `bigdrop`,`leftnav` and `dropup`, Default value `bigdrop`. You can use the available constants `Multimenu::THEME_BIGDROP`, `Multimenu::THEME_LEFTNAV`,`Multimenu::THEME_DROPUP`,

## Running migrations

- Windows (Command Prompt)

  `php yii migrate/up --migrationPath=@vendor/buttflattery/yii2-multimenu/src/migrations`

- ubuntu (Bash)

  `php ./yii migrate/up --migrationPath=@vendor/buttflattery/yii2-multimenu/src/migrations`
