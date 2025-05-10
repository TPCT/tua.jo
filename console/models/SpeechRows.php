<?php

namespace console\models;

/**
 * This is the model class for table "news_rows".
 *
 * @property int $nid
 * @property int $tnid
 * @property string $title_ar
 * @property string title_en
 * @property string $json_ar
 * @property string $json_en
 */
class SpeechRows extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'speech_rows';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['nid', 'tnid', 'json_ar', 'json_en'], 'required'],
            [['nid', 'tnid'], 'integer'],
            [['json_ar', 'json_en'], 'string'],
            [['nid'], 'unique'],
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
            'json_ar' => 'Json Ar',
            'json_en' => 'Json En',
        ];
    }

}
