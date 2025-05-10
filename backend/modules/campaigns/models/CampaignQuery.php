<?php

namespace backend\modules\campaigns\models;

use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[Donation]].
 *
 * @see Donation
 */
class CampaignQuery extends \yii\db\ActiveQuery
{
    use RevisionTrait;
    use MultilingualTrait;

    public function active()
    {
        return $this->andWhere([Campaign::tableName().'.status' => Campaign::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy([
                        'weight' => SORT_ASC,
                        "published_at" => SORT_DESC
                    ])
                    ->groupBy(Campaign::tableName().".id");
    }

    /**
     * @inheritdoc
     * @return Campaign[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Campaign|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
