<?php

namespace backend\modules\zakat_stories\models;

use backend\modules\dropdown_list\models\DropdownList;
use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[ZakatStories]].
 *
 * @see ZakatStories
 */
class ZakatStoriesQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;
    use RevisionTrait;


    public function active()
    {
        return $this->andWhere([ZakatStories::tableName().'.status' => ZakatStories::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy(["published_at" => SORT_DESC])
                    ->groupBy(ZakatStories::tableName().".id");
    }


    /**
     * @inheritdoc
     * @return ZakatStories[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ZakatStories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
