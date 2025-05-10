<?php

namespace backend\modules\empowerment_products\models\search;

use backend\modules\empowerment_products\models\EmpowermentProducts;
use backend\modules\empowerment_products\models\EmpowermentProductsLang;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * EmpowermentProductsSearch represents the model behind the search form about `common\models\Blogs`.
 */
class EmpowermentProductsSearch extends EmpowermentProducts
{
    public $year=null;
    public $published_at_operand;
    public $sort;

    public $category_slug;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status','year'], 'integer'],
            [['title', 'brief'], 'string'],
            [['published_at_operand', 'published_at','category_slug','sort'], 'safe'],
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
        $query = EmpowermentProducts::find()->joinWith('translations');

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
                        [EmpowermentProducts::tableName().'.changed'=> 1],
                        ['!=', EmpowermentProducts::tableName().'.revision', -1],
                    ], 
                    [
                        'and',
                        [EmpowermentProducts::tableName().'.changed'=> 1],
                        ['!=', EmpowermentProducts::tableName().'.revision', 0],
                    ]
                ]
            ]
        );

        $query->andFilterWhere([
            EmpowermentProducts::tableName().'.id' => $this->id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            EmpowermentProducts::tableName().'.status' => $this->status,
        ]);
        


        if($this->published_at)
        {
            $startOfDay = strtotime($this->published_at . ' 00:00:00');
            $endOfDay = strtotime($this->published_at . ' 23:59:59');
            $query->andFilterWhere(['>=', 'published_at', $startOfDay])
                  ->andFilterWhere(['<=', 'published_at', $endOfDay]);
        }
        
        if($this->year)
        {
            $query->andFilterWhere(["(date_format(FROM_UNIXTIME(zakat_stories.`published_at` ), '%Y' ))" => $this->year]);
        }

        
        if($this->category_slug)
        {
            $query->joinWith(["category"]) // Alias category
            ->andFilterWhere(["dropdown_list.slug" => $this->category_slug]);

          
        }


        if($this->sort)
        {
            $sorts = explode("-", $this->sort);
            $query->orderBy([$sorts[0] => ($sorts[1] == SORT_ASC)? SORT_ASC : SORT_DESC, "weight"=>SORT_ASC]);
        }
        else
        {
            if (Yii::$app->id == 'frontend')
            {
                $query->orderBy(["empowerment_product.weight"=>SORT_ASC]);
            }

        }
        $query->andFilterWhere(['like', EmpowermentProducts::tableName().'title', $this->title]);

        $query->distinct(true);
        $query->groupBy(EmpowermentProducts::tableName().'.id');

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
            EmpowermentProducts::tableName().'.status' => 1
        ]);


        $query->andWhere(['or', ['like', 'title', $this->title], ['like', 'second_title', $this->brief], ['like', 'brief', $this->brief]]);

        return $dataProvider;
    }
}
