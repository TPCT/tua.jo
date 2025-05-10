<?php

namespace common\components\behaviors;

use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\SluggableBehavior;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\validators\UniqueValidator;

/**
 * SluggableBehavior automatically fills the specified attribute with a value that can be used a slug in a URL.
 *
 * Note: This behavior relies on php-intl extension for transliteration. If it is not installed it
 * falls back to replacements defined in [[\yii\helpers\Inflector::$transliteration]].
 *
 * To use SluggableBehavior, insert the following code to your ActiveRecord class:
 *
 * ```php
 * use yii\behaviors\SluggableBehavior;
 *
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => SluggableBehavior::class,
 *             'attribute' => 'title',
 *             // 'slugAttribute' => 'slug',
 *         ],
 *     ];
 * }
 * ```
 *
 * By default, SluggableBehavior will fill the `slug` attribute with a value that can be used a slug in a URL
 * when the associated AR object is being validated.
 *
 * Because attribute values will be set automatically by this behavior, they are usually not user input and should therefore
 * not be validated, i.e. the `slug` attribute should not appear in the [[\yii\base\Model::rules()|rules()]] method of the model.
 *
 * If your attribute name is different, you may configure the [[slugAttribute]] property like the following:
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => SluggableBehavior::class,
 *             'slugAttribute' => 'alias',
 *         ],
 *     ];
 * }
 * ```
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 2.0
 */
class CustomSluggableBehaviorForArabic extends SluggableBehavior
{

    public $modelLang;
    public $customSlugAttribute;
    
    /**
     * This method is called by [[getValue]] to generate the slug.
     * You may override it to customize slug generation.
     * The default implementation calls [[\yii\helpers\Inflector::slug()]] on the input strings
     * concatenated by dashes (`-`).
     * @param array $slugParts an array of strings that should be concatenated and converted to generate the slug value.
     * @return string the conversion result.
     */
    protected function generateSlug($slugParts)
    {
        $slug = self::slug(implode('-', $slugParts));
        if(empty($slug))
        {
            $slug = "فارغ";
        }

        $count = $this->modelLang::find()->andWhere(["like","slug","{$slug}%",false])->count();
        $count++;
        return $count > 0 ? "{$slug}-{$count}" : $slug;

    }



    /**
     * Checks if given slug value is unique.
     * @param string $slug slug value
     * @return bool whether slug is unique.
     */
    protected function validateSlug($slug)
    {
        /* @var $validator UniqueValidator */
        /* @var $model BaseActiveRecord */
        $validator = Yii::createObject(array_merge(
            [
                'class' => UniqueValidator::className(),
            ],
            $this->uniqueValidator
        ));

        $model = new $this->modelLang;
        $model->clearErrors();
        $model->{$this->customSlugAttribute} = $slug;

        $validator->validateAttribute($model, $this->customSlugAttribute);
        return !$model->hasErrors();
    }


    /**
     * Returns a string with all spaces converted to given replacement,
     * non word characters removed and the rest of characters transliterated.
     *
     * If intl extension isn't available uses fallback that converts latin characters only
     * and removes the rest. You may customize characters map via $transliteration property
     * of the helper.
     *
     * @param string $string An arbitrary string to convert
     * @param string $replacement The replacement to use for spaces
     * @param bool $lowercase whether to return the string in lowercase or not. Defaults to `true`.
     * @return string The converted string.
     */
    public static function slug($string, $replacement = '-', $lowercase = true)
    {
        if (empty($string)) {
            return (string) $string;
        }


        $string = self::removeArabicDiacritics($string);
        $string = preg_replace('/[^\p{Arabic}0-9_\-\s]/u', '', $string);
        $parts = explode(" ", $string);
        $string = implode("-",$parts);
        $string = trim($string, '-');

        return $lowercase ? strtolower($string) : $string;
    }


    private static function removeArabicDiacritics($string) {
        $diacritics = [
            '/[\x{064B}\x{064C}\x{064D}\x{064E}\x{064F}\x{0650}\x{0651}\x{0652}\x{0653}\x{0654}\x{0655}]/u' => '',
        ];
    
        return preg_replace(array_keys($diacritics), array_values($diacritics), $string);
    }

}
