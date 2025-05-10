<?php
/**
 * Created by PhpStorm.
 * User: ajoudeh
 * Date: 9/23/18
 * Time: 9:06 PM
 */

namespace common\components;

use Solarium\Client;
use yeesoft\comments\models\Comment;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class SolrSearch extends Component
{

    public $options = [];
    /* @var $client Client */
    public $client;

    public function init()
    {
        $this->client = new Client($this->options);
    }

    public function __call($name, $params)
    {
        if(method_exists($this->client, $name)){
            return call_user_func_array([$this->client, $name], $params);
        }
    }

    public function updateDocument($obj){

//         get an update query instance
        $update = $this->client->createUpdate();

// create a new document for the data
        /* @var $document \Solarium\QueryType\Update\Query\Document\Document*/
        $document = $update->createDocument();
        $document->id = $obj->id;
        $document->name = $obj->title;
        $document->name_ar = $obj->title_ar;
        $document->sku = $obj->slug;

        $document->owner_type_i = $obj->owner_type_id;
        $document->owner_type_en = $obj->getOwnerType()->localized('en')->one();
        $document->owner_type_ar = $obj->getOwnerType()->localized('ar')->one();

        $document->manufacturer_facet_i = $obj->manufacturer_id;
        $document->manufacturer_facet_en = $obj->getManufacturer()->localized('en')->one();
        $document->manufacturer_facet_ar = $obj->getManufacturer()->localized('ar')->one();

        $document->body_type_facet_i = $obj->body_type_id;
        $document->body_type_facet_en = $obj->getBodyType()->localized('en')->one();
        $document->body_type_facet_ar = $obj->getBodyType()->localized('ar')->one();


        $document->engine_facet_i = $obj->engine_id;
        $document->engine_facet_en = $obj->getEngine()->localized('en')->one();
        $document->engine_facet_ar = $obj->getEngine()->localized('ar')->one();

        $document->transmission_facet_i = $obj->transmission_id;
        $document->transmission_facet_en = $obj->getTransmission()->localized('en')->one();
        $document->transmission_facet_ar = $obj->getTransmission()->localized('ar')->one();

        $document->color_facet_i = $obj->color_id;
        $document->color_facet_en = $obj->getColor()->localized('en')->one();
        $document->color_facet_ar = $obj->getColor()->localized('ar')->one();

        $document->model_year_i = $obj->model_year;
        $document->price_i = $obj->price;
        $document->dist_km_i = intval($obj->odometer_km ? : ($obj->odometer_mile * 1.60934));
        $document->dist_mile_i = intval($obj->odometer_mile ? : ($obj->odometer_km * 0.621371));




// add the documents and a commit command to the update query
        $update->addDocument($document);
        $update->addCommit();

// this executes the query and returns the result
        $result = $this->client->update($update);
        return $result;
    }


}