<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('yeesoft', dirname(dirname(__DIR__)) . '/backend/modules/yeesoft');


$vendorDir = Yii::$aliases['@backend'];

$loader = new \Composer\Autoload\ClassLoader();
$loader->setPsr4('yeesoft\\user\\', $vendorDir . '/modules/yeesoft/yii2-yee-user');
$loader->setPsr4('yeesoft\\translation\\', $vendorDir . '/modules/yeesoft/yii2-yee-translation');
$loader->setPsr4('yeesoft\\settings\\', $vendorDir . '/modules/yeesoft/yii2-yee-settings');
$loader->setPsr4('yeesoft\\seo\\', $vendorDir . '/modules/yeesoft/yii2-yee-seo');
$loader->setPsr4('yeesoft\\post\\', $vendorDir . '/modules/yeesoft/yii2-yee-post');
$loader->setPsr4('yeesoft\\page\\', $vendorDir . '/modules/yeesoft/yii2-yee-page');
$loader->setPsr4('yeesoft\\menu\\', $vendorDir . '/modules/yeesoft/yii2-yee-menu');
$loader->setPsr4('yeesoft\\media\\', $vendorDir . '/modules/yeesoft/yii2-yee-media');
$loader->setPsr4('yeesoft\\generator\\', $vendorDir . '/modules/yeesoft/yii2-yee-generator');
$loader->setPsr4('yeesoft\\comments\\', $vendorDir . '/modules/yeesoft/yii2-comments');
$loader->setPsr4('yeesoft\\comment\\', $vendorDir . '/modules/yeesoft/yii2-yee-comment');
$loader->setPsr4('yeesoft\\auth\\', $vendorDir . '/modules/yeesoft/yii2-yee-auth');
$loader->setPsr4('yeesoft\\', $vendorDir . '/modules/yeesoft/yii2-yee-core');
$loader->register(true);