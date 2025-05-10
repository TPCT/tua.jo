<?php

namespace backend\modules\donation_programs\models;

use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[Donation]].
 *
 * @see Donation
 */
class DonationProgramQuery extends \yii\db\ActiveQuery
{
    use RevisionTrait;
    use MultilingualTrait;

    public function active()
    {
        return $this->andWhere([DonationProgram::tableName().'.status' => DonationProgram::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy([
                        'weight' => SORT_ASC,
                        "published_at" => SORT_DESC
                    ])
                    ->groupBy(DonationProgram::tableName().".id");
    }

    /**
     * @inheritdoc
     * @return Donation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Donation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
