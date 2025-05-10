<?php

namespace backend\modules\webforms\models\search;

use backend\modules\webforms\models\RatingWebform;
use Minify\App;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ContactUsWebformSearch represents the model behind the search form about `backend\modules\webforms\models\ContactUsWebform`.
 */
class RatingWebformSearch extends RatingWebform
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['created_at'], 'safe'],
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
        $query = RatingWebform::find();

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



        return $dataProvider;
    }
}
