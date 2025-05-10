<?php

namespace backend\modules\testimonials\models;

use common\components\RevisionTrait;
use omgdef\multilingual\MultilingualTrait;
use Yii;

/**
 * This is the ActiveQuery class for [[testimonials]].
 *
 * @see testimonials
 */
class TestimonialsQuery extends \yii\db\ActiveQuery
{
    use RevisionTrait;
    use MultilingualTrait;

    public function active()
    {
        return $this->andWhere([Testimonials::tableName().'.status' => Testimonials::STATUS_PUBLISHED])
                    ->joinWith("translations")
                    ->orderBy([
                        'weight' => SORT_ASC,
                        "published_at" => SORT_DESC
                    ])
                    ->groupBy(Testimonials::tableName().".id");
    }

    /**
     * @inheritdoc
     * @return Testimonials[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Testimonials|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
