<?php

namespace backend\modules\newsletter\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "newsletter_campaign".
 *
 * @property int $id
 * @property string $subject
 * @property string $body
 * @property string $status
 * @property string $start_date
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class NewsletterCampaign extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'newsletter_campaign';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'body'], 'required'],
            [['body'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['start_date'], 'safe'],
            [['subject', 'status'], 'string', 'max' => 255],

            [
                [
                'subject','start_date'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],

            [[
                'subject','start_date'], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],

        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('site', 'ID'),
            'subject' => Yii::t('site', 'Subject'),
            'body' => Yii::t('site', 'Body'),
            'status' => Yii::t('site', 'Status'),
            'start_date' => Yii::t('site', 'Start Date'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
        ];
    }


    /**
     * {@inheritdoc}
     * @return NewsletterCampaignQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsletterCampaignQuery(get_called_class());
    }
    public function getCreatedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->created_at);
    }
    public function getCreatedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->created_at);
    }

    public function getCreatedDatetime()
    {
        return "{$this->createdDate} {$this->createdTime}";
    }


}
