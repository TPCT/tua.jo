<?php

namespace backend\modules\transaction\models\search;

use backend\modules\transaction\models\Transaction;
use Minify\App;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TransactionSearch represents the model behind the search form about `backend\modules\webforms\models\TransactionSearch`.
 */
class TransactionSearch extends Transaction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['first_name', 'last_name', 'email','phone','amount' , 'type' , 'payment_id'  ,'created_at'], 'safe'],
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
        $query = Transaction::find();

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


        $query->andFilterWhere(['like', 'email', $this->email])
        ->andFilterWhere(['like', 'phone', $this->phone])
        ->andFilterWhere(['like', 'amount', $this->amount])
        ->andFilterWhere(['like', 'type', $this->type])
        ->andFilterWhere(['like', 'payment_id', $this->payment_id])
    
         
        ->andFilterWhere(['like', 'first_name', $this->first_name])
        ->andFilterWhere(['like', 'last_name', $this->last_name]);


        return $dataProvider;
    }
}
