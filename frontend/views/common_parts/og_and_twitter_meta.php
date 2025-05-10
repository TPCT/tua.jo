<?php



$currentRoute = Yii::$app->request->getUrl();
$questionMarkExistsWithPostion = strpos($currentRoute, "?");
if( $questionMarkExistsWithPostion)
{
    $currentRoute = substr($currentRoute, 0, strpos($currentRoute, "?"));
}
$url = Yii::$app->urlManager->getHostInfo() .$currentRoute;

$title = !empty($title)? $title : Yii::$app->settings->get('general.title', null, Yii::$app->language);

$description = !empty($description)? $description : Yii::$app->settings->get('general.description', null, Yii::$app->language);

$type = !empty($type)? $type : "website";

if($og_image || !empty($og_image) )
{
    $og_image =   \frontend\widgets\WebpImage::widget([ "src" => $og_image,"just_image" => true]);
    $ext = pathinfo($og_image, PATHINFO_EXTENSION);  
    if($ext == "png")
    {
        $og_image = Yii::$app->settings->get('general.og_image', null, Yii::$app->language);
    }
}
else
{
    $og_image = Yii::$app->settings->get('general.og_image', null, Yii::$app->language);
}

$this->registerMetaTag(['property'=>  'description', 'content'=>$description, 'description']);

$this->registerMetaTag(['property' => 'og:url', 'content' => $url], 'og:url');

$this->registerMetaTag(['property' => 'og:title', 'content' => $title ], 'og:title');
$this->registerMetaTag(['property' => 'og:description', 'content' => $description ], 'og:description');
$this->registerMetaTag(['property' => 'og:updated_time', 'content' => (time())], 'og:updated_time');
$this->registerMetaTag(['property' => 'og:type', 'content' => $type], 'og:type');
$this->registerMetaTag(['property' => 'og:site_name', 'content' => Yii::$app->settings->get('general.title', null, Yii::$app->language) ], 'og:site_name');

$og_image = strtok(Yii::$app->urlManager->createAbsoluteUrl([$og_image]),'?');
$this->registerMetaTag(['property'=>'og:image', 'content'=>$og_image], 'og:image');
$this->registerMetaTag(['itemprop'=>'image', 'content'=>$og_image]);
$this->registerMetaTag(['name' => 'og:image:secure_url', 'content' => $og_image]);
$this->registerMetaTag(['name' => 'og:image:alt', 'content' => $title]);
$this->registerMetaTag(['name' => 'og:logo', 'content' => Yii::$app->settings->get('site.logo', null, Yii::$app->language) ]);


$this->registerMetaTag(['property'=>  'twitter:title', 'content'=>$title, 'twitter:title']);
$this->registerMetaTag(['property'=>  'twitter:description', 'content'=>$description, 'twitter:description']);
$this->registerMetaTag(['property' => 'twitter:site', 'content' => $url, 'twitter:site']);
$this->registerMetaTag(['property' => 'twitter:card', 'content' => $type, 'twitter:card']);
$this->registerMetaTag(['property' => 'twitter:image', 'content' => $og_image, 'twitter:image']);


?>