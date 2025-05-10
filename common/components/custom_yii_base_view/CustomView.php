<?php
namespace common\components\custom_yii_base_view;

use common\components\custom_base_html\CustomBaseHtml;
use rmrevin\yii\minify\View;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * View represents a view object in the MVC pattern.
 *
 * View provides a set of methods (e.g. [[render()]]) for rendering purpose.
 *
 * View is configured as an application component in [[\yii\base\Application]] by default.
 * You can access that instance via `Yii::$app->view`.
 *
 * You can modify its configuration by adding an array to your application config under `components`
 * as it is shown in the following example:
 *
 * ```php
 * 'view' => [
 *     'theme' => 'app\themes\MyTheme',
 *     'renderers' => [
 *         // you may add Smarty or Twig renderer here
 *     ]
 *     // ...
 * ]
 * ```
 *
 * For more details and usage information on View, see the [guide article on views](guide:structure-views).
 *
 * @property \yii\web\AssetManager $assetManager The asset manager. Defaults to the "assetManager" application
 * component.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CustomView extends View
{

    public $description;
    public $og_image;
    public $type;

    /**
     * Registers a CSS code block.
     * @param string $css the content of the CSS code block to be registered
     * @param array $options the HTML attributes for the `<style>`-tag.
     * @param string|null $key the key that identifies the CSS code block. If null, it will use
     * $css as the key. If two CSS code blocks are registered with the same key, the latter
     * will overwrite the former.
     */
    public function registerCss($css, $options = [], $key = null)
    {
        $key = $key ?: md5($css);
        $this->css[$key] = CustomBaseHtml::style($css, $options);
    }

    /**
     * Registers a CSS file.
     *
     * This method should be used for simple registration of CSS files. If you want to use features of
     * [[AssetManager]] like appending timestamps to the URL and file publishing options, use [[AssetBundle]]
     * and [[registerAssetBundle()]] instead.
     *
     * @param string $url the CSS file to be registered.
     * @param array $options the HTML attributes for the link tag. Please refer to [[Html::cssFile()]] for
     * the supported options. The following options are specially handled and are not treated as HTML attributes:
     *
     * - `depends`: array, specifies the names of the asset bundles that this CSS file depends on.
     * - `appendTimestamp`: bool whether to append a timestamp to the URL.
     *
     * @param string|null $key the key that identifies the CSS script file. If null, it will use
     * $url as the key. If two CSS files are registered with the same key, the latter
     * will overwrite the former.
     * @throws InvalidConfigException
     */
    public function registerCssFile($url, $options = [], $key = null)
    {
        $options['nonce'] = $GLOBALS['nonce'];
        $this->registerFile('css', $url, $options, $key);
    }

    /**
     * Registers a JS code block.
     * @param string $js the JS code block to be registered
     * @param int $position the position at which the JS script tag should be inserted
     * in a page. The possible values are:
     *
     * - [[POS_HEAD]]: in the head section
     * - [[POS_BEGIN]]: at the beginning of the body section
     * - [[POS_END]]: at the end of the body section
     * - [[POS_LOAD]]: enclosed within jQuery(window).load().
     *   Note that by using this position, the method will automatically register the jQuery js file.
     * - [[POS_READY]]: enclosed within jQuery(document).ready(). This is the default value.
     *   Note that by using this position, the method will automatically register the jQuery js file.
     *
     * @param string|null $key the key that identifies the JS code block. If null, it will use
     * $js as the key. If two JS code blocks are registered with the same key, the latter
     * will overwrite the former.
     */
    public function registerJs($js, $position = self::POS_READY, $key = null)
    {
        $key = $key ?: md5($js);
        $this->js[$position][$key] = $js;
        if ($position === self::POS_READY || $position === self::POS_LOAD) {
            JqueryAsset::register($this);
        }
    }

    /**
     * Registers a JS or CSS file.
     *
     * @param string $url the JS file to be registered.
     * @param string $type type (js or css) of the file.
     * @param array $options the HTML attributes for the script tag. The following options are specially handled
     * and are not treated as HTML attributes:
     *
     * - `depends`: array, specifies the names of the asset bundles that this CSS file depends on.
     * - `appendTimestamp`: bool whether to append a timestamp to the URL.
     *
     * @param string|null $key the key that identifies the JS script file. If null, it will use
     * $url as the key. If two JS files are registered with the same key at the same position, the latter
     * will overwrite the former. Note that position option takes precedence, thus files registered with the same key,
     * but different position option will not override each other.
     * @throws InvalidConfigException
     */
    private function registerFile($type, $url, $options = [], $key = null)
    {
        $url = Yii::getAlias($url);
        $key = $key ?: $url;
        $depends = ArrayHelper::remove($options, 'depends', []);
        $originalOptions = $options;
        $position = ArrayHelper::remove($options, 'position', self::POS_END);

        try {
            $assetManagerAppendTimestamp = $this->getAssetManager()->appendTimestamp;
        } catch (InvalidConfigException $e) {
            $depends = null; // the AssetManager is not available
            $assetManagerAppendTimestamp = false;
        }
        $appendTimestamp = ArrayHelper::remove($options, 'appendTimestamp', $assetManagerAppendTimestamp);

        if ($this->isPageEnded) {
            Yii::warning('You\'re trying to register a file after View::endPage() has been called.');
        }

        if (empty($depends)) {
            // register directly without AssetManager
            if ($appendTimestamp && Url::isRelative($url)) {
                $prefix = Yii::getAlias('@web');
                $prefixLength = strlen($prefix);
                $trimmedUrl = ltrim((substr($url, 0, $prefixLength) === $prefix) ? substr($url, $prefixLength) : $url, '/');
                $timestamp = @filemtime(Yii::getAlias('@webroot/' . $trimmedUrl, false));
                if ($timestamp > 0) {
                    $url = $timestamp ? "$url?v=$timestamp" : $url;
                }
            }
            if ($type === 'js') {
                $this->jsFiles[$position][$key] = CustomBaseHtml::jsFile($url, $options);
            } else {
                $this->cssFiles[$key] = CustomBaseHtml::cssFile($url, $options);
            }
        } else {
            $this->getAssetManager()->bundles[$key] = Yii::createObject([
                'class' => AssetBundle::className(),
                'baseUrl' => '',
                'basePath' => '@webroot',
                (string)$type => [ArrayHelper::merge([!Url::isRelative($url) ? $url : ltrim($url, '/')], $originalOptions)],
                "{$type}Options" => $options,
                'depends' => (array)$depends,
            ]);
            $this->registerAssetBundle($key);
        }
    }

    /**
     * Registers a JS file.
     *
     * This method should be used for simple registration of JS files. If you want to use features of
     * [[AssetManager]] like appending timestamps to the URL and file publishing options, use [[AssetBundle]]
     * and [[registerAssetBundle()]] instead.
     *
     * @param string $url the JS file to be registered.
     * @param array $options the HTML attributes for the script tag. The following options are specially handled
     * and are not treated as HTML attributes:
     *
     * - `depends`: array, specifies the names of the asset bundles that this JS file depends on.
     * - `position`: specifies where the JS script tag should be inserted in a page. The possible values are:
     *     * [[POS_HEAD]]: in the head section
     *     * [[POS_BEGIN]]: at the beginning of the body section
     *     * [[POS_END]]: at the end of the body section. This is the default value.
     * - `appendTimestamp`: bool whether to append a timestamp to the URL.
     *
     * Please refer to [[Html::jsFile()]] for other supported options.
     *
     * @param string|null $key the key that identifies the JS script file. If null, it will use
     * $url as the key. If two JS files are registered with the same key at the same position, the latter
     * will overwrite the former. Note that position option takes precedence, thus files registered with the same key,
     * but different position option will not override each other.
     * @throws InvalidConfigException
     */
    public function registerJsFile($url, $options = [], $key = null)
    {
        $options['nonce'] = $GLOBALS['nonce'];
        $this->registerFile('js', $url, $options, $key);
    }

    /**
     * Registers a JS code block defining a variable. The name of variable will be
     * used as key, preventing duplicated variable names.
     *
     * @param string $name Name of the variable
     * @param array|string $value Value of the variable
     * @param int $position the position in a page at which the JavaScript variable should be inserted.
     * The possible values are:
     *
     * - [[POS_HEAD]]: in the head section. This is the default value.
     * - [[POS_BEGIN]]: at the beginning of the body section.
     * - [[POS_END]]: at the end of the body section.
     * - [[POS_LOAD]]: enclosed within jQuery(window).load().
     *   Note that by using this position, the method will automatically register the jQuery js file.
     * - [[POS_READY]]: enclosed within jQuery(document).ready().
     *   Note that by using this position, the method will automatically register the jQuery js file.
     *
     * @since 2.0.14
     */
    public function registerJsVar($name, $value, $position = self::POS_HEAD)
    {
        $js = sprintf('var %s = %s;', $name, \yii\helpers\Json::htmlEncode($value));
        $this->registerJs($js, $position, $name);
    }

    /**
     * Renders the content to be inserted in the head section.
     * The content is rendered using the registered meta tags, link tags, CSS/JS code blocks and files.
     * @return string the rendered content
     */
    protected function renderHeadHtml()
    {
        $lines = [];
        if (!empty($this->metaTags)) {
            $lines[] = implode("\n", $this->metaTags);
        }

        if (!empty($this->linkTags)) {
            $lines[] = implode("\n", $this->linkTags);
        }
        if (!empty($this->cssFiles)) {
            $lines[] = implode("\n", $this->cssFiles);
        }
        if (!empty($this->css)) {
            $lines[] = implode("\n", $this->css);
        }
        if (!empty($this->jsFiles[self::POS_HEAD])) {
            $lines[] = implode("\n", $this->jsFiles[self::POS_HEAD]);
        }
        if (!empty($this->js[self::POS_HEAD])) {
            $lines[] = CustomBaseHtml::script(implode("\n", $this->js[self::POS_HEAD]));
        }

        return empty($lines) ? '' : implode("\n", $lines);
    }

    /**
     * Renders the content to be inserted at the beginning of the body section.
     * The content is rendered using the registered JS code blocks and files.
     * @return string the rendered content
     */
    protected function renderBodyBeginHtml()
    {
        $lines = [];
        if (!empty($this->jsFiles[self::POS_BEGIN])) {
            $lines[] = implode("\n", $this->jsFiles[self::POS_BEGIN]);
        }
        if (!empty($this->js[self::POS_BEGIN])) {
            $lines[] = CustomBaseHtml::script(implode("\n", $this->js[self::POS_BEGIN]));
        }

        return empty($lines) ? '' : implode("\n", $lines);
    }

    /**
     * Renders the content to be inserted at the end of the body section.
     * The content is rendered using the registered JS code blocks and files.
     * @param bool $ajaxMode whether the view is rendering in AJAX mode.
     * If true, the JS scripts registered at [[POS_READY]] and [[POS_LOAD]] positions
     * will be rendered at the end of the view like normal scripts.
     * @return string the rendered content
     */
    protected function renderBodyEndHtml($ajaxMode)
    {
        $lines = [];

        if (!empty($this->jsFiles[self::POS_END])) {
            $lines[] = implode("\n", $this->jsFiles[self::POS_END]);
        }

        if ($ajaxMode) {
            $scripts = [];
            if (!empty($this->js[self::POS_END])) {
                $scripts[] = implode("\n", $this->js[self::POS_END]);
            }
            if (!empty($this->js[self::POS_READY])) {
                $scripts[] = implode("\n", $this->js[self::POS_READY]);
            }
            if (!empty($this->js[self::POS_LOAD])) {
                $scripts[] = implode("\n", $this->js[self::POS_LOAD]);
            }
            if (!empty($scripts)) {
                $lines[] = CustomBaseHtml::script(implode("\n", $scripts));
            }
        } else {
            if (!empty($this->js[self::POS_END])) {
                $lines[] = CustomBaseHtml::script(implode("\n", $this->js[self::POS_END]));
            }
            if (!empty($this->js[self::POS_READY])) {
                $js = "jQuery(function ($) {\n" . implode("\n", $this->js[self::POS_READY]) . "\n});";
                $lines[] = CustomBaseHtml::script($js);
            }
            if (!empty($this->js[self::POS_LOAD])) {
                $js = "jQuery(window).on('load', function () {\n" . implode("\n", $this->js[self::POS_LOAD]) . "\n});";
                $lines[] = CustomBaseHtml::script($js);
            }
        }

        return empty($lines) ? '' : implode("\n", $lines);
    }


    public function endBody()
    {
        $this->trigger(self::EVENT_END_BODY);
        echo self::PH_BODY_END;

        foreach (array_keys($this->assetBundles) as $bundle) {
            $this->registerAssetFiles($bundle);
        }

        if (true === $this->enableMinify) {
            (new CSS($this))->export();
            (new JS($this))->export();
        }
    }
    
}
