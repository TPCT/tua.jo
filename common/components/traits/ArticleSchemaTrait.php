<?php
namespace common\components\traits;

use Yii;
use common\schemas\ArticleSchema;
use simialbi\yii2\schemaorg\helpers\JsonLDHelper;


trait ArticleSchemaTrait
{
    public function generateArticleSchema($targetNew)
    {
        $article = new ArticleSchema();

        $article->provider = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $targetNew->title,
            'description' => $targetNew->brief,
            'image' => $targetNew->image,
        ];

        $article->author = [
            "@type" => "Person",
            "name" => "Admin",
        ];

        $article->publisher = [
            "@type" => "Organization",
            "name" => Yii::$app->settings->get( 'general.title','', Yii::$app->language) ?: Yii::t('site', 'TUKIA_OM_ALI'),
        ];

        $article->datePublished = $targetNew->published_at;
        $article->dateModified = $targetNew->updated_at;
        $article->mainEntityOfPage = 'dasd.com';

        JsonLDHelper::add($article);
    }
}