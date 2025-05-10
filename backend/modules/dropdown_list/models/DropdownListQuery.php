<?php

namespace backend\modules\dropdown_list\models;

use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[DropdownList]].
 *
 * @see DropdownList
 */
class DropdownListQuery extends \yii\db\ActiveQuery
{
    use RevisionTrait;
    use MultilingualTrait;

    
    public function active()
    {
        return $this->andWhere([DropdownList::tableName().'.status' => DropdownList::STATUS_PUBLISHED])
            ->joinWith("translations")
            ->groupBy(DropdownList::tableName().".id")
            ->orderBy([
                'weight' => SORT_ASC,
                "published_at" => SORT_DESC,
            ]);
    }


    public function activeWithCategory($category)
    {
        return $this->andWhere([DropdownList::tableName().'.status' => DropdownList::STATUS_PUBLISHED])
                    ->andWhere(["category"=>$category])
                    ->joinWith("translations")
                    ->orderBy([ 
                        'weight' => SORT_ASC,
                        "published_at" => SORT_DESC,
                    ]);
    }

    
    /**
     * @inheritdoc
     * @return DropdownList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    
    /**
     * @inheritdoc
     * @return DropdownList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
