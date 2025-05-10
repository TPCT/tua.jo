<?php

namespace backend\modules\newsletter\models;

/**
 * This is the ActiveQuery class for [[NewsletterCampaign]].
 *
 * @see NewsletterCampaign
 */
class NewsletterCampaignQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return NewsletterCampaign[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return NewsletterCampaign|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
