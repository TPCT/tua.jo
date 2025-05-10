<?php

namespace backend\modules\header_image\models;

use omgdef\multilingual\MultilingualTrait;

/**
 * This is the ActiveQuery class for [[News]].
 *
 * @see News
 */
class HeaderImageQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;

    /**
     * @inheritdoc
     * @return News[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return News|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
