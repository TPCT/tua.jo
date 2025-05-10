<?php

namespace console\controllers;


use backend\modules\city\models\City;
use backend\modules\city\models\CityLang;
use backend\modules\countries\models\Country;
use backend\modules\dropdown_list\models\DropdownList;
use backend\modules\interviews\models\Interviews;
use backend\modules\letters\models\Letters;
use backend\modules\news\models\News;
use backend\modules\speeches\models\Speeches;
use common\helpers\Utility;
use common\models\Countries;
use console\models\InterviewsMigration;
use console\models\InterviewsRows;
use console\models\LettersMigration;
use console\models\LettersRows;
use console\models\NewsMigration;
use console\models\NewsRows;
use console\models\SpeechMigration;
use console\models\SpeechRows;
use DateTime;
use yeesoft\models\User;
use Yii;
use yii\console\Controller;
use yii\db\Exception;
use yii\helpers\Json;

class DataMigrationController extends Controller
{

    public function actionCountries()
    {

        Yii::$app->language = 'en';
        Yii::$app->user->setIdentity(User::findOne(1));

        $countries = [
            ['الجزائر', 'Algeria'],
            ['جمهورية أرمينيا', 'Armenia'],
            ['أستراليا', 'Australia'],
            ['أذربيجان', 'Azerbaijan'],
            ['قبرص', 'Cyprus'],
            ['اليونان', 'Greece'],
            ['الهند', 'India'],
            ['العراق', 'Iraq'],
            ['أيرلندا', 'Ireland'],
//            ['الأردن', 'Jordan'],
            ['كينيا', 'Kenya'],
            ['النرويج', 'Norway'],
            ['الباكستان', 'Pakistan'],
            ['بولندا', 'Poland'],
            ['رواندا', 'Rwanda'],
            ['تونس', 'Tunisia'],
            ['الفاتيكان', 'Vatican']
        ];

        $countries = [
            ['ألبانيا', NULL],
            ['ألمانيا', NULL],
            ['اسبانيا', NULL],
//            ['الأردن', NULL],
            ['الإمارات العربية المتحدة', NULL],
            ['البحرين', NULL],
            ['الشيشان', NULL],
            ['الضفة الغربية', NULL],
            ['الكويت', NULL],
            ['المغرب', NULL],
            ['المكسيك', NULL],
            ['المملكة العربية السعودية', NULL],
            ['المملكة المتحدة', NULL],
            ['النمسا', NULL],
            ['الولايات المتحدة الأميركية', NULL],
            ['اليابان', NULL],
            ['اندونيسيا', NULL],
            ['اوكرانيا', NULL],
            ['ايطاليا', NULL],
            ['بلجيكا', NULL],
            ['تايلند', NULL],
            ['تركيا', NULL],
            ['جمهورية الصين الشعبية', NULL],
            ['جمهورية بيرو', NULL],
            ['جمهورية مصر العربية', NULL],
            ['روسيا', NULL],
            ['سلطنة عمان', NULL],
            ['سويسرا', NULL],
            ['فرنسا', NULL],
            ['قطر', NULL],
            ['كازاخستان', NULL],
            ['كندا', NULL],
            ['كوريا الجنوبية', NULL],
            ['كوسوفو', NULL],
            ['ليبيا', NULL],
            ['هايتي', NULL],
            ['هنغاريا', NULL],
            ['هولندا', NULL],
        ];

        foreach ($countries as $country) {
            $enCountry = Countries::findOne(['ar_short_name' => $country[0]]);
            $dropdown = new Country();
            $dropdown->title_ar = $country[0];  // Arabic name
            $dropdown->title = $enCountry ? $enCountry->en_short_name : '-';  // English name
            $dropdown->status = Utility::STATUS_PUBLISHED;  // English name

            if ($dropdown->save()) {
                echo "Successfully inserted: {$country[1]}\n";
            } else {
                echo "Error inserting: {$country[1]}\n";
                var_dump($dropdown->getErrors());
            }
        }
    }

    public function actionIndex()
    {


    }


