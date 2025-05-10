<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace yeesoft\media\models;

use Yii;

/**
 * This is the model class for table "{{%media_upload}}".
 *
 * @property integer $id
 * @property integer $media_id
 * @property string $owner_class
 * @property string $language
 * @property integer $owner_id
 * @property integer $weight
 *
 * @property Media $media
 */
class MediaUpload extends \yeesoft\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%media_upload}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['media_id', 'owner_class', 'owner_id'], 'required'],
            [['media_id', 'owner_id'], 'integer'],
            [['owner_class', 'caption_en', 'caption_ar'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 5],
//            [['published_at'], 'date', 'format' => 'php:Y-m-d'],
            [['object_fit', 'object_position',],'string','max'=>50],
            [['media_id'], 'exist', 'skipOnError' => true, 'targetClass' => Media::className(), 'targetAttribute' => ['media_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'media_id' => Yii::t('app', 'Media ID'),
            'owner_class' => Yii::t('app', 'Owner Class'),
            'owner_id' => Yii::t('app', 'Owner ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id'])->with('translations');
    }

    public static function getAll($ownerClass, $ownerId)
    {
        
        return self::find()
            ->where(['owner_class' => $ownerClass, 'owner_id' => $ownerId])
            //->joinWith('media')
            ->all();

    }
}