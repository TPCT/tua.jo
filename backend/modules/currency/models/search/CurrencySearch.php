<?php

namespace backend\modules\currency\models\search;

use backend\modules\currency\models\Currency;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsSearch represents the model behind the search form about `common\models\News`.
 */
class CurrencySearch extends Currency
{

    public $published_at_operand;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status',], 'integer'],
            [['title','brief'], 'string'],
            [['published_at_operand', 'published_at','section_ids'], 'safe'],
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
        $query = Currency::find()->joinWith('translations');

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

//        if (!$this->validate()) {
//            //var_dump($this->getErrors());die();
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }

        $query->andFilterWhere([
            'id' => $this->id,
            Currency::tableName() . '.created_by' => $this->created_by,
            Currency::tableName() . '.updated_by' => $this->updated_by,
            Currency::tableName() . '.status' => $this->status,
        ]);
        


        $query->andFilterWhere(['like', 'title', $this->title]);

        if ($this->published_at_operand && $this->published_at) {
            if ($this->published_at_operand === '='){
                $query->andFilterWhere(['>=', Currency::tableName() . '.published_at', strtotime($this->published_at)]);
                $query->andFilterWhere(['<', Currency::tableName() . '.published_at', strtotime($this->published_at)  +  24*3600]);
            }else{
                $query->andFilterWhere([$this->published_at_operand, Currency::tableName() . '.published_at', strtotime($this->published_at)]);
            }
        }

        $query->groupBy('id');

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
            'status' => 1
        ]);


        $query->andWhere(['or', ['like', 'title', $this->title], ['like', 'second_title', $this->brief], ['like', 'brief', $this->brief]]);

        return $dataProvider;
    }
}
