<?php

namespace backend\modules\city\models;
use omgdef\multilingual\MultilingualTrait;

/**
 * This is the ActiveQuery class for [[City]].
 *
 * @see City
 */
class CityQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;

    public function active()
    {
        $this->andWhere(['status' => City::STATUS_PUBLISHED]);
        return $this;
    }

    /**
     * {@inheritdoc}
     * @return City[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return City|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
