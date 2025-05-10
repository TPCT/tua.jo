<?php

namespace backend\modules\subdistrict\models;
use omgdef\multilingual\MultilingualTrait;

/**
 * This is the ActiveQuery class for [[Subdistrict]].
 *
 * @see Subdistrict
 */
class SubdistrictQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;

    public function active()
    {
        $this->andWhere(['status' => Subdistrict::STATUS_PUBLISHED]);
        return $this;
    }

    /**
     * {@inheritdoc}
     * @return Subdistrict[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Subdistrict|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
