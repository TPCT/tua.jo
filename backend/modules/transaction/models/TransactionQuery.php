<?php

namespace backend\modules\transaction\models;

use backend\modules\dropdown_list\models\DropdownList;
use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[News]].
 *
 * @see News
 */
class TransactionQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;
    use RevisionTrait;


    public function active()
    {
        return $this->andWhere([Transaction::tableName().'.status' => Transaction::STATUS_PUBLISHED]);
    }


    /**
     * @inheritdoc
     * @return Transaction[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Transaction|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
