<?php

namespace frontend\controllers;

use backend\modules\city\models\City;
use backend\modules\countries\models\Country;
use backend\modules\donation_programs\models\DonationProgram;
use backend\modules\dropdown_list\models\DropdownList;
use backend\modules\dropdown_list\models\search\DropdownListSearch;
use backend\modules\bms\models\Bms;
use backend\modules\bms\models\search\BmsSearch;
use backend\modules\annual_report\models\AnnualReport;
use backend\modules\newsletter\models\NewsletterClientList;
use backend\modules\promoted_campaign\models\PromotedCampaign;
use backend\modules\news\models\News;
use common\helpers\Utility;
use frontend\components\classes\CustomErrorAction;
use frontend\widgets\donation_programs\DonationPrograms;
use Mpdf\Tag\U;
use yeesoft\helpers\Html;
use yeesoft\page\models\Page;
use backend\modules\volunteers\models\Volunteers;

use Yii;
use yii\base\DynamicModel;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

;

/**
 * Site controller
 */
class SiteController extends \yeesoft\controllers\BaseController
{
    public $freeAccess = true;


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => CustomErrorAction::class,
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'sitemap' => [
                'class' => 'yeesoft\seo\actions\SitemapAction',
            ],
        ];
    }



    // create site map function 

    /**
     *
     * @return mixed
     */
    public function actionSiteMap()
    {

        return $this->render('site-map');
    }


    public function actionAnalyses($node)
    {
        Yii::$app->language = 'en';
        if ($node == 'nhn-wtsawlat-alshbab')
            return $this->redirect(['/analyses/view', 'slug' => 'youths-queries-us']);

        return $this->goHome();
    }

    /**
     *
     * @return mixed
     */
    private function actionHomepage()
    {
        $lng = Yii::$app->language;
        $this->layout = "main";

        $data['homePageSliders'] =  Bms::find()
        ->activeWithCategory("home-page-sliders-sections")
        ->all();


        $data['homePageFirstSections'] = Bms::find()
        ->activeWithCategory("home-page-first-sections")
        ->all();

        $data['homePageSecondImpactSections'] = Bms::find()
        ->activeWithCategory("home-page-second-impact-sections")
        ->all();

        $data['homePageSupportSections'] = Bms::find()
        ->activeWithCategory("home-page-support-sections")
        ->all();


        $data['latestNews'] =  News::find()
        ->active()
        ->orderBy(['published_at' => SORT_DESC]) 
        ->limit(8)
        ->all();

        $data['DarAbuAbdullahBlocks']= Bms::find()
        ->activeWithCategory("dar-Abu-abdullah-blocks")
        ->all();
                
        $data['DonationPrograms'] = DonationProgram::find()
            ->active()
            ->all();

        $data['homePageLastSection'] = Bms::find()
        ->activeWithCategory("home-page-last-section")
        ->one();

        $data['homePagePromoteSection'] = PromotedCampaign::find()->active()->where(['promoted_to_front'=>PromotedCampaign::STATUS_PUBLISHED])->one();

        return $this->render('homepage',$data);
    }

    public function actionPage($slug)
    {
        $this->layout = 'main-inner';
        $data["bms"] = Bms::find()->active()->andWhere(["slug" => $slug])->one();

        return $this->render("page_bms", $data);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($slug = 'index')
    {
        $lng = Yii::$app->language;

        //try to display action from controller
        try {
            if ($slug == "index") {
                return $this->actionHomepage();
            }
            return $this->runAction($slug, Yii::$app->request->get());
        } catch (\yii\base\InvalidRouteException $ex) {
        }


        //try to display static page from datebase
        $data['page'] = Page::getDb()->cache(function ($db) use ($slug, $lng) {
            return Page::find()
                ->where(['slug' => $slug, Page::tableName() . '.status' => Page::STATUS_PUBLISHED, 'language' => $lng])
                ->joinWith('translations')
                ->one();

        }, 3600);


        if ($data['page']) {
            // $pageAction = new PageAction($slug, $this, [
            //     'slug' => $slug,
            //     'page' => $page,
            //     'view' => $page->view,
            //     'layout' => $page->layout,
            // ]);

            //return $pageAction->run();

            $this->layout = $data['page']->layout;

            return $this->render($data['page']->view, $data);
        }

        //if nothing suitable was found then throw 404 error
        throw new \yii\web\NotFoundHttpException(Yii::t('site', 'Page not found.'));
    }


    public function actionBoardGeneralAssembly(){
        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = 'board-general-assembly';

        $data['boardGeneralAssemblySection'] = Bms::find()
        ->activeWithCategory("board-general-assembly-section")
        ->one();
        
        $data['boardGeneralAssemblySections'] = Bms::find()
        ->activeWithCategory("board-general-assembly-sections")
        ->all();
        



        return $this->render("board_general_assembly",$data);


    }

    public function actionOurProgram(){
        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = 'OurPrograms';

        $data['ourProgramFirstSection']= Bms::find()
        ->activeWithCategory("our-program-first-section")
        ->one();
        

        $data['ourProgramSecondSections']= Bms::find()
        ->activeWithCategory("our-program-second-sections")
        ->all();
        
        

        $data['ourProgramThirdSections']= Bms::find()
        ->activeWithCategory("our-program-third-sections")
        ->all();
        

        return $this->render("our_programs",$data);
    }

    public function actionDonation(){
        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = 'OurPrograms';

        return $this->render("donation_3");

    }


    public  function actionOurImpact()
    {
        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = 'our-impact';

        $data['ourImpactFirstSection'] =  Bms::find()
        ->activeWithCategory("our-impact-first-section")
        ->one();
        

        $data['promotedToOurImpact'] =  AnnualReport::find()
        ->where(['promoted_to_our_impact'=>1])
        ->one();
        

        $data['ourImpactSecondSections'] =  Bms::find()
        ->activeWithCategory("our-impact-second-sections")
        ->all();
        


        return $this->render("our-impact",$data);
    }
    public function actionOurValue(){

        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = 'our-values';
        
        // our values first section
        $data['ourValuesFirstSection']= Bms::find()
        ->activeWithCategory("our-value-first-section")
        ->one();
        
        
        // our values block
        $data['ourValuesBlocks']= Bms::find()
        ->activeWithCategory("our-value-blocks")
        ->all();
        
        
        // our values Last section
        $data['ourValuesLastSection']= Bms::find()
        ->activeWithCategory("our-value-last-section")
        ->one();

        return $this->render("our_value",$data);
    }

    public function actionVolunteer()
    {

        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = 'Volunteer';

        $data['AboutVolunteerFirstSection']= Bms::find()
        ->activeWithCategory("about-volunteer-first-section")
        ->one();
        
        $data['volunteers']= Volunteers::find()
        ->active()
        ->where(['promoted_to_volunteer'=> Volunteers::STATUS_PUBLISHED])
        ->all();

        
        $data['AboutVolunteerThirdSection']= Bms::find()
        ->activeWithCategory("about-volunteer-third-section")
        ->one();


        return $this->render("volunteer",$data);
    }
    public function actionVisionMission(){

        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = 'mission-vision';


        $data['missionVissionFirstSection']= Bms::find()
        ->activeWithCategory("mission-vission-first-section")
        ->one();
                
    
        $data['ourmissionVissionBlocks']= Bms::find()
        ->activeWithCategory("mission-vission-second-section-blocks")
        ->all();
                
    
        $data['ourmissionVissionThirdSection']= Bms::find()
        ->activeWithCategory("mission-vission-third-section")
        ->one();
       
                
      
        $data['ourMissionVissionThirdSectionBlocks']= Bms::find()
        ->activeWithCategory("our-mission-vission-third-section-blocks")
        ->all();

        $data['ourMissionVissionLeftSection']= Bms::find()
        ->activeWithCategory("mission-vission-left-section")
        ->one();
       

        $data['ourMissionVissionAccordings']= Bms::find()
        ->activeWithCategory("mission-vission-accordings")
        ->all();
       


     
        $data['ourMissionVissionLastSection']= Bms::find()
        ->activeWithCategory("our-mission-value-last-section")
        ->one();
       

        return $this->render("vision_mission" , $data);
    }


    public function actionDarAbuAbdullah(){
        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = 'DarAbuAbdullah';


        $data['DarAbuAbdullahFirstSection']= Bms::find()
        ->activeWithCategory("dar-Abu-abdullah-first-section")
        ->one();
                
    
        $data['DarAbuAbdullahBlocks']= Bms::find()
        ->activeWithCategory("dar-Abu-abdullah-blocks")
        ->all();
                
    
        $data['DarAbuAbdullahContentSection']= Bms::find()
        ->activeWithCategory("dar-abu-abdullah-content-section")
        ->one();
       

        return $this->render("dar_abu_abdullah" , $data);
    }
    
    public function actionDonationTool()
    {

        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = 'DonationTools';

        $searchModel = new DropdownListSearch();
        
        $availableAttributeNamesAtFront = 
        [
           "title" => "donationTitle",
        ];
        $params = Utility::newSearchIncludingFilters($availableAttributeNamesAtFront);

        //Clean User Input        
        $params['status'] = Utility::STATUS_PUBLISHED;
        $dataProvider = $searchModel->search(['DropdownListSearch' => $params]);
        $data['searchModel'] = $searchModel;

        $query = $dataProvider->query;
        $query->andWhere(['category'=>DropdownList::DONATION_TOOLS]);
        $query->orderBy(['published_at' => SORT_DESC, "weight"=> SORT_ASC]);

        $countQuery = clone $query;

        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => 1 ,
        ]);

        $data['pagination'] = $pagination;

        //try to display static page from datebase
        $data['donationTools'] = DropdownList::getDb()->cache(function ($db) use ($query, $pagination) {
            return $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        }, 3600);
     

        return $this->render("donation-tool",$data);

    }

    public function actionOurPartner(){
        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = 'DarAbuAbdullah';

        $searchModel = new BmsSearch();
        
        $availableAttributeNamesAtFront = 
        [
            "title" => "ourPartnerTitle",
        ];
        $params = Utility::newSearchIncludingFilters($availableAttributeNamesAtFront);

        //Clean User Input        
        $params['status'] = Utility::STATUS_PUBLISHED;
        $dataProvider = $searchModel->search(['BmsSearch' => $params]);
        $data['searchModel'] = $searchModel;

        $query = $dataProvider->query;
        $query->andWhere(['category_slug' => 'our-partners-sections']);

        $query->orderBy(['published_at' => SORT_DESC, "weight"=> SORT_ASC]);

        $countQuery = clone $query;

        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Yii::$app->settings->get('site.our_partner_page_size', Yii::$app->settings->get('site.default_page_size')),
        ]);

        $data['pagination'] = $pagination;

        //try to display static page from datebase
        $data['ourPartners'] = Bms::getDb()->cache(function ($db) use ($query, $pagination) {
            return $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        }, 3600);
     

        return $this->render("our_partner" , $data);

    }
    
    public function actionOurPartnerNext(){
        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = 'DarAbuAbdullah';

        $ourPartnerTitle = Yii::$app->request->post('ourPartnerTitle');

        $category = DropdownList::find()->where(['dropdown_list.slug'=>$ourPartnerTitle])->one();


        $searchModel = new BmsSearch();
        
        $availableAttributeNamesAtFront = 
        [
          //  "title" => "ourPartnerTitle",
        ];
    
        $params = Utility::newSearchIncludingFilters($availableAttributeNamesAtFront);
 

        //Clean User Input        
        $params['status'] = Utility::STATUS_PUBLISHED;
        $dataProvider = $searchModel->search(['BmsSearch' => $params]);
        $data['searchModel'] = $searchModel;

        $query = $dataProvider->query;
        if($category){
            $categoryId= $category->id;
            $query->andWhere(['our_partner_id' => $categoryId]);

        }
        

        $query->andWhere(['category_slug' => 'our-partners-sections']);

        $query->orderBy(['published_at' => SORT_DESC, "weight"=> SORT_ASC]);

        $countQuery = clone $query;

        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Yii::$app->settings->get('site.our_partner_page_size', Yii::$app->settings->get('site.default_page_size')),
        ]);

        $data['pagination'] = $pagination;

        //try to display static page from datebase
        $data['ourPartners'] = Bms::getDb()->cache(function ($db) use ($query, $pagination) {
            return $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        }, 3600);
     

        
        return $this->renderAjax('our_partner_next', $data);
    }

    public function actionOurStory(){
        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = 'our-story';

        $data['ourStoryFirstSectionWithBackgroundImage']= Bms::find()
        ->activeWithCategory("our-story-first-sections-with-background-image")
        ->one();    

        $data['ourStoryBlocks']= Bms::find()
        ->activeWithCategory("our-story-blocks")
        ->all();    

        return $this->render("our_story" , $data);

    }


    
    
    public function actionNewsletterSubscribe()
    {
        
        Yii::$app->request->enableCsrfValidation = true;

        $client = new NewsletterClientList();
        $client->email = Yii::$app->request->post('email');
        if($client->save())
        {
            $data['success'] = true;
            $data['message'] = Yii::t('site', 'Added Successfully');
        }
        else 
        {
            $errors = $client->getErrors();
            // if there are items in our errors array, return those errors
            $data['success'] = false;
            $data['errors'] = $errors;
        }
        
        return json_encode($data);
        
    }


    public function actionNewsletterConfirm()
    {

        $email = Yii::$app->request->get('email');
        $obj = NewsletterClientList::findOne(['email' => $email]);
        if ($obj) {
            $obj->confirmed = 1;
            $obj->save();
        }

        //$this->layout = 'none';
        return $this->render('system-msg', [ 'title' => Yii::t('site', 'Confirm'), 'msg' => Yii::t('site', 'ConfirmSubscribeMessage')]);


    }


    public function actionNewsletter()
    {
        return $this->render('newsletter', []);

    }

    /**
     * Displays Search page.
     *
     * @return mixed
     */
    public function actionSearch()
    {

        $model = new DynamicModel([
            'body','spacificModel'
        ]);
        $model->addRule('body', 'string',['min'=>0]);
        $model->addRule('spacificModel', 'string');
        $model->addRule(['body', 'spacificModel'], function ($attribute) {
            $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
        });

        //$model->addRule(['spacificModel'], 'in', ['range' => Utility::getSearchModelsWithTitle()]);

        $postData = \Yii::$app->request->post();

        if( $model->load($postData) && $model->validate())
        {

            $body ="";
            $searchSections = [];
            if (array_key_exists("DynamicModel",$postData))
            {
                $body = Html::encode($model->body);
                $spacificModel = Html::encode($model->spacificModel)??null;
                $page = Html::encode(isset($postData["page"])? $postData["page"] : 0  )??0;
                $searchSections = [];
                //var_dump($body);die();


                $models =  Utility::getSearchModels();
                foreach($models as $item)
                {
                  
                    
                        $this->modelsSearch(
                                                $searchSections,
                                                $body,
                                                $item["key"],
                                                $item["model"],
                                                $item["extra_join"],
                                                $item["whatToSearch"],
                                                $item["extra_search"],
                                                $item["title"],
                                                $item["item_title"],
                                                $item["item_brief"],
                                                $item["item_img"],
                                                $item["is_slug_url"],
                                                $item["item_url"],
                                                $page,
                                                $spacificModel
                                            );
                   



                }


            }


            if(Yii::$app->request->isAjax)
            {
                return $this->renderAjax('search_ajax', [
                    "model" => $model,
                    'searchSections' => $searchSections,
                    //'body' => $body,
                ]);
            }
            return $this->render('search', [
                "model" => $model,
                'searchSections' => $searchSections,
                //'body' => $body,
            ]);

        }

        return $this->render('search', [
            "model" => $model,
            //'searchSections' => $searchSections, 
            //'body' => $body,
        ]);

    }

    private function modelsSearch(&$searchSections,$body, $key, $model,$extra_join,$whatToSearch,$extra_search,$section_title,$item_title,$item_brief,$item_img,$is_slug_url,$item_url,$page,$spacificModel)
    {
        if($spacificModel)
        {
            if($spacificModel != $model)
            {
                return ;
            }
        }

        $query = $model::find()->joinWith("translations");
        if($extra_join)
        {
            for($i=0; $i<count($extra_join); $i++)
            {
                $query->joinWith($extra_join[$i]);
            }
        }
        for($i=0; $i<count($whatToSearch); $i++)
        {
            $query->orFilterWhere(['or',['like', $whatToSearch[$i], $body] ]);
        }

        if($extra_search)
        {
            $query = $query->andWhere($extra_search);
        }

        $query->groupBy("id");

        $countQuery = clone $query;
        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Yii::$app->settings->get('site.search_page_size', Yii::$app->settings->get('site.default_page_size')),
        ]);
        $pagination->setPage($page??0);

        $results = $query->offset($pagination->offset)
        ->limit($pagination->limit)
        ->orderBy(['published_at' => SORT_DESC])
        ->all();

        // echo ($query->createCommand()->rawSql);
        // var_dump($results);exit;
        if($results)
        {
            $defaultImg = '/images/logo-op-menu.png';
            $searchSections[$key]=[];
            $searchSections[$key]["title"] = $section_title;
            $searchSections[$key]["items"] = ArrayHelper::toArray($results, [
                $model => [
                    'title'=>function($model) use($item_title){
                        return  $item_title? $model->$item_title??'': '';
                    },
                    'siteUrl'=> function($model) use($is_slug_url,$item_url){
                        if($is_slug_url)
                        {
                            return   $this->getItemUrl($model,$item_url);
                        }
                        else
                        {
                            return Url::to([$item_url]);
                        }

                    },
                    'brief'=>function($model) use($item_brief){
                        return  $item_brief? $model->$item_brief??'': '';
                    },
                    'img'=>function($model) use($defaultImg,$item_img){
                        return  !empty($model->$item_img)? $model->$item_img : $defaultImg;
                    },
                    "date" => function($model) {
                        return isset($model->published_at)?  $model->fullPublishedDate : $model->fullCreatedDate;
                    },
                ],
            ]);

        }

        if($pagination->pageCount-1>$pagination->page)
        {
            $searchSections[$key]["pagination"]["pageCount"] = $pagination->pageCount;
            $searchSections[$key]["pagination"]["page"] = $pagination->page;
        }
        if(isset($searchSections[$key]))
        {
            $searchSections[$key]["model"] = $model;
        }

    }


    private function getItemUrl($model, $item_url)
    {
        return Url::to([$item_url, "slug" => $model->slug]);
    }

}