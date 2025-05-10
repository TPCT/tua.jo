<?php

namespace backend\modules\recurring_items\models\search;

use backend\modules\recurring_items\models\RecurringItems;
use Minify\App;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RecurringItemsSearch represents the model behind the search form about `backend\modules\webforms\models\RecurringItemsSearch`.
 */
class RecurringItemsSearch extends RecurringItems
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [[ 'name','amount','phone','email', 'created_at'], 'safe'],
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
        $query = RecurringItems::find();

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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        if($this->created_at){
            $dateRang = explode(' - ', $this->created_at);
            $query->andWhere(['between', 'created_at', strtotime($dateRang[0] . ' 00:00'), strtotime($dateRang[1] . ' 23:59')]);
        }

        $query
        ->andFilterWhere(['like', 'name', $this->name])
        ->andFilterWhere(['like', 'email', $this->email])
        ->andFilterWhere(['like', 'phone', $this->phone])
        ->andFilterWhere(['like', 'amount', $this->amount]);

        return $dataProvider;
    }
}
