<?php

namespace console\models;

/**
 * This is the model class for table "news_migration".
 *
 * @property int $nid
 * @property int $tnid
 * @property string $title
 * @property string $language
 * @property string $body
 * @property string $field_date
 * @property int|null $field_image
 * @property string|null $field_image_path
 * @property string|null $field_summary
 * @property string|null $field_source
 * @property string|null $field_header_line
 * @property string|null $field_footer
 * @property int|null $field_weight
 * @property string|null $city_name
 * @property string|null $country_name
 * @property string|null $url_alias
 * @property int $published_status
 */
class InterviewsMigration extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'interviews_migration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nid', 'tnid', 'title', 'language', 'body', 'body_summary', 'field_date', 'field_appended_to_outlet',
                'field_weight', 'field_videos', 'field_videos_path', 'field_interviewer_name', 'field_appended_to_interviewer',
                'field_media_outlet_name', 'field_media_outlet_id', 'field_trailer_1', 'url_alias', 'published_status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nid' => 'Nid',
            'tnid' => 'Tnid',
            'title' => 'Title',
            'language' => 'Language',
            'body' => 'Body',
            'field_date' => 'Field Date',
            'field_image' => 'Field Image',
            'field_image_path' => 'Field Image Path',
            'field_summary' => 'Field Summary',
            'field_source' => 'Field Source',
            'field_header_line' => 'Field Header Line',
            'field_footer' => 'Field Footer',
            'field_weight' => 'Field Weight',
            'city_name' => 'City Name',
            'country_name' => 'Country Name',
            'url_alias' => 'Url Alias',
            'published_status' => 'Published Status',
        ];
    }

}
