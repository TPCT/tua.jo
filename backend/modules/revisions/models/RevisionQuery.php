<?php

namespace backend\modules\revisions\models;

use omgdef\multilingual\MultilingualTrait;

/**
 * This is the ActiveQuery class for [[Revision]].
 *
 * @see Revision
 */
class RevisionQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;

    /**
     * @inheritdoc
     * @return Revision[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Revision|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
