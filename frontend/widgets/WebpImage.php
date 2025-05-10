<?php
/**
 * @link https://www.pelock.com/
 * @copyright Copyright (c) 2021 PELock LLC
 * @license Apache-2.0
 */

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Image optimization widget for Yii2 Framework with auto WebP image format generation from PNG/JPG files.
 *
 * What it does? Instead of static images like this:
 *
 * ```html
 * <img src="/images/product/extra.png" alt="Extra product">
 * ```
 *
 * It will generate an extra WebP image file (in the same directory the provided
 * image is located) and serve it to your browser in HTML code, with a default
 * fallback to the original image for browsers that doesn't support WebP images.
 *
 * Replace your IMG tag within your templates with a call to:
 *
 * ```php
 * <?= \pelock\imgopt\ImgOpt::widget(["src" => "/images/product/extra.png", "alt" => "Extra product" ]) ?>
 * ```
 *
 *  And it will generate a WebP image file (original image is left untouched) and
 *  the following HTML code gets generated:
 *
 * ```html
 * <picture>
 *     <source type="image/webp" srcset="/images/product/extra.webp">
 *     <img src="/images/product/extra.png" alt="Extra product">
 * </picture>
 * ```
 *
 * You can also generate Lightbox (https://lokeshdhakar.com/projects/lightbox2/) friendly images.
 *
 * Instead of:
 *
 * ```html
 * <a href="/images/sunset.jpg" data-lightbox="image-1" data-title="Sunset">
 *     <img src="/images/sunset-thumbnail.jpg" alt="Sunset">
 * </a>
 * ```
 *
 * You can replace it with more compact widget code:
 *
 * ```php
 * <?= \pelock\imgopt\ImgOpt::widget(["lightbox_data" => "image-1", "lightbox_src" => "/images/sunset.jpg', "src" => "/images/sunset-thumbnail.jpg', "alt" => "Sunset" ]) ?>
 * ```
 *
 * And it will generate this HTML code:
 *
 * ```html
 * <a href="/images/sunset.jpg" data-lightbox="image-1" data-title="Sunset">
 *     <picture>
 *         <source type="image/webp" srcset="/images/sunset-thumbnail.webp">
 *         <img src="/images/sunset-thumbnail.png" alt="Sunset">
 *     </picture>
 * </a>
 * ```
 *
 * @property string $src image source relative to the @webroot Yii2 alias (required)
 * @property string $alt image alternative description used as alt="description" property (optional)
 * @property string $css image class list as a string (can contain multiple classes) used as class="one two three..." (optional)
 * @property string $style image custom CSS styles used as style="one; two; three;..." (optional)
 * @property string $loading lazy loading option (auto|lazy|eager) (https://web.dev/browser-level-image-lazy-loading/) (optional)
 * @property string $itemprop use schema itemprop="image" value (optional)
 * @property string $height  height used as height="value" (optional)
 * @property string $width width used as width="value" (optional)
 * @property string $lightbox_data Lightbox attribute data-lightbox="image-1" etc. (optional)
 * @property string $lightbox_src Lightbox HREF to the original image file, if not set $src param will be used (optional)
 * @property string $lightbox_title Lightbox description title, if not set $alt param will be used (optional)
 * @property bool $recreate set to TRUE to recreate the WebP file again (optional)
 * @property bool $forceCreate set to TRUE to forceCreate the WebP file (optional)
 * @property bool $disable set to TRUE to disable WebP images serving (optional)
 *
 * @author Bartosz Wójcik <support@pelock.com>
 */
class WebpImage extends Widget
{
    /**
     * @var string image source relative to the @webroot Yii2 alias (required)
     */
    public $src;
    private $_src_991;
    private $_src_767;

    /**
     * @var string path to the generated WebP file format (short path) or null
     */
    private $_webp_default;
    private $_webp_991;
    private $_webp_767;

    /**
     * @var string image alternative description used as alt="description" property (optional)
     */
    public $alt;

    /**
     * @var string image class list as a string (can contain multiple classes) used as class="one two three..." (optional)
     */
    public $css;

    /**
     * @var string image custom CSS styles used as style="one; two; three;..." (optional)
     */
    public $style;

    /**
     * @var string lazy loading option (auto|lazy|eager) (https://web.dev/browser-level-image-lazy-loading/) (optional)
     */
    public $loading;

    /**
     * @var string use schema itemprop="image" value (optional)
     */
    public $itemprop;

    /**
     * @var string image height used as height="value" (optional)
     */
    public $height;

    /**
     * @var string image width used as width="value" (optional)
     */
    public $width;

    /**
     * @var string Lightbox attribute data-lightbox="image-1" etc. (optional)
     */
    public $lightbox_data;

    /**
     * @var string Lightbox HREF to the original image file, if not set $src param will be used (optional)
     */
    public $lightbox_src;

    /**
     * @var string Lightbox description title, if not set $alt param will be used (optional)
     */
    public $lightbox_title;

    /**
     * @var bool set to TRUE to recreate the WebP file again (optional)
     */
    public $recreate = false;

    /**
    /**
     * @var bool set to TRUE to forceCreate the WebP file (optional)
     */
    public $forceCreate = false;

    /**
     * @var bool set to TRUE to recreate *ALL* of the WebP files again (optional)
     */
    const RECREATE_ALL = false;

    /**
     * @var bool set to TRUE to disable WebP images serving (optional)
     */
    public $disable = false;
    public $customDisable = true;

    /**
     * @var string disable WebP files usages at all (use it for debugging purposes) (optional)
     */
    const DISABLE_WEBP = false;


    /**
     * @var bool disable return html and just return webp image url
     */
    public $just_image = false;


    /**
     * @var string relation prefetch, dns-prefetch, preconnect, preload
     */
    public $rel = "prefetch";


    /**
     * Generates optimized WebP file from the provided image, relative to the
     * Yii2 @webroot file alias.
     *
     * @param string $img Relative path to the image in @webroot Yii2 directory
     * @param bool $recreate Recreate the WebP file again
     * @return string|null Path to the WebP file (relative to @webroot) or null (marks usage of the original image only)
     */
    private function get_or_convert_to_webp($img, $recreate = false, $mediaQuary = "default", $quality = 100, $minimumQuality = 70)
    {
        if (self::DISABLE_WEBP || $this->disable) {
            return null;
        }

        // build full path to the image (relative to the webroot)
        $web_root = Yii::getAlias('@webroot');
        $img_full_path = $web_root . $img;

        // check if the source image exist
        if (file_exists($img_full_path) === false) {
            return null;
        }

        // modification time of the original image
        $img_modification_time = filemtime($img_full_path);

        $original_file_size = filesize($img_full_path);

        if ($original_file_size === 0) {
            return null;
        }

        // get path details (full path & short path details)
        $short_file_info = pathinfo($img);
        $file_info = pathinfo($img_full_path);

        if (!array_key_exists("extension", $file_info)) {
            if (YII_ENV == "dev") {
                var_dump("The image doesn't have extension(this message will not be displayed at production)");
            }
            return null;
        }

        $ext = strtolower($file_info["extension"]);


        $webp_filename_with_extension = $short_file_info["filename"] . "-{$mediaQuary}" . ".webp";

        $webp_short_path = $short_file_info["dirname"] . "/" . $webp_filename_with_extension;
        $webp_full_path = $file_info["dirname"] . "/" . $webp_filename_with_extension;

        // Check if the WebP file already exists
        if (file_exists($webp_full_path) && !$recreate) {
            return $webp_short_path;
        } elseif ($this->forceCreate)//use this param to create from Job, otherwise return same image
        {
            // Queue the WebP conversion
//			Yii::$app->queue->push(new ConvertImageToWebpJob([
//				'recreate' => $recreate,
//				'webp_full_path' => $webp_full_path,
//				'original_file_size' => $original_file_size,
//				'img_modification_time' => $img_modification_time,
//				'ext' => $ext,
//				'img_full_path' => $img_full_path,
//				'quality' => $quality,
//				'webp_short_path' => $webp_short_path,
//				'minimumQuality' => $minimumQuality
//			]));

            echo "Begin converting {$img_full_path}\n";

            // Check if the original image exists
            if (!file_exists($img_full_path)) {
                Yii::error("Original image not found: {$img_full_path}");
                echo "Original image not found\n";
                return null;
            }

            // Handle existing WebP file
            if ($this->recreate === false && file_exists($webp_full_path)) {
                if (filesize($webp_full_path) >= $original_file_size) {
                    echo "WebP file already exists but is larger or equal in size\n";
                    return null;
                }

                $webp_modification_time = filemtime($webp_full_path);

                if ($img_modification_time !== false && $webp_modification_time !== false) {
                    if ($img_modification_time === $webp_modification_time) {
                        echo "WebP file is up-to-date\n";
                        return $webp_short_path;
                    }
                }
            }

            // Load the image based on extension
            if (!$img = $this->loadImage($img_full_path, $ext)) {
                return null;
            }

            // Start converting to WebP

            do {
                imagewebp($img, $webp_full_path, $quality);

                $quality -= 5;

                if ($quality < $minimumQuality) {
                    break;
                }
            } while (filesize($webp_full_path) >= $original_file_size);

            // Release resources
//            imagedestroy($img);

            // Sync modification time
            if ($img_modification_time !== false) {
                touch($webp_full_path, $img_modification_time);
            }

            // Final check: WebP should not be larger than the original
//            Something error happen here, the size of $webp_full_path not calculated correctly
// todo:: check it again
            if (filesize($webp_full_path) >= $original_file_size) {
                echo "WebP file is larger or equal in size\n";
//                unlink($webp_full_path);
//                return null;
            }

            echo "Conversion successful\n";
            return $webp_short_path;

        }

        return $img;


    }

    private function loadImage($img_full_path, $ext)
    {
        try {
            switch ($ext) {
                case 'png':
                    $img = imagecreatefrompng($img_full_path);
                    imagepalettetotruecolor($img);
                    imagealphablending($img, true);
                    imagesavealpha($img, true);
                    break;

                case 'jpg':
                case 'jpeg':
                    $img = imagecreatefromjpeg($img_full_path);
                    imagepalettetotruecolor($img);
                    break;

                case 'gif':
                    $img = imagecreatefromgif($img_full_path);
                    imagepalettetotruecolor($img);
                    break;

                default:
                    Yii::error("Unsupported file extension: {$ext}");
                    echo "Unsupported file extension: {$ext}\n";
                    return false;
            }
        } catch (\Exception $e) {
            Yii::error("Failed to load image: {$e->getMessage()}");
            echo "Failed to load image\n";
            return false;
        }

        return $img;
    }

    public function init()
    {
        parent::init();

        $this->_src_991 = $this->src;
        $this->_src_767 = $this->src;

        $this->_webp_default = $this->get_or_convert_to_webp($this->src ?? '', (self::RECREATE_ALL == true || $this->recreate == true), "default", 100, 70);
        $this->_webp_991 = $this->get_or_convert_to_webp($this->src ?? '', (self::RECREATE_ALL == true || $this->recreate == true), "991", 70, 60);
        $this->_webp_767 = $this->get_or_convert_to_webp($this->src ?? '', (self::RECREATE_ALL == true || $this->recreate == true), "767", 60, 50);

        // handle Lightbox parameters
        if ($this->lightbox_data) {
            // if lightbox source image is not defined
            // use the default image source (you might want
            // to use thumbnail as an image BUT full res
            // image for lightbox presentation)
            if ($this->lightbox_src === null) {
                $this->lightbox_src = $this->src;
            }

            // same for lightbox title
            if ($this->lightbox_title === null) {
                $this->lightbox_title = $this->alt;
            }
        }
    }

    public function run()
    {
        // our unoptimized image (include all the possible attributes)
        $img_default = Html::img($this->src, [

            "class" => $this->css,
            "style" => $this->style,
            "alt" => $this->alt,
            "height" => $this->height,
            "width" => $this->width,
            "loading" => $this->loading,
            "itemprop" => $this->itemprop,
            'rel' => $this->rel
        ]);

        // was WebP image generated from our unoptimized image?
        if ($this->_webp_default) {
            if ($this->just_image) {
                return $this->_webp_default;
            }
            // include it within <picture> tag
            $html = "<picture>";
            $html .= Html::tag("source", [], ["media" => "(max-width:1440px)", "srcset" => $this->_webp_default, "type" => "image/webp", 'rel' => $this->rel]);
            $html .= Html::tag("source", [], ["media" => "(max-width:991px)", "srcset" => $this->_webp_991, "type" => "image/webp", 'rel' => $this->rel]);
            $html .= Html::tag("source", [], ["media" => "(max-width:767)", "srcset" => $this->_webp_767, "type" => "image/webp", 'rel' => $this->rel]);

            // fallback image (unoptimized)
            $html .= $img_default;
            $html .= "</picture>";

        } else {
            if ($this->just_image) {
                return $this->src;
            }
            $html = $img_default;
        }

        // if lightbox attribute is present - wrap the image into a lightbox friendly
        // <a href link
        if ($this->lightbox_data) {
            return Html::a($html, $this->lightbox_src, ["data-lightbox" => $this->lightbox_data, "data-title" => $this->lightbox_title]);
        }

        return $html;
    }

}