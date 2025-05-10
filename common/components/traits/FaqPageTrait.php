<?php
namespace common\components\traits;

use Yii;
use common\schemas\FaqSchema;
use simialbi\yii2\schemaorg\helpers\JsonLDHelper;


trait FaqPageTrait
{
    public function generateFaqSchema($faqs)
    {
        $faqSchema = new FaqSchema();
    
        $faqSchema->provider = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [],
        ];
    
        foreach ($faqs as $faq) {
            $faqSchema->provider['mainEntity'][] = [
                '@type' => 'Question',
                'name' => $faq->title,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq->content,
                ],
            ];
        }
    
        JsonLDHelper::add($faqSchema);
    }
}