<?php

namespace backend\modules\newsletter\models;

/**
 * This is the ActiveQuery class for [[NewsletterClientList]].
 *
 * @see NewsletterClientList
 */
class NewsletterClientListQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return NewsletterClientList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return NewsletterClientList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
