<?php

namespace backend\modules\district\models;
use omgdef\multilingual\MultilingualTrait;

/**
 * This is the ActiveQuery class for [[District]].
 *
 * @see District
 */
class DistrictQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;

    public function active()
    {
        $this->andWhere(['status' => District::STATUS_PUBLISHED]);
        return $this;
    }

    /**
     * {@inheritdoc}
     * @return District[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return District|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