    public function actionNews()
    {
        set_time_limit(0);
        ini_set('memory_limit', '2000M');


        Yii::$app->language = 'en';

        $filePath = Yii::getAlias('@app/../misc/News-B2.json');

        if (!file_exists($filePath)) {
            var_dump("File not found: " . $filePath . "\n");
            return;
        }

        // Read the JSON file
        $jsonData = file_get_contents($filePath);
        $newsItems = Json::decode($jsonData, true);

        if (empty($newsItems)) {
            var_dump("No data to import.\n");
            return;
        }

        NewsMigration::deleteAll();
        NewsRows::deleteAll();
//        News::deleteAll();
        foreach ($newsItems['RECORDS'] as $newsItem) {

            $news = new NewsMigration();

            // Map fields from JSON to News model attributes

            $news->load(['NewsMigration' => $newsItem], 'NewsMigration');

            $date = DateTime::createFromFormat('d/m/Y H:i:s', $newsItem['field_date']);
            $formattedDate = $date->format('Y-m-d H:i:s'); // Convert to MySQL-friendly format

            $news->field_date = \Yii::$app->formatter->asTimestamp($formattedDate);
            // Other fields if required (e.g., Weight) can be handled here

            // Save the News model
            if ($news->save()) {
                var_dump("Imported news: {$news->nid}\n");

            } else {
                var_dump("Failed to import news: {$news->nid}\n");
//                var_dump($news->published_at);die();
                var_dump("Errors: " . print_r($news->getErrors(), true) . "\n");
                die();
            }

            Yii::setLogger(new Yii::$app->EmptyLogger());

        }

        $migratedNews = NewsMigration::find()
//            ->andWhere(['nid' => [58494]])
            ->all();
        foreach ($migratedNews as $index => $migratedNew) {
            var_dump($index);
            $jsonEn = $jsonAr = $nid = $tnid = $title_en = $title_ar = null;

            try {
                if ($migratedNew->language == 'ar') {
                    if (NewsRows::findOne(['tnid' => $migratedNew->nid])) continue;
                    if (NewsRows::findOne(['nid' => $migratedNew->nid])) continue;
                    $jsonAr = json_encode($migratedNew->attributes);
                    $title_ar = $migratedNew->title;
                    if ($migratedNew->tnid) {
                        $enNews = NewsMigration::findOne(['language' => 'en', 'tnid' => $migratedNew->tnid]);
                        $jsonEn = json_encode($enNews ? $enNews->attributes : []);
                        $title_en = $enNews ? $enNews->title : null;
                        $tnid = $enNews ? $enNews->nid : null;
                    }
                    $nid = $migratedNew->nid;
                } elseif ($migratedNew->language == 'en') {
                    if (NewsRows::findOne(['tnid' => $migratedNew->nid])) continue;
                    if (NewsRows::findOne(['nid' => $migratedNew->nid])) continue;
                    $title_en = $migratedNew->title;
                    if ($migratedNew->tnid) {
                        $arNews = NewsMigration::findOne(['language' => 'ar', 'tnid' => $migratedNew->tnid]);
                        $jsonAr = json_encode($arNews ? $arNews->attributes : []);
                        $title_ar = $arNews ? $arNews->title : null;
                        $nid = $migratedNew->tnid;
                        $tnid = $arNews ? $arNews->nid : null;
                    } else {
                        $nid = $migratedNew->nid;
                    }
                    $jsonEn = json_encode($migratedNew->attributes);

                }
            } catch (\Exception $exception) {
                var_dump($exception->getMessage());
                var_dump($migratedNew->attributes);
                die();
            }


            $newsRow = new NewsRows();
            $newsRow->title_ar = $title_ar;
            $newsRow->title_en = $title_en;
            $newsRow->nid = $nid;
            $newsRow->tnid = $tnid;
            $newsRow->json_en = $jsonEn;
            $newsRow->json_ar = $jsonAr;

            if (!$newsRow->save()) {
                var_dump($newsRow->getErrors());
                var_dump($migratedNew->nid, $migratedNew->tnid, $tnid);
//                die();
            }


        }

        var_dump("News import completed.\n");

        Yii::$app->user->setIdentity(User::findOne(1));

        set_time_limit(0);
        ini_set('memory_limit', '2000M');

        Yii::$app->language = 'en';

        $countryMap = [
            'Egypt' => 'Arab Republic of Egypt',
            'Oman' => 'Sultanate of Oman',
            'Russia' => 'Russian Federation',
            'The Netherlands' => 'Netherlands',
            'UK' => 'United Kingdom',
            'United Arab Emarites' => 'United Arab Emirates',
            'US' => 'United States of America'
        ];
//        News::deleteAll();
        foreach (NewsRows::find()->batch(100) as $newsItems) {
            foreach ($newsItems as $index => $newsItem) {

                var_dump($index);
                $newsItemAr = json_decode($newsItem->json_ar ?: '[]', true);
                $newsItemEn = json_decode($newsItem->json_en ?: '[]', true);
                $imagePath = null;
                if (@$newsItemAr['field_image_path']) {

                    $imagePath = str_replace('public://', '', $newsItemAr['field_image_path']);
                    $imagePath = 'https://kingabdullah.jo/sites/default/files/' . rawurlencode($imagePath);
                    $imagePath = ($this->downloadImage($imagePath));
                } elseif (!$imagePath && @$newsItemEn['field_image_path']) {
                    $imagePath = str_replace('public://', '', $newsItemEn['field_image_path']);
                    $imagePath = 'https://kingabdullah.jo/sites/default/files/' . rawurlencode($imagePath);
                    $imagePath = ($this->downloadImage($imagePath));
                }
//var_dump($newsItemEn, $newsItemAr);die();
                $news = new News();
                $news->created_by = 1;
                $news->updated_by = 1;
                if (@$newsItemEn['url_alias']) {
                    $newsItemEn['url_alias'] = str_replace('news/', '', $newsItemEn['url_alias']);
                    $news->slug = $newsItemEn['url_alias'];
                }
                if (@$newsItemAr['url_alias']) {
                    $newsItemAr['url_alias'] = str_replace('news/', '', $newsItemAr['url_alias']);
                    $news->slug_ar = $newsItemAr['url_alias'];
                }
                $news->title = @$newsItemEn['title'];
                $news->title_ar = @$newsItemAr['title'];
                $news->brief = @$newsItemEn['field_summary'];
                $news->brief_ar = @$newsItemAr['field_summary'];
                $news->content = $this->cleanHTML(@$newsItemEn['body'] ?: '');
                $news->content_ar = $this->cleanHTML(@$newsItemAr['body'] ?: '');
                $news->published_at = (@$newsItemEn['field_date'] ? $newsItemEn['field_date'] : @$newsItemAr['field_date']);
                $news->created_at = time();  // Assuming created_at is the current time
                $news->updated_at = time();  // Assuming updated_at is the current time
                $news->category_id = 23;
                $news->reject_note = (@$newsItemAr['nid'] ? $newsItemAr['nid'] : 0) . '|' . (@$newsItemEn['nid'] ? $newsItemEn['nid'] : 0);
//            $news->country = $newsItem['Country'];

                if (isset($countryMap[@$newsItemEn['country_name']])) {
                    $newsItemEn['country_name'] = $countryMap[$newsItemEn['country_name']];
                }
                if (isset($countryMap[@$newsItemAr['country_name']])) {
                    $newsItemAr['country_name'] = $countryMap[$newsItemAr['country_name']];
                }

                $country = Country::find()->joinWith('translations')->andWhere(['title' => trim(@$newsItemEn['country_name'] ? $newsItemEn['country_name'] : (@$newsItemAr['country_name']?:'')), 'language' => ['ar', 'en']])->one();
                $news->country_id = $country ? $country->id : null;

                $city = City::find()->joinWith('translations')->andWhere(['title' => trim(@$newsItemEn['city_name'] ? $newsItemEn['city_name'] : $newsItemAr['city_name']), 'language' => ['ar', 'en']])->one();
                if(!$city){
                    $city = new City();
                    $city->title = @$newsItemEn['city_name']?:@$newsItemAr['city_name'];
                    $city->title_ar = @$newsItemAr['city_name'];
                    $city->country_id = $news->country_id;
                    if(!$city->save()){
                        var_dump($city->getErrors());
                    }
                    $city->refresh();
                    $news->city_id = $city->id;
                }else{

//                    if(!$city->title)
//                        $city->title = @$newsItemEn['city_name'];
//                    if(!$city->title_ar)
//                        $city->title_ar = @$newsItemAr['city_name'];
//                    if(!$city->country_id)
//                        $city->country_id = $news->country_id;
//                    if(!$city->save()){
//                        var_dump($city->attributes(), $city->getErrors());
//                    }
//                    $city->refresh();
                    $news->city_id = $city ? $city->id : null;
                }


//            $news->source = $newsItem['Source'];
//            $news->footer = $newsItem['Footer'];
                $news->image = $imagePath; // Handle empty image path

                $news->status = @$newsItemEn['published_status'] ?: 0;
                $news->status_ar = @$newsItemAr['published_status'] ?: 0;

                // Other fields if required (e.g., Weight) can be handled here

                // Save the News model
                try {
                    if ($news->save(false)) {
                        var_dump("Imported news: {$newsItem->nid}\n");
                    } else {
                        var_dump("Failed to import news: {$newsItem->nid}\n");
                        var_dump("Errors: " . print_r($news->getErrors(), true) . "\n");
                    }
                } catch (Exception $exception) {

                }


                unset($newsItem, $newsItemEn, $newsItemAr);
                gc_collect_cycles(); // Trigger garbage collection
//            sleep(rand(1, 2));
                Yii::setLogger(new Yii::$app->EmptyLogger());

            }
            Yii::setLogger(new Yii::$app->EmptyLogger());
        }
        var_dump("News import completed.\n");


    }


