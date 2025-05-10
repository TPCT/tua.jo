<?php

namespace backend\modules\empowerment_products\models;

use backend\modules\dropdown_list\models\DropdownList;
use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[EmpowermentProducts]].
 *
 * @see EmpowermentProductsQuery
 */
class EmpowermentProductsQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;
    use RevisionTrait;


    public function active()
    {
        return $this->andWhere([EmpowermentProducts::tableName().'.status' => EmpowermentProducts::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy(["published_at" => SORT_DESC])
                    ->groupBy(EmpowermentProducts::tableName().".id");
    }


    /**
     * @inheritdoc
     * @return EmpowermentProducts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return EmpowermentProducts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
