<?php

namespace yeesoft\models;

use common\components\RevisionTrait;
use common\helpers\Utility;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[MenuLink]].
 *
 * @see MenuLink
 */
class MenuLinkQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;
    use RevisionTrait;

    public function active()
    {
        return $this->andWhere([MenuLink::tableName().'.alwaysVisible' => 0]);
    }


    /**
     * @inheritdoc
     * @return MenuLink[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    

    /**
     * @inheritdoc
     * @return MenuLink|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
