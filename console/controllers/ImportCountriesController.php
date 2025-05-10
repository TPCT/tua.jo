<?php

namespace console\controllers;

use backend\modules\city\models\City;
use backend\modules\countries\models\Country;
use yeesoft\media\models\Media;
use Yii;
use yii\console\Controller;
use yii\helpers\Inflector;

class ImportCountriesController extends Controller
{

    public function actionGenerateCountries(){
        $countries = json_decode(file_get_contents('countries.json'), true);
        $api_countries = json_decode(file_get_contents('api-countries.json'), true)['response'];
        $modified_countries = [];
        foreach ($countries as $country){
            foreach ($api_countries as $api_country){
                if (str_contains($api_country['Name'], $country['name_en'])){
                    $country['guid'] = $api_country['ID'];
                    $modified_countries[] = $country;
                }
            }
        }

        foreach ($modified_countries as $country){
            $model = Country::find()->where(['alpha_2_code' => $country['alpha_2']]);
            $model = $model->exists() ? $model->one() : new Country();
            $model->num_code = $country['phone_code'];
            $model->alpha_2_code = $country['alpha_2'];
            $model->alpha_3_code = $country['alpha_3'];
            $model->en_short_name = $country['name_en'];
            $model->ar_short_name = $country['name_ar'];
            $model->en_nationality = $country['nationality_en'];
            $model->ar_nationality = $country['nationality_ar'];
            $model->guid = $country['guid'];
            $model->save(false);
        }
    }
    public function actionGenerateCities(){
        $countries = json_decode(file_get_contents('modified-countries.json'), true);

        foreach ($countries as $country){
            $model = Country::find()->where(['alpha_2_code' => $country['alpha_2']]);
            if (!$model->exists())
                continue;
            $model = $model->one();
            $capital = $country['capital_info'];
            $city = new City();
            $city->title = $capital['en'];
            $city->title_ar = $capital['ar'];
            $city->slug = Inflector::slug($capital['en']);
            $city->country_id = $model->id;
            $city->save(false);
            echo "<" . $model->en_short_name . "> " . $capital['en'] . "\n";
        }

    }


}
