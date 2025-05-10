<?php

namespace console\models;

use Yii;

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
class NewsMigration extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_migration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_image', 'field_image_path', 'field_summary', 'field_source', 'field_header_line', 'field_footer', 'field_weight', 'city_name', 'country_name', 'url_alias'], 'default', 'value' => null],
//            [['nid', 'tnid', 'title', 'language', 'body', 'field_date', 'published_status'], 'required'],
            [['nid', 'tnid', 'field_image', 'field_weight', 'published_status'], 'integer'],
            [['body', 'field_summary'], 'string'],
            [['field_date'], 'safe'],
            [['title', 'field_image_path', 'field_source', 'field_header_line', 'url_alias'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 10],
            [['field_footer'], 'string', 'max' => 50],
            [['city_name', 'country_name'], 'string', 'max' => 100],
//            [['nid'], 'unique'],
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
