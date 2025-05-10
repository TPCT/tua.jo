<?php

namespace backend\modules\recurring_items\models;

use backend\modules\dropdown_list\models\DropdownList;
use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[News]].
 *
 * @see News
 */
class RecurringItemsQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;
    use RevisionTrait;


    public function active()
    {
        return $this->andWhere([RecurringItems::tableName().'.status' => RecurringItems::STATUS_PUBLISHED]);
    }


    /**
     * @inheritdoc
     * @return RecurringItems[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RecurringItems|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
