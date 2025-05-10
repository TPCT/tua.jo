<?php

namespace backend\modules\e_card\models;

use backend\modules\dropdown_list\models\DropdownList;
use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[e_card]].
 *
 * @see e_card
 */
class ECardQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;
    use RevisionTrait;

    public function active()
    {
        return $this->andWhere([ECard::tableName().'.status' => ECard::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy([
                        'weight_order' => SORT_ASC,
                        "published_at" => SORT_DESC
                    ])
                    ->groupBy(ECard::tableName().".id");
    }



    /**
     * @inheritdoc
     * @return FAQ[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FAQ|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
