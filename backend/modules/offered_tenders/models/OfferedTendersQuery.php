<?php

namespace backend\modules\offered_tenders\models;

use backend\modules\dropdown_list\models\DropdownList;
use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[OfferedTenders]].
 *
 * @see OfferedTenders
 */
class OfferedTendersQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;
    use RevisionTrait;


    public function active()
    {
        return $this->andWhere([OfferedTenders::tableName().'.status' => OfferedTenders::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy(["published_at" => SORT_DESC])
                    ->groupBy(OfferedTenders::tableName().".id");
    }


    /**
     * @inheritdoc
     * @return OfferedTenders[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OfferedTenders|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
