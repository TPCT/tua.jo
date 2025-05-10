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
class CustomSluggableBehaviorForEnglish extends SluggableBehavior
{

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
        $slug = parent::generateSlug($slugParts);
        if(empty($slug))
        {
            $slug = "empty";
        }
        $count = $this->owner::find()->andWhere(["like","slug","{$slug}%",false])->count();
        $count++;
        return $count > 0 ? "{$slug}-{$count}" : $slug;
    }



}
