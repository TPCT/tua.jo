<?php

namespace backend\modules\media_gallery\models;

use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[MediaGallery]].
 *
 * @see MediaGallery
 */
class MediaGalleryQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;
    use RevisionTrait;

    public function active()
    {
        return $this->andWhere([MediaGallery::tableName().'.status' => MediaGallery::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy(["published_at" => SORT_DESC])
                    ->groupBy(MediaGallery::tableName().".id");
    }

    /**
     * @inheritdoc
     * @return MediaGallery[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MediaGallery|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
