<?php

namespace frontend\widgets;

use yeesoft\comments\assets\CommentsAsset;
use yeesoft\comments\Comments as CommentModule;
use yeesoft\comments\Comments as CommentsModule;
use yeesoft\comments\components\CommentsHelper;
use yeesoft\comments\models\Comment;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class Pager extends \yii\base\Widget
{ 

    public $pagination;

    public function init()
    {
        parent::init();

    }

    public function run()
    {

        return $this->render('pager', ['pagination' => $this->pagination]);
    }


}