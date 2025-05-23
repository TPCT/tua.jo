<?php

namespace yeesoft\page\models;

use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;

/**
 * This is the ActiveQuery class for [[Page]].
 *
 * @see Page
 */
class PageQuery extends \yii\db\ActiveQuery
{

    use MultilingualTrait;
    use RevisionTrait;

    public function active()
    {
        return $this->andWhere(['status' => Page::STATUS_PUBLISHED])
                    ->orderBy(['published_at' => SORT_ASC]);
    }


    /**
     * @inheritdoc
     * @return Page[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Page|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
