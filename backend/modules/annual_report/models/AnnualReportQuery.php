<?php

namespace backend\modules\annual_report\models;

use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[AnnualReport]].
 *
 * @see AnnualReport
 */
class AnnualReportQuery extends \yii\db\ActiveQuery
{
    use RevisionTrait;
    use MultilingualTrait;

    public function active()
    {
        return $this->andWhere([AnnualReport::tableName().'.status' => AnnualReport::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy([
                        'weight' => SORT_ASC,
                        "published_at" => SORT_DESC,
                    ])
                    ->groupBy(AnnualReport::tableName().".id");
    }

    /**
     * @inheritdoc
     * @return AnnualReport[]|array
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
