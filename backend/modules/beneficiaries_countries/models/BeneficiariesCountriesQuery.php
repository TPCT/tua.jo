<?php

namespace backend\modules\beneficiaries_countries\models;

use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[BeneficiariesCountries]].
 *
 * @see BeneficiariesCountries
 */
class BeneficiariesCountriesQuery extends \yii\db\ActiveQuery
{
    use RevisionTrait;
    use MultilingualTrait;

    public function active()
    {
        return $this->andWhere([BeneficiariesCountries::tableName().'.status' => BeneficiariesCountries::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy([
                    //    'weight' => SORT_ASC,
                        "published_at" => SORT_DESC,
                    ])
                    ->groupBy(BeneficiariesCountries::tableName().".id");
    }

    /**
     * @inheritdoc
     * @return BeneficiariesCountries[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AnnualReport|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
