<?php

namespace common\components\custom_base_html;

use yeesoft\helpers\Html;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\db\ActiveRecordInterface;
use yii\helpers\Url;
use yii\validators\StringValidator;
use yii\web\Request;

/**
 * BaseHtml provides concrete implementation for [[Html]].
 *
 * Do not use BaseHtml. Use [[Html]] instead.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CustomBaseHtml extends Html
{
    
    /**
     * Generates a style tag.
     * @param string $content the style content
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * @return string the generated style tag
     */
    public static function style($content, $options = [])
    {
        $options['nonce'] = $GLOBALS['nonce'];
        return static::tag('style', $content, $options);
    }

    /**
     * Generates a script tag.
     * @param string $content the script content
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * @return string the generated script tag
     */
    public static function script($content, $options = [])
    {
        $options['nonce'] = $GLOBALS['nonce'];
        return static::tag('script', $content, $options);
    }

    /**
     * Generates a link tag that refers to an external CSS file.
     * @param array|string $url the URL of the external CSS file. This parameter will be processed by [[Url::to()]].
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - condition: specifies the conditional comments for IE, e.g., `lt IE 9`. When this is specified,
     *   the generated `link` tag will be enclosed within the conditional comments. This is mainly useful
     *   for supporting old versions of IE browsers.
     * - noscript: if set to true, `link` tag will be wrapped into `<noscript>` tags.
     *
     * The rest of the options will be rendered as the attributes of the resulting link tag. The values will
     * be HTML-encoded using [[encode()]]. If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * @return string the generated link tag
     * @see Url::to()
     */
    public static function cssFile($url, $options = [], $optionLoad="async")
    {
        if (!isset($options['rel'])) {
            $options['rel'] = 'stylesheet';
        }
        $options['href'] = Url::to($url);

        if (isset($options['condition'])) {
            $condition = $options['condition'];
            unset($options['condition']);
            return self::wrapIntoCondition(static::tag('link', '', $options), $condition);
        } elseif (isset($options['noscript']) && $options['noscript'] === true) {
            unset($options['noscript']);
            return '<noscript>' . static::tag('link', '', $options) . '</noscript>';
        }

        $options['nonce'] = $GLOBALS['nonce'];
        $options['async'] = $optionLoad;
        return static::tag('link', '', $options);
    }

    /**
     * Generates a script tag that refers to an external JavaScript file.
     * @param string $url the URL of the external JavaScript file. This parameter will be processed by [[Url::to()]].
     * @param array $options the tag options in terms of name-value pairs. The following option is specially handled:
     *
     * - condition: specifies the conditional comments for IE, e.g., `lt IE 9`. When this is specified,
     *   the generated `script` tag will be enclosed within the conditional comments. This is mainly useful
     *   for supporting old versions of IE browsers.
     *
     * The rest of the options will be rendered as the attributes of the resulting script tag. The values will
     * be HTML-encoded using [[encode()]]. If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * @return string the generated script tag
     * @see Url::to()
     */
    public static function jsFile($url, $options = [], $optionLoad='async')
    {
        $options['src'] = Url::to($url);
        if (isset($options['condition'])) {
            $condition = $options['condition'];
            unset($options['condition']);
            return self::wrapIntoCondition(static::tag('script', '', $options), $condition);
        }

        $options['nonce'] = $GLOBALS['nonce'];
        $options['async'] = $optionLoad;
        return static::tag('script', '', $options);
    }

    /**
     * Wraps given content into conditional comments for IE, e.g., `lt IE 9`.
     * @param string $content raw HTML content.
     * @param string $condition condition string.
     * @return string generated HTML.
     */
    private static function wrapIntoCondition($content, $condition)
    {
        if (strpos($condition, '!IE') !== false) {
            return "<!--[if $condition]><!-->\n" . $content . "\n<!--<![endif]-->";
        }

        return "<!--[if $condition]>\n" . $content . "\n<![endif]-->";
    }
}
