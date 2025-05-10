<?php
/**
 * Created by PhpStorm.
 * User: ajoudeh
 * Date: 7/5/18
 * Time: 10:07 PM
 */

namespace backend\controllers;


class SiteSettingsController extends \yeesoft\settings\controllers\SettingsBaseController
{

    public $modelClass = '\backend\models\SiteSettings';
    public $viewPath   = '@backend/views/site-settings/index';
}
