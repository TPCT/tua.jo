<?php

namespace backend\modules\newsletter\models;

use common\components\ModulesModelComponent;
use common\components\RevisionTrait;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "newsletter_client_list".
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property int $city_id
 * @property int $phone
 * @property int $created_at
 * @property int $updated_at
 * @property int $confirmed
 */
class NewsletterClientList extends \yii\db\ActiveRecord
{
    use ModulesModelComponent;
    use RevisionTrait;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'newsletter_client_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                'email','confirmed','created_at', 'updated_at'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            [
                [ 'email','confirmed','created_at', 'updated_at'], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],

            [['email'], 'required'],
            [['created_at', 'updated_at', 'confirmed'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['email'], 'unique', 'message' => Yii::t('site', 'You are already Registered')],
            [['email'], 'email', 'message' => Yii::t('site', 'Invalid Email')],
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
            'email' => Yii::t('site', 'FOOTER_EMAIL'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose(
            ['html' => 'newsletter-confirmation'], ['email' => $email]
        )
            ->setTo($email)
            ->setFrom([Yii::$app->params['adminEmail']])
            ->setSubject('Newsletter Subscribe')
            ->send();
    }
}
