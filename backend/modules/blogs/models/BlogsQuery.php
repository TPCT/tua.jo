<?php

namespace backend\modules\blogs\models;

use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[blogs]].
 *
 * @see blogs
 */
class BlogsQuery extends \yii\db\ActiveQuery
{
    use RevisionTrait;
    use MultilingualTrait;

    public function active()
    {
        return $this->andWhere([Blogs::tableName().'.status' => Blogs::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy([
                        'weight' => SORT_ASC,
                        "published_at" => SORT_DESC
                    ])
                    ->groupBy(Blogs::tableName().".id");
    }

    /**
     * @inheritdoc
     * @return Blogs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Blogs|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
