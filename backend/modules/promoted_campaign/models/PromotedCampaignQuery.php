<?php

namespace backend\modules\promoted_campaign\models;

use backend\modules\dropdown_list\models\DropdownList;
use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[PromotedCampaign]].
 *
 * @see PromotedCampaign
 */
class PromotedCampaignQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;
    use RevisionTrait;

    public function active()
    {
        return $this->andWhere([PromotedCampaign::tableName().'.status' => PromotedCampaign::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy([
                        'weight_order' => SORT_ASC,
                        "published_at" => SORT_DESC
                    ])
                    ->groupBy(PromotedCampaign::tableName().".id");
    }



    /**
     * @inheritdoc
     * @return PromotedCampaign[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PromotedCampaign|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
