<?php 
use common\schemas\OrganizitionalSchema;
use common\schemas\ContactPointSchema;

use simialbi\yii2\schemaorg\helpers\JsonLDHelper;



        
$OrganizitionalSchema = new OrganizitionalSchema();

$OrganizitionalSchema->provider = [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name'=> Yii::$app->settings->get( 'general.title','', Yii::$app->language) ?: Yii::t('site', 'TUKIA_OM_ALI') ,
    'description'=> Yii::$app->settings->get( 'general.description','', Yii::$app->language),
    "url" => Yii::$app->urlManager->createAbsoluteUrl(['/site/index']),
    "logo"=> Yii::$app->settings->get('site.logo', null, Yii::$app->language)
];

$OrganizitionalSchema->contactOption = [
    "@type"=> "ContactPoint",
    "telephone"=> Yii::$app->settings->get('site.phone'),  // Replace with your organization's contact number
    "contactType"=> "Customer Service"
    
];

$OrganizitionalSchema->sameAs = [
    Yii::$app->settings->get('site.facebook_link'),
    Yii::$app->settings->get('site.twitter_link'),
    Yii::$app->settings->get('site.linked_in'),
    Yii::$app->settings->get('site.youtube_link'),
    Yii::$app->settings->get('site.instagram_link')
];

$OrganizitionalSchema->address = [
    "@type"=> "PostalAddress",
    "addressLocality"=>  Yii::$app->settings->get('site.address', null, Yii::$app->language),

    "streetAddress"=> Yii::$app->settings->get('site.street_address', null, Yii::$app->language) ,     
    "addressRegion"=> Yii::$app->settings->get('site.address_region', null, Yii::$app->language) ,     
    "postalCode"=> Yii::$app->settings->get('site.postal_code', null, Yii::$app->language) ,   

    "addressCountry"=> "JO" 

];



 JsonLDHelper::add($OrganizitionalSchema);

?>