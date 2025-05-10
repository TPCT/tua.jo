<?php

namespace backend\modules\bms\models;

use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[News]].
 *
 * @see News
 */
class BmsQuery extends \yii\db\ActiveQuery
{
    use RevisionTrait;
    use MultilingualTrait;

    public function active()
    {
        return $this->andWhere([Bms::tableName().'.status' => Bms::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy(["published_at" => SORT_DESC])
                    ->groupBy(Bms::tableName().".id");
    }

    public function activeWithCategory($category_slug)
    {
        return $this->andWhere([Bms::tableName().'.status' => Bms::STATUS_PUBLISHED])
                    ->andWhere(["category_slug"=>$category_slug])
                    ->joinWith("translations")
                    ->orderBy(["published_at" => SORT_DESC]);

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
