<?php

namespace common\components\EmptyLogger;

use yii\log\Logger;

class EmptyLogger extends Logger
{
    public function log($message, $level, $category = 'application')
    {
        return false;
    }
}