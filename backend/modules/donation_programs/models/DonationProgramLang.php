<?php

namespace backend\modules\donation_programs\models;

use Yii;

/**
 * This is the model class for table "news_lang".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 * @property string $content
 * @property string $brief
 *
 * @property donation $parent
 */
class DonationProgramLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'donation_programs_lang';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \bedezign\yii2\audit\AuditTrailBehavior::className(),

        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'language'], 'required'],
            [['parent_id'], 'integer'],
            [['title', 'brief', 'tag'], 'string'],
            [['language'], 'string', 'max' => 6],
            [
                [
                    'title','brief','tag'
                ], 'string', 'max' => 255
            ],
            [['campaign_report', 'goal_achieved'], 'string'],
            [['parent_id'], 'exist', 'skipOnError' => false, 'targetClass' => DonationProgram::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'language' => 'Language',
            'title' => 'Title',
            'tag' => 'Tag',
            'brief' => 'Brief',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(DonationProgram::className(), ['id' => 'parent_id']);
    }
}
