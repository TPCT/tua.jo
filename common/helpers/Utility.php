<?php
/**
 * Created by PhpStorm.
 * User: ajoudeh
 * Date: 7/5/18
 * Time: 11:30 PM
 */

namespace common\helpers;


//use api\models\ApiLog;
use api\models\ApiLog;
use backend\modules\campaigns\models\Campaign;
use backend\modules\currency\models\Currency;
use backend\modules\donation_programs\models\DonationProgramItem;
use backend\modules\donation_types\models\DonationTypes;
use common\models\Countries;
use ParentIterator;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use yeesoft\media\models\Media;
use backend\modules\news\models\News;
use backend\modules\blogs\models\Blogs;
use backend\modules\offered_tenders\models\OfferedTenders;
use backend\modules\testimonials\models\Testimonials;
use backend\modules\volunteers\models\Volunteers;

use backend\modules\annual_report\models\AnnualReport;
use backend\modules\zakat_stories\models\ZakatStories;

use yeesoft\page\models\Page;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\helpers\Html;

class Utility
{

    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;
    const COMMENT_STATUS_CLOSED = 0;
    const COMMENT_STATUS_OPEN = 1;


    public static function var_dump($data)
    {
        echo highlight_string("<?php\n\n" . var_export($data, true) . ";\n?>");

    }

// Function to get the client ip address
    public static function get_client_ip_address()
    {
        if (@$_SERVER['HTTP_CLIENT_IP'])
        {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        }
        else if (@$_SERVER['HTTP_X_FORWARDED_FOR'])
        {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }    
        else if (@$_SERVER['HTTP_X_FORWARDED'])
        {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        }
        else if (@$_SERVER['HTTP_FORWARDED_FOR'])
        {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        }
        else if (@$_SERVER['HTTP_FORWARDED'])
        {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        }
        else if (@$_SERVER['REMOTE_ADDR'])
        {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        }
        else
        {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }


    public static function textTruncate($text, $chars = 25)
    {
        if (strlen($text) <= $chars) {
            return $text;
        }
        $text = $text . " ";
        $text = substr($text, 0, $chars);
        $text = substr($text, 0, strrpos($text, ' '));
        $text = $text . "...";
        return $text;
    }

    public static function dateDifference($date_1, $date_2, $differenceFormat = '%a')
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);

    }

    public static function create_guid()
    {
        $microTime = microtime();
        list($a_dec, $a_sec) = explode(" ", $microTime);

        $dec_hex = dechex($a_dec * 1000000);
        $sec_hex = dechex($a_sec);

        self::ensure_length($dec_hex, 5);
        self::ensure_length($sec_hex, 6);
        $guid = "";
        $guid .= $dec_hex;
        $guid .= self::create_guid_section(3);
        $guid .= '-';
        $guid .= self::create_guid_section(4);
        $guid .= '-';
//        $guid .= self::create_guid_section(4);
//        $guid .= '-';
//        $guid .= self::create_guid_section(4);
//        $guid .= '-';
        $guid .= $sec_hex;
        $guid .= self::create_guid_section(6);

        return $guid;

    }

    private static function create_guid_section($characters)
    {
        $return = "";
        for ($i = 0; $i < $characters; $i++) {
            $return .= dechex(mt_rand(0, 15));
        }
        return $return;
    }

    private static function ensure_length(&$string, $length)
    {
        $strlen = strlen($string);
        if ($strlen < $length) {
            $string = str_pad($string, $length, "0");
        } else if ($strlen > $length) {
            $string = substr($string, 0, $length);
        }
    }

    public static function getNationalityList()
    {
        return ArrayHelper::map(Countries::find()->asArray()->all(), 'nationality', 'nationality');
    }

    public static function sendEmailToAdmin($model,$emails)
    {
        if(gettype($emails)=="string")//if type string explode to array
        {
            $emails = explode(',', $emails);
            if($emails[0]=="")
            {
                array_shift($emails);
            }
        }
        if($emails)
        {
            if (!$model->sendEmail(array_map('trim', $emails))) 
            {
                //notify admin of error in seding email     
            } 
        }   
    }

    public static function trimParagraph($data){
        $re = '/<p.*?>|<pre.*?>|<\/p>|<\/pre>/m';
        return preg_replace($re, '', $data);
    }


    public static function getYesNoList()
    {
        return [
            1 => Yii::t('site', 'Yes'),
            0 => Yii::t('site', 'No')
        ];
    }

    public static function getGenderList()
    {
        return [
            'Male' => Yii::t('site', 'Male'),
            'Female' => Yii::t('site', 'Female')
        ];
    }

    public static function getMaritalStatus()
    {
        return [
            'Single' => Yii::t('site', 'Single'),
            'Married' => Yii::t('site', 'Married')
        ];
    }


    /**
     * getTypeList
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_PENDING => Yii::t('yee', 'Pending'),
            self::STATUS_PUBLISHED => Yii::t('yee', 'Published'),     
        ];
    }

    /**
     * getStatusOptionsList
     * @return array
     */
    public static function getStatusOptionsList()
    {
        return [
            [self::STATUS_PENDING, Yii::t('yee', 'Pending'), 'default'],
            [self::STATUS_PUBLISHED, Yii::t('yee', 'Published'), 'primary']
        ];
    }


    /**
     * Save just uploaded file
     *
     * @param array $routes routes from module settings
     * @throws \Exception
     */
    public static function saveUploadedFile($file, array $routes, $rename = true, $allowedFileTypes = null, $albumID = null, $description = null)
    {
        $media = new Media();

        $year = date('Y', time());
        $month = date('m', time());
        $structure = "{$routes['baseUrl']}/{$routes['uploadPath']}/$year/$month";
        $basePath = Yii::getAlias($routes['basePath']);
        $absolutePath = "$basePath/$structure";

        // create actual directory structure "yyyy/mm"
        if (!file_exists($absolutePath)) {
            mkdir($absolutePath, 0777, true);
        }
        $media->file = $file;

//        if ($allowedFileTypes === null) {
//            $allowedFileTypes = Yii::$app->getModule('media')->allowedFileTypes;
//        }

//        if (!empty($allowedFileTypes) && is_array($allowedFileTypes) && !in_array($file->type, $allowedFileTypes)) {
//            throw new \Exception(Yii::t('yee/media', 'Sorry, [{filetype}] file type is not permitted!', ['filetype' => $file->type]));
//        }

        //if a file with the same name already exist append a number
        $counter = 0;
        do {
            if ($counter == 0)
                $filename = Inflector::slug($file->baseName) . '.' . $file->extension;
            else {
                //if we don't want to rename we finish the call here
                if ($rename == false) return false;
                $filename = Inflector::slug($file->baseName) . '-' . $counter . '.' . $file->extension;
            }
            $url = "$structure/$filename";
            $counter++;


        } while (Media::findByUrl($url)); // checks for existing url in db
        // save original uploaded file

        /* @var $file UploadedFile */
        $file->saveAs("$absolutePath/$filename", false);
        $media->filename = $filename;
        //Current Language
        $media->title = $filename;
        $media->alt = $filename;
        //Save all languages
        foreach (Yii::$app->yee->languages as $lang => $displayLang) {
            $titleField = 'title_' . $lang;
            $media->$titleField = $filename;
        }
        $media->type = $file->type;
        $media->size = $file->size;
        $media->url = $url;

        if ($albumID) {
            $media->album_id = $albumID;
        }
        if ($description) {
            //Current Language
            $media->description = $description;
            //Save all languages
            foreach (Yii::$app->yee->languages as $lang => $displayLang) {
                $descriptionField = 'description_' . $lang;
                $media->$descriptionField = $description;
            }
        }
        $media->save(false);

//        if($media->isImage()) {
////            $media->createDefaultThumb($routes);
//        }
        return $media;
    }



    public static function array_msort($array, $cols)
    {
        $colarr = array();
        foreach ($cols as $col => $order) {
            $colarr[$col] = array();
            foreach ($array as $k => $row) {
                $colarr[$col]['_' . $k] = strtolower($row[$col]);
            }
        }
        $eval = 'array_multisort(';
        foreach ($cols as $col => $order) {
            $eval .= '$colarr[\'' . $col . '\'],' . $order . ',';
        }
        $eval = substr($eval, 0, -1) . ');';
        eval($eval);
        $ret = array();
        foreach ($colarr as $col => $arr) {
            foreach ($arr as $k => $v) {
                $k = substr($k, 1);
                if (!isset($ret[$k])) $ret[$k] = $array[$k];
                $ret[$k][$col] = $array[$k][$col];
            }
        }
        return $ret;

    }

    /**
     * @return Media
     */
    public static function getThumb($mediaURL)
    {
        return Media::findOne(['url' => $mediaURL]);

    }

    public static function ADD_API_LOG($url, $fields, $currentUser = null)
    {
        //Change me to Database
        $apiLogFile = Yii::$aliases['@api'] . "/runtime/logs/api.log";
        $fh = fopen($apiLogFile, 'a');
        fwrite($fh, self::get_client_ip_address() . chr(10));
        fwrite($fh, date("Y-d-m h:i:s A") . chr(10));
        fwrite($fh, $url . chr(10));
        fwrite($fh, print_r($fields, TRUE) . chr(10));
        fclose($fh);

        //Database
        $log = new ApiLog();
        $log->ip_address = self::get_client_ip_address();
        $log->end_point = $url;
        $log->parameters = print_r($fields, TRUE);
        if ($currentUser) {
            $log->user_id = $currentUser->id;
            $log->auth_key = $currentUser->auth_key;
        }
        $log->save();

    }

    public static function encrypt_decrypt($action, $string)
    {
        /* =================================================
         * ENCRYPTION-DECRYPTION
         * =================================================
         * ENCRYPTION: encrypt_decrypt('encrypt', $string);
         * DECRYPTION: encrypt_decrypt('decrypt', $string) ;
         */
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'H7g5LBU6blxGVeseIUpLRDVZLNdlNTmE';
        $secret_iv = 'eseIUpLRDVZLNdlWTmEVASH7g5LBU6blxGVNLUE';
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ($action == 'encrypt') {
            $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        } else {
            if ($action == 'decrypt') {
                $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
            }
        }
        return $output;
    }


    public static function partition($list, $p) {
        $listlen = count($list);
        $partlen = floor($listlen / $p);
        $partrem = $listlen % $p;
        $partition = array();
        $mark = 0;
        for($px = 0; $px < $p; $px ++) {
            $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
            $partition[$px] = array_slice($list, $mark, $incr);
            $mark += $incr;
        }
        return $partition;
    }



    public static function search_in_array($needle, $haystack)
    {
        $path = array();
        $it = new RecursiveIteratorIterator(
            new ParentIterator(new RecursiveArrayIterator($haystack)),
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($it as $key => $value) {
            if (array_key_exists('url', $value) && strcasecmp($value['url'][0], $needle) === 0) {
                for ($count = $it->getDepth(); $count && $count--;) {
                    array_unshift($path, $it->getSubIterator($count)->key());
                }
                break;
            }
        }
        return $path;
    }

    /**
     * Function to get array keys on either side of a given key. If the
     * initial key is first in the array then prev is null. If the initial
     * key is last in the array, then next is null.
     *
     * If wrap is true and the initial key is last, then next is the first
     * element in the array.
     *
     * If wrap is true and the initial key is first, then prev is the last
     * element in the array.
     *
     * @param array $arr
     * @param string $key
     * @param bool $wrap
     *
     * @return array $return
     */
    public static function array_neighbor( $arr, $key, $wrap = false ) {

//        krsort( $arr );
        $keys       = array_keys( $arr );
        $keyIndexes = array_flip( $keys );

        $return = array();
        if ( isset( $keys[ $keyIndexes[ $key ] - 1 ] ) ) {
            $return['prev'] = $keys[ $keyIndexes[ $key ] - 1 ];
        } else {
            $return['prev'] = null;
        }

        if ( isset( $keys[ $keyIndexes[ $key ] + 1 ] ) ) {
            $return['next'] = $keys[ $keyIndexes[ $key ] + 1 ];
        } else {
            $return['next'] = null;
        }

        if ( false != $wrap && empty( $return['prev'] ) ) {
            $end            = end( $arr );
            $return['prev'] = key( $arr );
        }

        if ( false != $wrap && empty( $return['next'] ) ) {
            $beginning      = reset( $arr );
            $return['next'] = key( $arr );
        }

        return $return;
    }


    //To Solve http in URL
    public static function checkURLSchema($url){


        if(Url::isRelative($url)){
            $url = parse_url($url);
            $query = [];
            if (isset($url['query'])) {
                parse_str($url['query'], $query);
            }
            elseif(isset($url['fragment'])){
                return $url['path'].'#'.$url['fragment'];
            }
            $url = array_merge([@$url['path']], $query);

            
        }

        return $url;

    }

    function highlightWords($text, $word){
        $text = preg_replace('#'. preg_quote($word) .'#i', '<span style="background-color: #F9F902;">\\0</span>', $text);
        return $text;
    }

    public static function PrintAllUrl($url)
    {
        $lng = Yii::$app->language;
        if (is_string($url) && strpos($url, 'http') !== false)
        {
            return " target='blank' rel='noopener noreferrer' hreflang='$lng' href='$url' ";
        }
        else if (is_string($url) && strpos($url, 'mailto:') !== false)
        {
            return " href='mailto:" . $url . "'";
        }
        else if (is_string($url) && strpos($url, 'lang') !== false)
        {
            $url = str_replace("lang", "/" . $lng, $url);
            return "hreflang='$lng' href='" . $url . "'";
        }
        else if (is_string($url) && strpos($url, "#") === 0)
        {
            return "hreflang='$lng' href='$url'";
        }
        else
        {
            $url_array = ['language' => Yii::$app->language];

            // if (!str_contains($url, '/personal/') and !str_contains($url, '/corporate/')) {
            //     $section = Yii::$app->session->get('section') ? Yii::$app->session->get('section') : '/personal/';
            //     $url_array['section'] = $section;
            // }

            if (str_contains($url, '?')){
                $params_array = explode('?', $url);
                $url = $params_array[0];
                $params_array = end($params_array);
                $params_array = explode('&', $params_array);
                foreach ($params_array as $parameter) {
                    $parameter = explode('=', $parameter);
                    $url_array[$parameter[0]] = $parameter[1] ?? '';
                }
            }

            $target = str_contains($url, '.pdf') ? "target='blank'" : '';
            $url = Url::to(array_merge([$url], $url_array));
            $url = str_replace('/site/', '/', $url);
            $url = Html::encode($url);
            return "hreflang='$lng' href='{$url}' {$target} ";
        }

    }


    public static function getModelList($model)
    {
        $items = $model::getDb()->cache(function ($db) use($model) {
            return $model::find()
                    ->orderBy(['id' => SORT_DESC])
                    ->all();
    
        }, 3600);

        return ArrayHelper::map($items,"id","title");
    }

    public static function getActiveModelList($model, $key = 'id')
    {
        $items = $model::getDb()->cache(function ($db) use($model) {
            return $model::find()
                    ->andWhere(['status'=>true])
                    ->orderBy(['id' => SORT_DESC])
                    ->all();
    
        }, 3600);

        return ArrayHelper::map($items, $key, "title");
    }


    public static function getSearchModels()
    {
        return
        [

        
            [
                "key" => "news",
                "model" => News::className(),
                "extra_join" => false,
                "whatToSearch"=>['title','brief'],
                "extra_search"=>[
                    News::tableName().".status"=>Utility::STATUS_PUBLISHED,
                ],
                "title" => Yii::t("site","NEWS"),
                "item_title"=> "title",
                "item_brief"=>"brief",
                "item_img"=>"image",
                "is_slug_url"=>true,
                "item_url"=>"/news/view",
            ],
            [
                "key" => "Blogs",
                "model" => Blogs::className(),
                "extra_join" => false,
                "whatToSearch"=>['title','brief'],
                "extra_search"=>[
                    Blogs::tableName().".status"=>Utility::STATUS_PUBLISHED,
                ],
                "title" => Yii::t("site","BLOGS"),
                "item_title"=> "title",
                "item_brief"=>"brief",
                "item_img"=>"image",
                "is_slug_url"=>true,
                "item_url"=>"/blogs/view",
            ],
            [
                "key" => "OfferedTenders",
                "model" => OfferedTenders::className(),
                "extra_join" => false,
                "whatToSearch"=>['title','brief'],
                "extra_search"=>[
                    OfferedTenders::tableName().".status"=>Utility::STATUS_PUBLISHED,
                ],
                "title" => Yii::t("site","OfferedTenders"),
                "item_title"=> "title",
                "item_brief"=>"brief",
                "item_img"=>"image",
                "is_slug_url"=>true,
                "item_url"=>"/offer-tenders/view",
            ],
            [
                "key" => "annual_report",
                "model" => AnnualReport::className(),
                "extra_join" => false,
                "whatToSearch"=>['title','brief'],
                "extra_search"=>[
                    AnnualReport::tableName().".status"=>Utility::STATUS_PUBLISHED,
                ],
                "title" => Yii::t("site","ANNUAL_REPORT"),
                "item_title"=> "title",
                "item_brief"=>"brief",
                "item_img"=>"image",
                "is_slug_url"=>false,
                "item_url"=>"/annual-report/index",
            ],

            [
                "key" => "Volunteers",
                "model" => Volunteers::className(),
                "extra_join" => false,
                "whatToSearch"=>['title','brief'],
                "extra_search"=>[
                    Volunteers::tableName().".status"=>Utility::STATUS_PUBLISHED,
                ],
                "title" => Yii::t("site","VOLUNTEERS"),
                "item_title"=> "title",
                "item_brief"=>"brief",
                "item_img"=>"image",
                "is_slug_url"=>true,
                "item_url"=>"/volunteer-programs/view",
            ],
            [
                "key" => "Testimonials",
                "model" => Testimonials::className(),
                "extra_join" => false,
                "whatToSearch"=>['title','brief'],
                "extra_search"=>[
                    Testimonials::tableName().".status"=>Utility::STATUS_PUBLISHED,
                ],
                "title" => Yii::t("site","TESTIMONIAL"),
                "item_title"=> "title",
                "item_brief"=>"brief",
                "item_img"=>"image",
                "is_slug_url"=>true,
                "item_url"=>"/testimonials/view",
            ],
            [
                "key" => "ZakatStories",
                "model" => ZakatStories::className(),
                "extra_join" => false,
                "whatToSearch"=>['title','brief'],
                "extra_search"=>[
                    ZakatStories::tableName().".status"=>Utility::STATUS_PUBLISHED,
                ],
                "title" => Yii::t("site","ZAKAT_STORIES"),
                "item_title"=> "title",
                "item_brief"=>"brief",
                "item_img"=>"image",
                "is_slug_url"=>true,
                "item_url"=>"/zakat-stories/view",
            ],


        ];
    }

    public static function getSearchModelsWithTitle()
    {
        return ArrayHelper::map(Utility::getSearchModels(),"model","title");
    }


    const SAT =6;
    const SUN =0;
    const MON =1;
    const TUE =2;
    const WED =3;
    const THU =4;
    const FRI =5;
    public static function getWeekDays()
    {
        return
        [
            self::SAT => Yii::t("site","Saturday"),
            self::SUN => Yii::t("site","Sunday"),
            self::MON => Yii::t("site","Monday"),
            self::TUE => Yii::t("site","Tuesurday"),
            self::WED => Yii::t("site","Wednesday"),
            self::THU => Yii::t("site","Thursday"),
            self::FRI => Yii::t("site","Friday"),
        ];
    }


    public static function generateIBAN($accountNumber,$branch)
    {
        $IBAN = 'Account Number Must be Number';
        
        if (is_numeric($accountNumber)) 
        {
            $number_format = "18181110" . $branch . "00" . $accountNumber . "192400";
            $checkdigit = 98 - bcmod($number_format, 97);
            if ($checkdigit < 10) {
                $checkdigit = "0" . $checkdigit;
            }
            $IBAN = 'JO' . $checkdigit . 'IIBA' . $branch . '00' . $accountNumber;
        }   

        return $IBAN;

    }

    public static function sanitize(array $input, array $fields = array(), $utf8_encode = true)
    {

        if (empty($fields)) {
            $fields = array_keys($input);
        }

        $return = array();

        foreach ($fields as $field) {
            if (!isset($input[$field])) {
                continue;
            } else {
                $value = $input[$field];
                if (is_array($value)) {
                    $value = null;
                }

                $value = self::sanitizeValue($value, $utf8_encode);

                $return[$field] = $value;
            }
        }


        return $return;
    }


    public static function sanitizeValue($value, $utf8_encode = true)
    {
        $magic_quotes = false;

        if (is_string($value)) 
        {
            if ($magic_quotes === true) 
            {
                $value = stripslashes($value);
            }

            if (strpos($value, "\r") !== false) 
            {
                $value = trim($value);
            }

            if (function_exists('iconv') && function_exists('mb_detect_encoding') && $utf8_encode) 
            {
                $current_encoding = mb_detect_encoding($value);

                if ($current_encoding != 'UTF-8' && $current_encoding != 'UTF-16') 
                {
                    $value = iconv($current_encoding, 'UTF-8', $value);
                }
            }


            $value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $value = strip_tags($value);

            //$value = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); // not supported in php 8

            //TODO: in 7.2 this return null because it not exist
            $value = filter_var($value, FILTER_SANITIZE_ADD_SLASHES);
            //$value = filter_var($value, FILTER_SANITIZE_MAGIC_QUOTES);
        }

        return $value;

    }

    public static function newSearchIncludingFilters($availableAttributeNamesAtFront)
    {

        $params=null;
        $searchparams = Yii::$app->request->get('search_slugs');
        if($searchparams)
        {
            $searchparams = explode("/",$searchparams);
            $searchparams = Utility::sanitize($searchparams);
            $params = [];
            for($key=0; $key<count($searchparams); $key++)
            {
                if(in_array($searchparams[$key], array_keys($availableAttributeNamesAtFront) ) )
                {
                    $valueKey = $key+1;
                    if(isset($searchparams[$valueKey]))
                    {
                        $params[$availableAttributeNamesAtFront[$searchparams[$key]]] = $searchparams[$valueKey];
                        ++$key;
                    }
                }
                
            }
        }
        return $params;
    }


    public static function getTweetEmbedCode($tweetUrl) {
        $oembedUrl = "https://publish.twitter.com/oembed?url=" . urlencode($tweetUrl);
        $response = file_get_contents($oembedUrl);
        $tweetData = json_decode($response, true);
        if (isset($tweetData['html'])) {
            $html = $tweetData['html'];
            $htmlWithNonce = preg_replace('/<script\s+.*?src="https:\/\/platform\.twitter\.com\/widgets\.js".*?><\/script>/',
                '<script async src="https://platform.twitter.com/widgets.js" charset="utf-8" nonce="' . $GLOBALS['nonce'] . '"></script>', $html);
            return $htmlWithNonce;
        }

        return '<p>Unable to fetch tweet.</p>';
    }


    public static $levantineMonths = [
        1 => 'كانون الثاني', // January
        2 => 'شباط',       // February
        3 => 'آذار',       // March
        4 => 'نيسان',      // April
        5 => 'آيار',       // May
        6 => 'حزيران',     // June
        7 => 'تموز',       // July
        8 => 'آب',         // August
        9 => 'أيلول',      // September
        10 => 'تشرين الأول', // October
        11 => 'تشرين الثاني', // November
        12 => 'كانون الأول'  // December
    ];


    public static $objectFitArray=[
        "contain" => "contain",
        "cover" => "cover",
        "fill" => "fill",
        "scale-down" => "scale-down",
        "scale-down" => "scale-down",
    ];


    public static function selected_currency($attribute, $currency=null){
        $selected_currency = Currency::find()->active()->andWhere(['slug' => $currency ?? Yii::$app->request->cookies->getValue('currency')])->one();
        $selected_currency ??= Currency::find()->active()->andWhere(['is_default' => 1])->one();
        $selected_currency ??= Currency::find()->active()->one();
        return $selected_currency->$attribute;
    }

    public static function calculateCartTotals(&$cart, $currency = null){
        $subtotal = 0;
        $total = 0;

        foreach ($cart as $guid => $item) {
            $item = Utility::adjustItem($item);

            if (!$item) {
                unset ($cart[$guid]);
                continue;
            }

            if ($item['type'] == 1) {
                $subtotal += $item['amount_' . ($currency ?: 'jod')] * $item['quantity'];
            }else{
                $subtotal += $item['amount_' . ($currency ?: 'jod')] * $item['quantity'] * ($item['recurrence'] == "yearly" ? 12 : 1);
            }

            $total += $item['total_' . ($currency ?: 'jod')];
            $cart[$guid] = $item;
        }

        if ($currency){
            return [
                number_format($subtotal, 2) . " " . Utility::selected_currency('title', $currency),
                number_format($total, 2) . " " . Utility::selected_currency('title', $currency),
            ];
        }

        return [
            $subtotal,
            $total
        ];
    }


    public static function generateItem($item){
        $donation = DonationTypes::find()->active()->andwhere([
            'guid' => $item['donation']
        ]);

        $campaign = Campaign::find()->active()->andwhere([
            'guid' => $item['campaign']
        ]);


        $currency = Currency::find()->active()->andwhere([
            'slug' => $item['currency']
        ]);

        $db_item = DonationProgramItem::find()->andwhere([
            'id' => $item['id'] ?? null,
            'donation_program_id' => $item['program_id'] ?? null
        ]);

        if (!$donation->exists() || !$currency->exists() || (!$db_item->exists() && $item['type'] != 1) || $item['quantity'] < 1 || $item['amount'] <= 0)
            return [
                null,
                null
            ];

        $db_item = $db_item->one();
        $donation = $donation->one();
        $campaign = $campaign->one();

        $guid = $donation->guid . "-" . $campaign?->guid . "-" . $item['recurrence'];

        $currency = $currency->one();
        $amount = (float)$item['amount'];
        $item['guid'] = $guid;
        unset($item['currency'], $item['amount'], $item['guid']);

        if (in_array($item['type'], [1])){
            if ($currency->slug == "jod"){
                $item['amount_jod']= $amount;
                $item['amount_usd'] = $item['amount_jod'] * 1 / (Currency::find()->where(['slug' => 'usd'])->one()->rate);
            }elseif ($currency->slug == "usd"){
                $item['amount_jod'] = $amount * (Currency::find()->where(['slug' => 'usd'])->one()->rate);
                $item['amount_usd'] = $amount;
            }
        }else{
            $item['amount_jod'] = $db_item->amount_jod;
            $item['amount_usd'] = $db_item->amount_usd;
        }

        return [
            $guid,
            $item
        ];
    }

    public static function adjustItem($item){
        $item['title'] = "Unknown";
        $item['image'] = null;
        $item['recurrence'] ??= "once";

        $donation = DonationTypes::find()->active()->andWhere([
            'guid' => $item['donation']
        ])->one();

        $campaign = Campaign::find()->active()->andWhere([
            'guid' => $item['campaign']
        ])->one();

        if ($donation) {
            $item['title'] = $donation->cms_title ?: $donation->title;
            $item['image'] = $donation->image;
        }

        if ($campaign) {

            $item['title'] = $campaign->cms_title ?: $campaign->title;
            $item['image'] = $campaign->image;
        }

        if ($item['title'] == 'Unknown' || $item['quantity'] < 1)
            return null;

        $item['amount_jod'] = (float) $item['amount_jod'];
        $item['amount_usd'] = (float) $item['amount_usd'];

        $item['total_jod'] = (float)$item['amount_jod'] * (float)$item['quantity'] * (1 + (isset($item['add_transaction_fees']) ? 2.4 / 100 : 0));
        $item['total_usd'] = (float)$item['amount_usd'] * (float)$item['quantity'] * (1 + (isset($item['add_transaction_fees']) ? 2.4 / 100 : 0));

        $item['amount'] = number_format($item['amount_' . Utility::selected_currency('slug')], 2). " " . Utility::selected_currency('title');
        $item['total'] = number_format($item['total_' . Utility::selected_currency('slug')], 2) . " " . Utility::selected_currency('title');


        if ($item['type'] == 2) {
            $item['total_jod'] = (float)$item['amount_jod'] * (float)$item['quantity'] * (1 + (isset($item['add_transaction_fees']) ? 2.4 / 100 : 0)) * ($item['recurrence'] == "yearly" ? 12 : 1);
            $item['total_usd'] = (float)$item['amount_usd'] * (float)$item['quantity'] * (1 + (isset($item['add_transaction_fees']) ? 2.4 / 100 : 0)) * ($item['recurrence'] == "yearly" ? 12 : 1);

            $item['amount'] = number_format($item['amount_' . Utility::selected_currency('slug')] * ($item['recurrence'] == "yearly" ? 12 : 1), 2) . " " . Utility::selected_currency('title');
            $item['total'] = number_format($item['total_' . Utility::selected_currency('slug')], 2) . " " . Utility::selected_currency('title');
        }

        return $item;
    }

    public static function cartItemsCount(){
        $cart= Yii::$app->session->get('cart', []);
        return count($cart);
    }

    public static function hexToRgb($hex, $alpha = 1) {
        $hex      = str_replace('#', '', $hex);
        $length   = strlen($hex);
        $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
        $rgb['a'] = $alpha;

        return "rgba({$rgb['r']}, {$rgb['g']}, {$rgb['b']}, {$rgb['a']})";
    }
}