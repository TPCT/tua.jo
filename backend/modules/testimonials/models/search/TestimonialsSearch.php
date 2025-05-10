<?php

namespace backend\modules\testimonials\models\search;

use backend\modules\testimonials\models\Testimonials;
use backend\modules\testimonials\models\TestimonialsLang;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TestimonialsSearch represents the model behind the search form about `common\models\Testimonials`.
 */
class TestimonialsSearch extends Testimonials
{

    public $published_at_operand;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['title', 'brief'], 'string'],
            [['published_at_operand', 'published_at'], 'safe'],
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
        $query = Testimonials::find()->joinWith('translations');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

       if (!$this->validate()) {
           //var_dump($this->getErrors());die();
           // uncomment the following line if you do not want to return any records when validation fails
           // $query->where('0=1');
           return $dataProvider;
       }

        $query->andFilterWhere( 
            ['not',
                ['and',  
                    [
                        'and',
                        [Testimonials::tableName().'.changed'=> 1],
                        ['!=', Testimonials::tableName().'.revision', -1],
                    ], 
                    [
                        'and',
                        [Testimonials::tableName().'.changed'=> 1],
                        ['!=', Testimonials::tableName().'.revision', 0],
                    ]
                ]
            ]
        );

        $query->andFilterWhere([
            Testimonials::tableName().'.id' => $this->id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            Testimonials::tableName().'.status' => $this->status,
        ]);
        


        if($this->published_at)
        {
            $startOfDay = strtotime($this->published_at . ' 00:00:00');
            $endOfDay = strtotime($this->published_at . ' 23:59:59');
            $query->andFilterWhere(['>=', 'published_at', $startOfDay])
                  ->andFilterWhere(['<=', 'published_at', $endOfDay]);
        }

        $query->andFilterWhere(['like', 'title', $this->title]);

        $query->distinct(true);
        $query->groupBy(Testimonials::tableName().'.id');

        //var_dump($query->createCommand()->rawSql); exit;

        return $dataProvider;
    }


    public function basicSearch($params)
    {
        $query = self::find()->joinWith('translations');

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
            Testimonials::tableName().'.status' => 1
        ]);


        $query->andWhere(['or', ['like', 'title', $this->title], ['like', 'second_title', $this->brief], ['like', 'brief', $this->brief]]);

        return $dataProvider;
    }
}
