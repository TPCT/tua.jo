<?php

namespace yeesoft\models;

use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[Menu]].
 *
 * @see Menu
 */
class MenuQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;
    use RevisionTrait;

    public function active()
    {
        return $this->andWhere([Menu::tableName().'.status' => Menu::STATUS_PUBLISHED]);
        
    }


    public function activeWithCategory($categorySlug)
    {

        $this->andWhere([Menu::tableName().'.status' => Menu::STATUS_PUBLISHED])
                ->andWhere(["category_slug"=>$categorySlug]);
                
        return $this;
    }

    /**
     * @inheritdoc
     * @return Menu[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    

    /**
     * @inheritdoc
     * @return Menu|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
