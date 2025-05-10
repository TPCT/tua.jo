<?php

namespace common\components\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class ReplacementBehavior extends Behavior
{

    public $attributes;
    public $from;
    public $to;


    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'replaceKeywords',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'replaceKeywords',
        ];
    }

    public function replaceKeywords($event)
    {
        foreach ($this->attributes as $attribute) {
            if (isset($this->owner->$attribute)) {
                $this->owner->$attribute = str_replace($this->from, $this->to, $this->owner->$attribute);
            }
        }
    }



}
