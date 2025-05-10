<?php

namespace backend\modules\volunteers\models;

use backend\modules\dropdown_list\models\DropdownList;
use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[Volunteers]].
 *
 * @see Volunteers
 */
class VolunteersQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;
    use RevisionTrait;


    public function active()
    {
        return $this->andWhere([Volunteers::tableName().'.status' => Volunteers::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy([
                        'weight' => SORT_ASC,
                        "published_at" => SORT_DESC
                    ])
                    ->groupBy(Volunteers::tableName().".id");
    }


    /**
     * @inheritdoc
     * @return Volunteers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Volunteers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
