<?php

namespace yeesoft\post\models;

use yeesoft\behaviors\MultilingualBehavior;
use yeesoft\media\models\Media;
use yeesoft\models\OwnerAccess;
use yeesoft\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yeesoft\db\ActiveRecord;

/**
 * This is the model class for table "post_images".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $path
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property User $updatedBy
 * @property User $createdBy
 * @property Post[] $posts
 */
class PostImages extends ActiveRecord
{

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_images}}';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'post_id'], 'integer'],
            [['path'], 'string', 'max' => 255],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yee', 'ID'),
            'path' => Yii::t('yee', 'Path'),
            'created_by' => Yii::t('yee', 'Created By'),
            'updated_by' => Yii::t('yee', 'Updated By'),
            'created_at' => Yii::t('yee', 'Created'),
            'updated_at' => Yii::t('yee', 'Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageRef()
    {
        return $this->hasOne(Media::className(), ['url' => 'path']);
    }

}