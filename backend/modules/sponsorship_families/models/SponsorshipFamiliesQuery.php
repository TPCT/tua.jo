<?php

namespace backend\modules\sponsorship_families\models;

use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[Donation]].
 *
 * @see Donation
 */
class SponsorshipFamiliesQuery extends \yii\db\ActiveQuery
{
    use RevisionTrait;
    use MultilingualTrait;

    public function active()
    {
        return $this->andWhere([SponsorshipFamilies::tableName().'.status' => SponsorshipFamilies::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy([
                        'weight' => SORT_ASC,
                        "published_at" => SORT_DESC
                    ])
                    ->groupBy(SponsorshipFamilies::tableName().".id");
    }

    /**
     * @inheritdoc
     * @return SponsorshipFamilies[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SponsorshipFamilies|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
