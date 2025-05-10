<?php

namespace yeesoft\seo\models;

use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[News]].
 *
 * @see News
 */
class SeoQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;
    use RevisionTrait;

    /**
     * @inheritdoc
     * @return News[]|array
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
