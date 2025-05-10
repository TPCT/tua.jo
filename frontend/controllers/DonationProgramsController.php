<?php

namespace frontend\controllers;

use backend\modules\bms\models\Bms;
use backend\modules\donation_programs\models\DonationProgram;
use backend\modules\sponsorship_families\models\SponsorshipFamilies;
use frontend\widgets\donation_programs\DonationPrograms;
use Yii;
use backend\modules\blogs\models\Blogs;
use backend\modules\blogs\models\BlogsLang;
use backend\modules\blogs\models\search\BlogsSearch;
use common\helpers\Utility;
use yii\data\Pagination;
use common\components\traits\ArticleSchemaTrait;


/**
 * BlogController
 */
class DonationProgramsController extends \yeesoft\controllers\BaseController
{
    public $freeAccess = true;


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionView($slug)
    {
        $this->view->params['mainIdName'] = "main-donation";
        $donation_program = DonationProgram::find()->active()->where(['slug' => $slug])->one();
        if (!$donation_program) {
            throw new \yii\web\NotFoundHttpException('Page not found.');
        }

        return $this->render('show', [
            'program' => $donation_program,
            'families' => SponsorshipFamilies::find()->active()->all(),
        ]);
    }
}