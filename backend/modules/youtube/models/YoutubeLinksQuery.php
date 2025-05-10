<?php

namespace backend\modules\youtube\models;

use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[YoutubeLinks]].
 *
 * @see YoutubeLinks
 */
class YoutubeLinksQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;
    use RevisionTrait;

    public function active()
    {
        return $this->andWhere([YoutubeLinks::tableName().'.status' => YoutubeLinks::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy([ 
                        "published_at" => SORT_DESC,
                    ])
                    ->groupBy(YoutubeLinks::tableName().".id");

    }

    /**
     * @inheritdoc
     * @return YoutubeLinks[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    
    /**
     * @inheritdoc
     * @return News|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
