<?php

namespace backend\modules\currency_price\models\search;

use backend\modules\currency_price\models\CurrencyPrice;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsSearch represents the model behind the search form about `common\models\News`.
 */
class CurrencyPriceSearch extends CurrencyPrice
{

    public $published_at_operand;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status',], 'integer'],
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
        $query = CurrencyPrice::find();

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
            CurrencyPrice::tableName() . '.created_by' => $this->created_by,
            CurrencyPrice::tableName() . '.updated_by' => $this->updated_by,
            CurrencyPrice::tableName() . '.status' => $this->status,
        ]);
        

        if ($this->published_at_operand && $this->published_at) {
            if ($this->published_at_operand === '='){
                $query->andFilterWhere(['>=', CurrencyPrice::tableName() . '.published_at', strtotime($this->published_at)]);
                $query->andFilterWhere(['<', CurrencyPrice::tableName() . '.published_at', strtotime($this->published_at)  +  24*3600]);
            }else{
                $query->andFilterWhere([$this->published_at_operand, CurrencyPrice::tableName() . '.published_at', strtotime($this->published_at)]);
            }
        }

        $query->groupBy('id');

        return $dataProvider;
    }

    public function basicSearch($params)
    {
        $query = self::find();

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


        return $dataProvider;
    }
}
