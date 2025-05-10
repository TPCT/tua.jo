<?php

namespace backend\modules\media_gallery\models\search;

use backend\modules\media_gallery\models\MediaGallery;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MediaGallerySearch represents the model behind the search form about `common\models\MediaGallery`.
 */
class MediaGallerySearch extends MediaGallery
{
    public $published_at_operand;
    public $year;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status', 'year', 'category_id'], 'integer'],
            [['slug', 'title', 'published_at', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MediaGallery::find()->joinWith('translations')->groupBy(['media_gallery.id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => [
                    'published_at' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
//            var_dump($this->getErrors());
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
            'category_id' => $this->category_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ]);

        $query->andFilterWhere([($this->published_at_operand) ? $this->published_at_operand : '=', 'published_at', ($this->published_at) ? strtotime($this->published_at) : null]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title]);
            
        if ($this->year){
            $start = strtotime("{$this->year}-01-01");
            $end = strtotime("{$this->year}-12-31");
            $query->andFilterWhere(['between', 'published_at', $start, $end]);

        }

//        var_dump($query->createCommand()->rawSql);
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function basicSearch($params)
    {
        $query = MediaGallery::find()->joinWith('translations')->groupBy(['id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);


        $this->load($params);


        $query->andFilterWhere([
            'status' => 1
        ]);


        $query->andWhere(['or', ['like', 'title', $this->title], ['like', 'brief', $this->content]]);

        return $dataProvider;
    }

}
