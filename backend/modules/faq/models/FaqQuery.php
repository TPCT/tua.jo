<?php

namespace backend\modules\faq\models;

use backend\modules\dropdown_list\models\DropdownList;
use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[faq]].
 *
 * @see faq
 */
class FaqQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;
    use RevisionTrait;

    public function active()
    {
        return $this->andWhere([Faq::tableName().'.status' => Faq::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy([
                        'weight_order' => SORT_ASC,
                        "published_at" => SORT_DESC
                    ])
                    ->groupBy(Faq::tableName().".id");
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
