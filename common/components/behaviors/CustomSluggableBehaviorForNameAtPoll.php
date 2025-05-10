<?php

namespace common\components\behaviors;


use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\SluggableBehavior;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\validators\UniqueValidator;


class CustomSluggableBehaviorForNameAtPoll extends SluggableBehavior
{
    protected function generateSlug($slugParts)
    {
        $string = "";
        if(isset($slugParts[0]))
        {
            $parts = explode(" ", $slugParts[0]);
            $string = implode("_",$parts);
            $string = trim($string, '?');
            $string = trim($string, '_');
        }

        return $string;
    }

    protected function generateUniqueSlug($baseSlug, $iteration)
    {
        if (is_callable($this->uniqueSlugGenerator)) {
            return call_user_func($this->uniqueSlugGenerator, $baseSlug, $iteration, $this->owner);
        }

        return $baseSlug . '_' . ($iteration + 1);
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
    public static function slug($string, $replacement = '_', $lowercase = true)
    {
        if (empty($string)) {
            return (string) $string;
        }

        // $string = preg_replace('/[^\p{Arabic}\s]/u','', $string);
        $parts = explode(" ", $string);
        $string = implode("_",$parts);
        $string = trim($string, '_');
        var_dump("ss");exit;


        return $lowercase ? strtolower($string) : $string;
    }

}
