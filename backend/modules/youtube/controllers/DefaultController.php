<?php

namespace backend\modules\youtube\controllers;

use backend\modules\youtube\models\YoutubeLinks;
use common\components\traits\SaveMulitpleFilesControllerTrait;
use Exception;
use Yii;
use yeesoft\controllers\admin\BaseController;
use yeesoft\media\models\MediaUpload;

/**
 * DefaultController implements the CRUD actions for backend\modules\youtube\models\YoutubeLinks model.
 */
class DefaultController extends BaseController
{

    public $modelClass = 'backend\modules\youtube\models\YoutubeLinks';
    public $modelSearchClass = 'backend\modules\youtube\models\search\YoutubeSearch';

    protected function getRedirectPage($action, $model = null)
    {
        switch ($action) {
            case 'update':
                return ['update', 'id' => $model->id];
                break;
            case 'create':
                return ['update', 'id' => $model->id];
                break;
            default:
                return parent::getRedirectPage($action, $model);
        }
    }

}