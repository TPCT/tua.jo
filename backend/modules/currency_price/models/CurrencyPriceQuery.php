<?php

namespace backend\modules\currency_price\models;

use common\components\RevisionTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[News]].
 *
 * @see News
 */
class CurrencyPriceQuery extends \yii\db\ActiveQuery
{
    use RevisionTrait;

    public function active()
    {
        return $this->andWhere(['status' => CurrencyPrice::STATUS_PUBLISHED])
                    ->orderBy(['published_at' => SORT_DESC]);
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