    private function downloadImage($url)
    {
        try {
            // Get the file contents from the URL
//            $fileContent = file_get_contents($url);

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => ($url),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_RETURNTRANSFER => true, // Return the response instead of outputting it directly
                CURLOPT_HTTPHEADER => array(
                    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
                    'Accept-Language: en-US,en;q=0.9,ar-JO;q=0.8,ar;q=0.7',
                    'Connection: keep-alive',
                    'Cookie: fpestid=0AEENdn5YcFUauYTd2vF_yJHgIqpaVHbWWRZgZYgTLVKZKGyUNVIKDHzS-YCVOVoUu-HLg; _cc_id=51d3c4e7faa9d0924f54de492b7bea77; _ga=GA1.1.225545767.1728552449; _ga_ZNLT0XDDKL=GS1.1.1729104892.11.0.1729104892.0.0.0',
                    'Sec-Fetch-Dest: document',
                    'Sec-Fetch-Mode: navigate',
                    'Sec-Fetch-Site: none',
                    'Sec-Fetch-User: ?1',
                    'Upgrade-Insecure-Requests: 1',
                    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
                    'sec-ch-ua: "Google Chrome";v="129", "Not=A?Brand";v="8", "Chromium";v="129"',
                    'sec-ch-ua-mobile: ?0',
                    'sec-ch-ua-platform: "macOS"',
                    'token: 397575ee-6dbb-11ef-8000-00155d000705',

                ),
            ));

            $fileContent = curl_exec($curl);
            curl_close($curl);


            // Check if file was successfully downloaded
            if ($fileContent === false) {
                var_dump('Failed to download file from URL: ' . $url);
            }

            // Extract file name from the URL
            $fileName = basename($url);

            // Define the path to temporarily store the file
            $tempFilePath = Yii::getAlias('@runtime/uploads/') . $fileName;

            // Save the file temporarily in the runtime folder
            if (!file_put_contents($tempFilePath, $fileContent)) {
                throw new \Exception('Failed to save downloaded file to: ' . $tempFilePath);
            }

            // Simulate the UploadedFile instance
            $attachment = new \yii\web\UploadedFile([
                'name' => $fileName,
                'tempName' => $tempFilePath,
                'type' => mime_content_type($tempFilePath),
                'size' => filesize($tempFilePath),
                'error' => UPLOAD_ERR_OK,
            ]);

            $routes = [
                'baseUrl' => '', // Base absolute path to web directory
                'basePath' => '@frontend/web', // Base web directory url
                'uploadPath' => 'uploads', // Path for uploaded files in web directory
            ];

