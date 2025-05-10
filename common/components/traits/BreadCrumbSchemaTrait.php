<?php
namespace common\components\traits;

use Yii;
use common\schemas\BreadCrumbSchema;
use simialbi\yii2\schemaorg\helpers\JsonLDHelper;


trait BreadCrumbSchemaTrait
{
    public function generateBreadSchema($data)
    {
        $breadCrumb = new BreadCrumbSchema();

        $breadCrumb->provider = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
        ];
        $itemListElement = [];
        $position = 1;
        foreach ($data['crumbs'] as $key => $value) {
            $itemListElement[] = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $key,
                'item' => $value,
            ];
            $position++;
        }
        
        if ($data['bread_crumb_title']) {
            $itemListElement[] = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $key,
                'item' => $data['bread_crumb_title'],
            ];
        }

        $breadCrumb->provider['itemListElement'] = $itemListElement;






        JsonLDHelper::add($breadCrumb);
    }
}