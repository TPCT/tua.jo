<?php

namespace backend\modules\currency\models;

use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[News]].
 *
 * @see News
 */
class CurrencyQuery extends \yii\db\ActiveQuery
{
    use RevisionTrait;
    use MultilingualTrait;

    public function active()
    {
        return $this->andWhere(['status' => Currency::STATUS_PUBLISHED]);
    }
    

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