            if ($attachment instanceof \yii\web\UploadedFile && $attachment->tempName) {
                // Define your custom Utility method to save the uploaded file
                $media1 = Utility::saveUploadedFile($attachment, $routes);

                @unlink($tempFilePath);

                // Check if the file was successfully uploaded
                if ($media1 && isset($media1->url)) {
                    // Update the attachment property with the file URL
                    return $media1->url;
                }
            }

        } catch (\Exception $e) {
            var_dump($e->getMessage());

        }


    }


    private function cleanHTML($html = '')
    {

        $html = str_replace(['<div>', '</div>'], ['<p>', '</p>'], $html);

        $result = '';
// Split the HTML content by paragraphs
        $paragraphs = explode('</p>', $html);

        if (count($paragraphs) <= 2) {
            $paragraphs = explode('<br />', $html);
        }

        if (count($paragraphs) <= 2) {
            $paragraphs = explode('<br>', $html);
        }

        // Remove empty paragraphs
        $paragraphs = array_filter($paragraphs, function ($para) {
            return trim($para) !== '';
        });

// Add back the closing tag to each paragraph
        $paragraphs = array_map(function ($para) {
            return '<p>' . str_replace(['<p>', '</p>'], '', $para) . '</p>';
        }, $paragraphs);

// Calculate the midpoint to divide the paragraphs
        $half = ceil(count($paragraphs) / 2);

// First half for the first column
        $first_half = array_slice($paragraphs, 0, $half);

// Second half for the second column
        $second_half = array_slice($paragraphs, $half);

        // Output the Bootstrap grid with two columns
        $result .= '<div class="">';
        $result .= implode("\n", $first_half);
        $result .= '</div>';

// Second column
        $result .= '<div class="">';
        $result .= implode("\n", $second_half);
        $result .= '</div>';

        return $result;

    }


    public function actionSpeaches()
    {
        set_time_limit(0);
        ini_set('memory_limit', '2000M');

        $countryMap = [
            'Egypt' => 'Arab Republic of Egypt',
            'Oman' => 'Sultanate of Oman',
            'Russia' => 'Russian Federation',
            'The Netherlands' => 'Netherlands',
            'UK' => 'United Kingdom',
            'United Arab Emarites' => 'United Arab Emirates',
            'US' => 'United States of America'
        ];


        Yii::$app->language = 'en';

        $filePath = Yii::getAlias('@app/../misc/Speeches-B2.json');

        if (!file_exists($filePath)) {
            var_dump("File not found: " . $filePath . "\n");
            return;
        }

        // Read the JSON file
        $jsonData = file_get_contents($filePath);
        $newsItems = Json::decode($jsonData, true);

        if (empty($newsItems)) {
            var_dump("No data to import.\n");
            return;
        }


        SpeechMigration::deleteAll();
        SpeechRows::deleteAll();
        foreach ($newsItems['RECORDS'] as $newsItem) {

            $news = new SpeechMigration();

            // Map fields from JSON to News model attributes

            $news->load(['SpeechMigration' => $newsItem], 'SpeechMigration');

            $date = DateTime::createFromFormat('d/m/Y H:i:s', $newsItem['field_date']);
            $formattedDate = $date->format('Y-m-d H:i:s'); // Convert to MySQL-friendly format

            $news->field_date = \Yii::$app->formatter->asTimestamp($formattedDate);
            // Other fields if required (e.g., Weight) can be handled here

            // Save the News model
            if ($news->save()) {
                var_dump("Imported Speech: {$news->nid}\n");

            } else {
                var_dump("Failed to import Speech: {$news->nid}\n");
//                var_dump($news->published_at);die();
                var_dump("Errors: " . print_r($news->getErrors(), true) . "\n");
                die();
            }

            Yii::setLogger(new Yii::$app->EmptyLogger());

        }

        $migratedNews = SpeechMigration::find()
//            ->andWhere(['nid' => [58494]])
            ->all();
        foreach ($migratedNews as $index => $migratedNew) {
            var_dump($index);
            $jsonEn = $jsonAr = $nid = $tnid = $title_en = $title_ar = null;

            try {
                if ($migratedNew->language == 'ar') {
                    if (SpeechRows::findOne(['tnid' => $migratedNew->nid])) continue;
                    if (SpeechRows::findOne(['nid' => $migratedNew->nid])) continue;
                    $jsonAr = json_encode($migratedNew->attributes);
                    $title_ar = $migratedNew->title;
                    if ($migratedNew->tnid) {
                        $enNews = SpeechMigration::findOne(['language' => 'en', 'tnid' => $migratedNew->tnid]);
                        $jsonEn = json_encode($enNews ? $enNews->attributes : []);
                        $title_en = $enNews ? $enNews->title : null;
                        $tnid = $enNews ? $enNews->nid : null;
                    }
                    $nid = $migratedNew->nid;
                } elseif ($migratedNew->language == 'en') {
                    if (SpeechRows::findOne(['tnid' => $migratedNew->nid])) continue;
                    if (SpeechRows::findOne(['nid' => $migratedNew->nid])) continue;
                    $title_en = $migratedNew->title;
                    if ($migratedNew->tnid) {
                        $arNews = SpeechMigration::findOne(['language' => 'ar', 'tnid' => $migratedNew->tnid]);
                        $jsonAr = json_encode($arNews ? $arNews->attributes : []);
                        $title_ar = $arNews ? $arNews->title : null;
                        $nid = $migratedNew->tnid;
                        $tnid = $arNews ? $arNews->nid : null;
                    } else {
                        $nid = $migratedNew->nid;
                    }
                    $jsonEn = json_encode($migratedNew->attributes);

                }
            } catch (\Exception $exception) {
                var_dump($exception->getMessage());
                var_dump($migratedNew->attributes);
                die();
            }


            $newsRow = new SpeechRows();
            $newsRow->title_ar = $title_ar;
            $newsRow->title_en = $title_en;
            $newsRow->nid = $nid;
            $newsRow->tnid = $tnid;
            $newsRow->json_en = $jsonEn;
            $newsRow->json_ar = $jsonAr;

            if (!$newsRow->save()) {
                var_dump($newsRow->getErrors());
                var_dump($migratedNew->nid, $migratedNew->tnid, $tnid);
//                die();
            } else {
                var_dump($migratedNew->nid . " Speech import completed.\n");
            }


        }

        var_dump("Speech import completed.\n");


        Yii::$app->user->setIdentity(User::findOne(1));

        set_time_limit(0);
        ini_set('memory_limit', '2000M');

        Yii::$app->language = 'en';

//        Speeches::deleteAll();
        foreach (SpeechRows::find()->batch(100) as $newsItems) {
            foreach ($newsItems as $index => $newsItem) {

                var_dump($index);

                $newsItemAr = json_decode($newsItem->json_ar ?: '[]', true);
                $newsItemEn = json_decode($newsItem->json_en ?: '[]', true);
                $videoPath = null;
//                var_dump($newsItemAr, $newsItemEn);
                if (@$newsItemAr['field_videos_path']) {

                    $videoPath = str_replace('youtube://v/', '', $newsItemAr['field_videos_path']);
                    $videoPath = 'https://www.youtube.com/embed/' . rawurlencode($videoPath);
                } elseif (!$videoPath && @$newsItemEn['field_videos_path']) {
                    $videoPath = str_replace('youtube://v/', '', $newsItemEn['field_videos_path']);
                    $videoPath = 'https://www.youtube.com/embed/' . rawurlencode($videoPath);
                }
//var_dump($videoPath);die();
                $news = new Speeches();
                $news->created_by = 1;
                $news->updated_by = 1;
                if (@$newsItemEn['url_alias']) {
                    $newsItemEn['url_alias'] = str_replace('speeches/', '', $newsItemEn['url_alias']);
                    $news->slug = $newsItemEn['url_alias'];
                }
                if (@$newsItemAr['url_alias']) {
                    $newsItemAr['url_alias'] = str_replace('speeches/', '', $newsItemAr['url_alias']);
                    $news->slug_ar = $newsItemAr['url_alias'];
                }
                $news->title = @$newsItemEn['title'];
                $news->title_ar = @$newsItemAr['title'];
                $news->brief = @$newsItemEn['body_summary'];
                $news->brief_ar = @$newsItemAr['body_summary'];
                $news->content = $this->cleanHTML(@$newsItemEn['body'] ?: '');
                $news->content_ar = $this->cleanHTML(@$newsItemAr['body'] ?: '');
                $news->published_at = (@$newsItemEn['field_date'] ? $newsItemEn['field_date'] : @$newsItemAr['field_date']);
                $news->created_at = time();  // Assuming created_at is the current time
                $news->updated_at = time();  // Assuming updated_at is the current time
                switch (@$newsItemAr['field_flag_speeches']) {
                    case 'SpeechesThrone':
                        $news->speech_type_id = 32;
                        break;
                    case 'Speeches':
                        $news->speech_type_id = 31;
                        break;
                    default:
                        $news->speech_type_id = 31;
                        break;
                }
                switch (@$newsItemEn['field_pre_title1']) {
                    case 'Speech from the Throne by His Majesty King Abdullah II':
                        $news->pre_title_id = 30;
                        break;
                    case 'Address by His Majesty King Abdullah II':
                        $news->pre_title_id = 29;
                        break;
                    case 'Remarks by His Majesty King Abdullah II':
                        $news->pre_title_id = 28;
                        break;
                    case 'Speech of His Majesty King Abdullah II':
                        $news->pre_title_id = 27;
                        break;
                    case 'NULL':
                        $news->pre_title_id = 27;
                        break;
                    default:
                        $news->pre_title_id = 27;
                        break;
                }

                $news->reject_note = (@$newsItemAr['nid'] ? $newsItemAr['nid'] : 0) . '|' . (@$newsItemEn['nid'] ? $newsItemEn['nid'] : 0);

                if (isset($countryMap[@$newsItemEn['country_name']])) {
                    $newsItemEn['country_name'] = $countryMap[$newsItemEn['country_name']];
                }
                if (isset($countryMap[@$newsItemAr['country_name']])) {
                    $newsItemAr['country_name'] = $countryMap[$newsItemAr['country_name']];
                }
                $country = Country::find()->joinWith('translations')->andWhere(['title' => trim(@$newsItemEn['country_name'] ? $newsItemEn['country_name'] : (@$newsItemAr['country_name']?:'')), 'language' => ['ar', 'en']])->one();
                $news->country_id = $country ? $country->id : null;

                $city = City::find()->joinWith('translations')->andWhere(['title' => trim(@$newsItemEn['city_name'] ? $newsItemEn['city_name'] : $newsItemAr['city_name']), 'language' => ['ar', 'en']])->one();
                if(!$city){
                    $city = new City();
                    $city->title = @$newsItemEn['city_name'];
                    $city->title_ar = @$newsItemAr['city_name'];
                    $city->country_id = $news->country_id;
                    if(!$city->save()){
                        var_dump($city->getErrors());
                    }
                    $city->refresh();
                    $news->city_id = $city->id;
                }else{
//                    if(!$city->title)
//                        $city->title = @$newsItemEn['city_name'];
//                    if(!$city->title_ar)
//                        $city->title_ar = @$newsItemAr['city_name'];
//                    if(!$city->country_id)
//                        $city->country_id = $news->country_id;
//                    if(!$city->save()){
//                        var_dump($city->getErrors());
//                    }
//                    $city->refresh();
                    $news->city_id = $city->id;

                }


                $news->youtube_link = $videoPath; // Handle empty image path

                $news->status = @$newsItemEn['published_status'] ?: 0;
                $news->status_ar = @$newsItemAr['published_status'] ?: 0;

                // Other fields if required (e.g., Weight) can be handled here

                // Save the News model
                try {
                    if ($news->save(false)) {
                        var_dump("Imported Speeches: {$newsItem->nid}\n");
                    } else {
                        var_dump("Failed to import Speeches: {$newsItem->nid}\n");
                        var_dump("Errors: " . print_r($news->getErrors(), true) . "\n");
                        die();
                    }
                } catch (Exception $exception) {

                }


                unset($newsItem, $newsItemEn, $newsItemAr);
                gc_collect_cycles(); // Trigger garbage collection
//            sleep(rand(1, 2));
                Yii::setLogger(new Yii::$app->EmptyLogger());

            }
            Yii::setLogger(new Yii::$app->EmptyLogger());
        }
        var_dump("Speeches import completed.\n");


    }



    public function actionInterviews()
    {
        set_time_limit(0);
        ini_set('memory_limit', '2000M');


        Yii::$app->language = 'en';

        $filePath = Yii::getAlias('@app/../misc/Interviews.json');

        if (!file_exists($filePath)) {
            var_dump("File not found: " . $filePath . "\n");
            return;
        }

        // Read the JSON file
        $jsonData = file_get_contents($filePath);
        $newsItems = Json::decode($jsonData, true);

        if (empty($newsItems)) {
            var_dump("No data to import.\n");
            return;
        }


        InterviewsMigration::deleteAll();
        InterviewsRows::deleteAll();
//        Interviews::deleteAll();
        foreach ($newsItems['RECORDS'] as $newsItem) {

            $news = new InterviewsMigration();

            // Map fields from JSON to News model attributes

            $news->load(['InterviewsMigration' => $newsItem], 'InterviewsMigration');

            $date = DateTime::createFromFormat('d/m/Y H:i:s', $newsItem['field_date']);
            $formattedDate = $date->format('Y-m-d H:i:s'); // Convert to MySQL-friendly format

            $news->field_date = \Yii::$app->formatter->asTimestamp($formattedDate);
            // Other fields if required (e.g., Weight) can be handled here

            // Save the News model
            if ($news->save()) {
                var_dump("Imported Interviews: {$news->nid}\n");

            } else {
                var_dump("Failed to import Interviews: {$news->nid}\n");
//                var_dump($news->published_at);die();
                var_dump("Errors: " . print_r($news->getErrors(), true) . "\n");
                die();
            }

            Yii::setLogger(new Yii::$app->EmptyLogger());

        }

        $migratedNews = InterviewsMigration::find()
//            ->andWhere(['nid' => [58494]])
            ->all();
        foreach ($migratedNews as $index => $migratedNew) {
            var_dump($index);
            $jsonEn = $jsonAr = $nid = $tnid = $title_en = $title_ar = null;

            try {
                if ($migratedNew->language == 'ar') {
                    if (InterviewsRows::findOne(['tnid' => $migratedNew->nid])) continue;
                    if (InterviewsRows::findOne(['nid' => $migratedNew->nid])) continue;
                    $jsonAr = json_encode($migratedNew->attributes);
                    $title_ar = $migratedNew->title;
                    if ($migratedNew->tnid) {
                        $enNews = InterviewsMigration::findOne(['language' => 'en', 'tnid' => $migratedNew->tnid]);
                        $jsonEn = json_encode($enNews ? $enNews->attributes : []);
                        $title_en = $enNews ? $enNews->title : null;
                        $tnid = $enNews ? $enNews->nid : null;
                    }
                    $nid = $migratedNew->nid;
                } elseif ($migratedNew->language == 'en') {
                    if (InterviewsRows::findOne(['tnid' => $migratedNew->nid])) continue;
                    if (InterviewsRows::findOne(['nid' => $migratedNew->nid])) continue;
                    $title_en = $migratedNew->title;
                    if ($migratedNew->tnid) {
                        $arNews = InterviewsMigration::findOne(['language' => 'ar', 'tnid' => $migratedNew->tnid]);
                        $jsonAr = json_encode($arNews ? $arNews->attributes : []);
                        $title_ar = $arNews ? $arNews->title : null;
                        $nid = $migratedNew->tnid;
                        $tnid = $arNews ? $arNews->nid : null;
                    } else {
                        $nid = $migratedNew->nid;
                    }
                    $jsonEn = json_encode($migratedNew->attributes);

                }
            } catch (\Exception $exception) {
                var_dump($exception->getMessage());
                var_dump($migratedNew->attributes);
                die();
            }


            $newsRow = new InterviewsRows();
            $newsRow->title_ar = $title_ar;
            $newsRow->title_en = $title_en;
            $newsRow->nid = $nid;
            $newsRow->tnid = $tnid;
            $newsRow->json_en = $jsonEn;
            $newsRow->json_ar = $jsonAr;

            if (!$newsRow->save()) {
                var_dump($newsRow->getErrors());
                var_dump($migratedNew->nid, $migratedNew->tnid, $tnid);
//                die();
            } else {
                var_dump($migratedNew->nid . " Interviews import completed.\n");
            }


        }

        var_dump("Interviews import completed.\n");


        Yii::$app->user->setIdentity(User::findOne(1));

        set_time_limit(0);
        ini_set('memory_limit', '2000M');

        Yii::$app->language = 'en';

        $countryMap = [
            'Egypt' => 'Arab Republic of Egypt',
            'Oman' => 'Sultanate of Oman',
            'Russia' => 'Russian Federation',
            'The Netherlands' => 'Netherlands',
            'UK' => 'United Kingdom',
            'United Arab Emarites' => 'United Arab Emirates',
            'US' => 'United States of America'
        ];

        foreach (InterviewsRows::find()->batch(100) as $newsItems) {
            foreach ($newsItems as $index => $newsItem) {

                var_dump($index);

                $newsItemAr = json_decode($newsItem->json_ar ?: '[]', true);
                $newsItemEn = json_decode($newsItem->json_en ?: '[]', true);
                $videoPath = null;
//                var_dump($newsItemAr, $newsItemEn);
                if (@$newsItemAr['field_videos_path']) {

                    $videoPath = str_replace('youtube://v/', '', $newsItemAr['field_videos_path']);
                    $videoPath = 'https://www.youtube.com/embed/' . rawurlencode($videoPath);
                } elseif (!$videoPath && @$newsItemEn['field_videos_path']) {
                    $videoPath = str_replace('youtube://v/', '', $newsItemEn['field_videos_path']);
                    $videoPath = 'https://www.youtube.com/embed/' . rawurlencode($videoPath);
                }
//var_dump($videoPath);die();
                $news = new Interviews();
                $news->created_by = 1;
                $news->updated_by = 1;
                if (@$newsItemEn['url_alias']) {
                    $newsItemEn['url_alias'] = str_replace('interviews/', '', $newsItemEn['url_alias']);
                    $news->slug = $newsItemEn['url_alias'];
                }
                if (@$newsItemAr['url_alias']) {
                    $newsItemAr['url_alias'] = str_replace('interviews/', '', $newsItemAr['url_alias']);
                    $news->slug_ar = $newsItemAr['url_alias'];
                }
                $news->title = @$newsItemEn['title'];
                $news->title_ar = @$newsItemAr['title'];
                $news->brief = @$newsItemEn['body_summary'];
                $news->brief_ar = @$newsItemAr['body_summary'];
                $news->content = $this->cleanHTML(@$newsItemEn['body'] ?: '');
                $news->content_ar = $this->cleanHTML(@$newsItemAr['body'] ?: '');
                $news->published_at = (@$newsItemEn['field_date'] ? $newsItemEn['field_date'] : @$newsItemAr['field_date']);
                $news->created_at = time();  // Assuming created_at is the current time
                $news->updated_at = time();  // Assuming updated_at is the current time


                $news->reject_note = (@$newsItemAr['nid'] ? $newsItemAr['nid'] : 0) . '|' . (@$newsItemEn['nid'] ? $newsItemEn['nid'] : 0);
//            $news->country = $newsItem['Country'];
//                $city = CityLang::findOne(['title' => trim(@$newsItemEn['city_name'] ? $newsItemEn['city_name'] : $newsItemAr['city_name']), 'language' => ['ar', 'en']]);
//                if(!$city){
//                    $city = new City();
//                    $city->title = @$newsItemEn['city_name'];
//                    $city->title_ar = @$newsItemAr['city_name'];
//                    if(!$city->save()){
//                        var_dump($city->getErrors());die();
//                    }
//                    $city->refresh();
//                    $news->city_id = $city->id;
//                }else{
//                    $news->city_id = $city ? $city->city_id : null;
//                }
//
//
//                if (isset($countryMap[$newsItemEn['country_name']])) {
//                    $newsItemEn['country_name'] = $countryMap[$newsItemEn['country_name']];
//                }
//                if (isset($countryMap[$newsItemAr['country_name']])) {
//                    $newsItemAr['country_name'] = $countryMap[$newsItemAr['country_name']];
//                }
//                $country = Country::find()->joinWith('translations')->andWhere(['title' => trim(@$newsItemEn['country_name'] ? $newsItemEn['country_name'] : $newsItemAr['country_name']), 'language' => ['ar', 'en']]);
//                $news->country_id = $country ? $country->parent_id : null;


                $news->youtube_link = $videoPath; // Handle empty image path

                $news->interviewer = @$newsItemEn['field_interviewer_name'];
                $news->interviewer_ar = @$newsItemAr['field_interviewer_name'];
                $news->media_outlet = @$newsItemEn['field_media_outlet_name'];
                $news->media_outlet_ar = @$newsItemAr['field_media_outlet_name'];
                $news->trailer = @$newsItemEn['field_trailer_1']?:@$newsItemAr['field_trailer_1']?:'';
                $news->status = @$newsItemEn['published_status'] ?: 0;
                $news->status_ar = @$newsItemAr['published_status'] ?: 0;

                // Other fields if required (e.g., Weight) can be handled here

                // Save the News model
                try {
                    if ($news->save()) {
                        var_dump("Imported Interviews: {$newsItem->nid}\n");
                    } else {
                        var_dump("Failed to import Interviews: {$newsItem->nid}\n");
                        var_dump("Errors: " . print_r($news->getErrors(), true) . "\n");
//                        die();
                    }
                } catch (Exception $exception) {

                }


                unset($newsItem, $newsItemEn, $newsItemAr);
                gc_collect_cycles(); // Trigger garbage collection
//            sleep(rand(1, 2));
                Yii::setLogger(new Yii::$app->EmptyLogger());

            }
            Yii::setLogger(new Yii::$app->EmptyLogger());
        }
        var_dump("Interviews import completed.\n");


    }


    public function actionLetters()
    {
        set_time_limit(0);
        ini_set('memory_limit', '2000M');


        Yii::$app->language = 'en';

        $filePath = Yii::getAlias('@app/../misc/Letters-B2.json');

        if (!file_exists($filePath)) {
            var_dump("File not found: " . $filePath . "\n");
            return;
        }

        // Read the JSON file
        $jsonData = file_get_contents($filePath);
        $newsItems = Json::decode($jsonData, true);

        if (empty($newsItems)) {
            var_dump("No data to import.\n");
            return;
        }


        LettersMigration::deleteAll();
        LettersRows::deleteAll();
        foreach ($newsItems['RECORDS'] as $newsItem) {

            $news = new LettersMigration();

            // Map fields from JSON to News model attributes

            $news->load(['LettersMigration' => $newsItem], 'LettersMigration');

            $date = DateTime::createFromFormat('d/m/Y H:i:s', $newsItem['field_date']);
            $formattedDate = $date->format('Y-m-d H:i:s'); // Convert to MySQL-friendly format

            $news->field_date = \Yii::$app->formatter->asTimestamp($formattedDate);
            // Other fields if required (e.g., Weight) can be handled here

            // Save the News model
            if ($news->save()) {
                var_dump("Imported Letters: {$news->nid}\n");

            } else {
                var_dump("Failed to import Letters: {$news->nid}\n");
//                var_dump($news->published_at);die();
                var_dump("Errors: " . print_r($news->getErrors(), true) . "\n");
                die();
            }

            Yii::setLogger(new Yii::$app->EmptyLogger());

        }

        $migratedNews = LettersMigration::find()
//            ->andWhere(['nid' => [58494]])
            ->all();
        foreach ($migratedNews as $index => $migratedNew) {
            var_dump($index);
            $jsonEn = $jsonAr = $nid = $tnid = $title_en = $title_ar = null;

            try {
                if ($migratedNew->language == 'ar') {
                    if (LettersRows::findOne(['tnid' => $migratedNew->nid])) continue;
                    if (LettersRows::findOne(['nid' => $migratedNew->nid])) continue;
                    $jsonAr = json_encode($migratedNew->attributes);
                    $title_ar = $migratedNew->title;
                    if ($migratedNew->tnid) {
                        $enNews = LettersMigration::findOne(['language' => 'en', 'tnid' => $migratedNew->tnid]);
                        $jsonEn = json_encode($enNews ? $enNews->attributes : []);
                        $title_en = $enNews ? $enNews->title : null;
                        $tnid = $enNews ? $enNews->nid : null;
                    }
                    $nid = $migratedNew->nid;
                } elseif ($migratedNew->language == 'en') {
                    if (LettersRows::findOne(['tnid' => $migratedNew->nid])) continue;
                    if (LettersRows::findOne(['nid' => $migratedNew->nid])) continue;
                    $title_en = $migratedNew->title;
                    if ($migratedNew->tnid) {
                        $arNews = LettersMigration::findOne(['language' => 'ar', 'tnid' => $migratedNew->tnid]);
                        $jsonAr = json_encode($arNews ? $arNews->attributes : []);
                        $title_ar = $arNews ? $arNews->title : null;
                        $nid = $migratedNew->tnid;
                        $tnid = $arNews ? $arNews->nid : null;
                    } else {
                        $nid = $migratedNew->nid;
                    }
                    $jsonEn = json_encode($migratedNew->attributes);

                }
            } catch (\Exception $exception) {
                var_dump($exception->getMessage());
                var_dump($migratedNew->attributes);
                die();
            }


            $newsRow = new LettersRows();
            $newsRow->title_ar = $title_ar;
            $newsRow->title_en = $title_en;
            $newsRow->nid = $nid;
            $newsRow->tnid = $tnid;
            $newsRow->json_en = $jsonEn;
            $newsRow->json_ar = $jsonAr;

            if (!$newsRow->save()) {
                var_dump($newsRow->getErrors());
                var_dump($migratedNew->nid, $migratedNew->tnid, $tnid);
//                die();
            } else {
                var_dump($migratedNew->nid . " Letters import completed.\n");
            }


        }

        var_dump("Letters import completed.\n");

        Yii::$app->user->setIdentity(User::findOne(1));

        set_time_limit(0);
        ini_set('memory_limit', '2000M');

        Yii::$app->language = 'en';



//        Letters::deleteAll();
        foreach (LettersRows::find()->batch(100) as $newsItems) {
            foreach ($newsItems as $index => $newsItem) {

                var_dump($index);

                $newsItemAr = json_decode($newsItem->json_ar ?: '[]', true);
                $newsItemEn = json_decode($newsItem->json_en ?: '[]', true);


//var_dump($videoPath);die();
                $news = new Letters();
                $news->created_by = 1;
                $news->updated_by = 1;
                if (@$newsItemEn['url_alias']) {
                    $newsItemEn['url_alias'] = str_replace('letters/', '', $newsItemEn['url_alias']);
                    $news->slug = $newsItemEn['url_alias'];
                }
                if (@$newsItemAr['url_alias']) {
                    $newsItemAr['url_alias'] = str_replace('letters/', '', $newsItemAr['url_alias']);
                    $news->slug_ar = $newsItemAr['url_alias'];
                }
                $news->title = @$newsItemEn['title'];
                $news->title_ar = @$newsItemAr['title'];
                $news->brief = @$newsItemEn['body_summary'];
                $news->brief_ar = @$newsItemAr['body_summary'];
                $news->content = $this->cleanHTML(@$newsItemEn['body'] ?: '');
                $news->content_ar = $this->cleanHTML(@$newsItemAr['body'] ?: '');
                $news->published_at = (@$newsItemEn['field_date'] ? $newsItemEn['field_date'] : @$newsItemAr['field_date']);
                $news->created_at = time();  // Assuming created_at is the current time
                $news->updated_at = time();  // Assuming updated_at is the current time


                $news->reject_note = (@$newsItemAr['nid'] ? $newsItemAr['nid'] : 0) . '|' . (@$newsItemEn['nid'] ? $newsItemEn['nid'] : 0);
//

                $news->header_line = @$newsItemEn['field_header_line'];
                $news->header_line_ar = @$newsItemAr['field_header_line'];
                $news->to = @$newsItemEn['field_to'];
                $news->to_ar = @$newsItemAr['field_to'];
                $news->occasion = @$newsItemEn['field_occasion'];
                $news->occasion_ar = @$newsItemAr['field_occasion'];

                $news->trailer = @$newsItemEn['field_trailer_1'];
                $news->trailer_ar = @$newsItemAr['field_trailer_1'];


                $news->category_id = DropdownList::find()->joinWith('translations')
                    ->andWhere(['category' => DropdownList::LETTERS_TYPE,
                        'title' => trim(@$newsItemEn['field_categories_letters'] ? $newsItemEn['field_categories_letters'] : $newsItemAr['field_categories_letters']),
                        'language' => ['ar', 'en']])->one()->id;
//                var_dump($news->category_id, DropdownList::find()->joinWith('translations')->andWhere(['category' => DropdownList::LETTERS_TYPE, 'title' => trim(@$newsItemEn['field_categories_letters'] ? $newsItemEn['field_categories_letters'] : $newsItemAr['field_categories_letters']), 'language' => ['ar', 'en']])->createCommand()->rawSql);die();


                $news->status = @$newsItemEn['published_status'] ?: 0;
                $news->status_ar = @$newsItemAr['published_status'] ?: 0;

                // Other fields if required (e.g., Weight) can be handled here

                // Save the News model
                try {
                    if ($news->save(false)) {
                        var_dump("Imported Letters: {$newsItem->nid}\n");
                    } else {
                        var_dump("Failed to import Letters: {$newsItem->nid}\n");
                        var_dump("Errors: " . print_r($news->getErrors(), true) . "\n");
                        die();
                    }
                } catch (Exception $exception) {
var_dump($exception->getMessage());
                }


                unset($newsItem, $newsItemEn, $newsItemAr);
                gc_collect_cycles(); // Trigger garbage collection
//            sleep(rand(1, 2));
                Yii::setLogger(new Yii::$app->EmptyLogger());

            }
            Yii::setLogger(new Yii::$app->EmptyLogger());
        }
        var_dump("Speeches import completed.\n");


    }


}
