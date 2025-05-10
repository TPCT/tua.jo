<?php

namespace common\components\behaviors;

use common\jobs\ConvertImageToWebpJob;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class WebpImageBehavior extends Behavior
{

    public $attributes;
    public $config;



    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'generateWebpImage',
            ActiveRecord::EVENT_AFTER_UPDATE => 'generateWebpImage',
        ];
    }

    public function generateWebpImage($event)
    {

        foreach ($this->attributes as $attribute) {
            if ($event->name === ActiveRecord::EVENT_AFTER_UPDATE && !array_key_exists($attribute, $event->changedAttributes)) {
                continue;
            }
            if (isset($this->owner->$attribute) && $this->owner->$attribute) {

                // Queue the WebP conversion
                Yii::$app->masterBackendQueue->push(new ConvertImageToWebpJob([
                    'config' => $this->config + ['src' => $this->owner->$attribute],
                ]));

            }
        }
    }



}
