<?php
/**
 * Created by PhpStorm.
 * User: ajoudeh
 * Date: 7/5/18
 * Time: 10:03 PM
 */

namespace backend\models;

use yeesoft\behaviors\MultilingualSettingsBehavior;
use Yii;


class SiteSettings extends \yeesoft\settings\models\BaseSettingsModel
{
    const GROUP = 'site';

    public $logo;
    public $top_logo;
    public $footer_logo;
    public $footer_url;
    public $strategy_forum_url;
    public $footer_brief;
    
    public $app_store_logo;
    public $app_store_url;

    public $google_store_logo;
    public $google_store_url;

    public $phone;
    public $email;
    public $complaint_page_email;
    public $address;
    public $address_url;
    public $google_map_url;

    public $street_address;
    public $address_region;
    public $postal_code;

    public $p_o_box;
    public $alternative_phone;
    public $fax;

    public $flicker_link;
    
    public $facebook_link;
    public $twitter_link;
    public $linked_in;
    public $youtube_link;
    public $instagram_link;

    public $career_email;
    public $main_branch;
    public $map_location_lat;
    public $map_location_lng;
    public $homepage_image;
    public $homepage_text;
    public $homepage_title;
    public $contact_us_text;
    public $cities_title;
    public $cities_text;
    public $working_day_from;
    public $working_day_to;
    public $working_hour_from;
    public $working_hour_to;
    public $for_doctor_text;
    public $for_patient_text;
    public $ask_doctor_text;

    public $homepage_instagram_title;
    public $homepage_instagram_brief;

    public $homepage_offer_title;
    public $homepage_offer_brief;


    public $homepage_video;
    public $our_story_background_image;
    public $video_homepage;
    public $booking_details;

    public $map_iframe_src;
    public $contact_us_map_iframe_src;

    public $google_analytics_code;
    public $google_tag_code;
    public $meta_pixel_code;



    public $default_page_size;
    public $empowerment_page_size;

    public $zakat_page_size;
    public $media_center_page_size;
    public $media_post_page_size;

    public $statistic_page_size;
    public $testimonisl_page_size;
    public $news_page_size;
    public $volunteer_page_size;
    public $our_partner_page_size;
    public $blogs_page_size;
    public $photo_gellary_page_size;


    public $search_page_size;


    public $contact_us_email;
    public $volunteer_email;
    public $complaint_email;
    public $initimation_email;
    public $join_us_email;
    public $protection_email;
    public $sea_allegation_email;
    public $donation_campaing_email;
    public $gift_card_email;
    public $donation_gift_card_email;


    public $enable_filteration_at_all_page;
    public $enable_one_podcast_at_homepage;
    public $home_page_dar_abu_abdallah_hidden;
    public $home_page_our_impact_hidden;


    public $gold_24_price;
    public $gold_22_price;
    public $gold_21_price;
    public $gold_18_price;



    public function rules()
    {
        return [
//            [['phone', 'fax', 'email'], 'required'],
            [
                [
                    'logo', 'top_logo', 'google_store_logo'  ,'app_store_logo', 'strategy_forum_url', 'footer_url','footer_logo', 'footer_brief',
                    'p_o_box', 'map_iframe_src','contact_us_map_iframe_src', 'our_story_background_image',
                    'video_homepage',
                    'booking_details', 'homepage_video', 'homepage_instagram_title', 'google_store_url','app_store_url',
                    'homepage_instagram_brief', 'homepage_offer_title', 'homepage_offer_brief', 
                    'address','address_url','google_map_url', 'phone', 'alternative_phone', 'fax', 'email', 'contact_us_email', 
                    'main_branch', 'facebook_link', 'flicker_link', 'twitter_link','linked_in', 'youtube_link', 'instagram_link',
                    'homepage_title','career_email','join_us_email','volunteer_email','donation_campaing_email','gift_card_email','donation_gift_card_email',
                    'google_analytics_code', 'google_tag_code', 'meta_pixel_code','postal_code','address_region','street_address'
                ], 'string'
            ],
//            [['map_location_lat', 'map_location_lng'], 'number'],
            [['contact_us_email','join_us_email','donation_campaing_email','donation_gift_card_email','gift_card_email', 'sea_allegation_email','volunteer_email','protection_email','initimation_email','complaint_email','complaint_page_email'], 'email'],
    
            ['photo_gellary_page_size', 'default', 'value' => 9],
            ['testimonisl_page_size', 'default', 'value' => 9],
            ['zakat_page_size', 'default', 'value' => 9],
            ['empowerment_page_size', 'default', 'value' => 9],
            ['news_page_size', 'default', 'value' => 9],
            ['our_partner_page_size', 'default', 'value' => 9],
            ['volunteer_page_size', 'default', 'value' => 9],
            ['blogs_page_size', 'default', 'value' => 9],
            ['media_post_page_size', 'default', 'value' => 9],
            ['default_page_size', 'default', 'value' => 9],

            ['media_center_page_size', 'default', 'value' => 9],

            [['gold_24_price','gold_22_price','gold_21_price','gold_18_price'],'number'],

     

            ['search_page_size', 'default', 'value' => 9],

            [ ['enable_filteration_at_all_page', 'enable_one_podcast_at_homepage'],'boolean'],

            
            ['home_page_dar_abu_abdallah_hidden', 'default', 'value' => 0],
            ['home_page_our_impact_hidden', 'default', 'value' => 0],


            [
                ['logo', 'top_logo','app_store_logo' , 'google_store_logo' , 'email', 'facebook_link', 'flicker_link', 'twitter_link','linked_in', 'youtube_link', 'instagram_link', 'map_iframe_src','contact_us_map_iframe_src'
                , 'home_page_dar_abu_abdallah_hidden','home_page_our_impact_hidden' ,'google_analytics_code','google_tag_code','meta_pixel_code'],
                function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],

            [
                [ 'logo', 'top_logo' , 'app_store_logo' , 'google_store_logo' , 'email', 'facebook_link', 'flicker_link', 'twitter_link','linked_in', 'youtube_link', 'instagram_link','map_iframe_src','contact_us_map_iframe_src'
                ,'google_analytics_code','google_tag_code','meta_pixel_code'
                ], 
                function ($attribute) 
                {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],


        ];





    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'multilingualSettings' => [
                'class' => MultilingualSettingsBehavior::className(),
                'attributes' => [
                    'logo', 'top_logo', 'strategy_forum_url', 'footer_logo', 'footer_brief', 'app_store_logo' , 'google_store_logo',
                    'our_story_background_image', 
                    'p_o_box', 'video_homepage','address','contact_us_text','homepage_instagram_title', 'homepage_instagram_brief', 'homepage_offer_title', 'homepage_offer_brief',
                    'postal_code','address_region','street_address'
                  
                ]
            ],
        ];
    }


    public function attributeLabels()
    {
        return [
            'homepage_text' => Yii::t('site', 'Homepage Breif'),
            'homepage_title' => Yii::t('site', 'Homepage Title'),
            'phone' => Yii::t('yee/settings', 'Site Phone'),
            'fax' => Yii::t('yee/settings', 'Site Fax'),
            'contact_us_email' => Yii::t('yee/settings', 'Contact us Email'),
            'email' => Yii::t('yee/settings', 'Info Email'),
            'address' => Yii::t('yee/settings', 'Address'),
            'main_branch' => Yii::t('yee/settings', 'Site Main Branch'),
            'verified_filter_txt' => Yii::t('yee/settings', 'Verified Filter Msg'),


        ];
    }


}