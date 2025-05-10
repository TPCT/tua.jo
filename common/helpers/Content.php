<?php
/**
 * Created by PhpStorm.
 * User: ajoudeh
 * Date: 7/5/18
 * Time: 11:30 PM
 */

namespace common\helpers;

use DOMDocument;
use ParentIterator;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use yeesoft\media\models\Media;
use yeesoft\page\models\Page;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\Url;

class Content
{

    public static function inlineStyleToClasses($attribute)
    {
        $dom = new DOMDocument();
        if(!$attribute)
        {
            return;
        }
        $dom->loadHTML('<?xml encoding="utf-8"?> ' . $attribute, LIBXML_NOERROR | LIBXML_HTML_NODEFDTD);



        $elements = $dom->getElementsByTagName('*');

        // Create an array to store extracted styles
        $styles = [];

        foreach ($elements as $key => $element) {
            // Check if the element has a 'style' attribute
            if ($element->hasAttribute('style')) 
            {
                // Get the style attribute value
                $styleValue = $element->getAttribute('style');

                // Generate a unique class name
                $uniqeName = self::generateRandomString(5);
                $className = "style-class-{$uniqeName}-" . count($styles);

                // Add the style to the array
                $styles[$className] = $styleValue;

                // Add the class to the element
                $baseclass = $element->getAttribute('class');
                $element->setAttribute('class', $baseclass . ' '.$className);
                $element->removeAttribute("style");

            }
        }



        $nonce = $GLOBALS['nonce'] ;
        $styleElement = $dom->createElement('style');
        $styleElement->setAttribute('nonce',$nonce);
        
        $styleCodes = "";
        foreach ($styles as $className => $style) {
            $styleCodes .= '.' . $className . ' { ' . $style . ' }' . PHP_EOL;
        }
        $styleElement->nodeValue = $styleCodes;
        $dom->appendChild($styleElement);
        
        
        $modifiedHtml = $dom->saveHTML();

        $result = $modifiedHtml . PHP_EOL ;
        
        return $result;


    }


    private static function generateRandomString($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
}