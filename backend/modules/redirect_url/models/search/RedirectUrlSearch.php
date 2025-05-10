<?php

namespace backend\modules\redirect_url\models\search;

use backend\modules\redirect_url\models\RedirectUrl;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsSearch represents the model behind the search form about `common\models\News`.
 */
class RedirectUrlSearch extends RedirectUrl
{

    public $published_at_operand;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_code_from','status_code_to', 'created_by', 'updated_by', 'status'], 'integer'],
            [['url_from', 'url_to'], 'string', 'max'=>255 ],
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
        $query = RedirectUrl::find();

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
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        


        $query->andFilterWhere(['like', 'url_from', $this->url_from]);
        $query->andFilterWhere(['like', 'url_to', $this->url_to]);
        $query->andFilterWhere(['like', 'status_code_from', $this->status_code_from]);
        $query->andFilterWhere(['like', 'status_code_to', $this->status_code_to]);

        if($this->published_at_operand)
        {
            if($this->published_at)
            {
                if($this->published_at_operand == "=")
                {
                    $yearItems = explode("-",$this->published_at);
                    if(isset($yearItems[0]) && isset($yearItems[1]) && isset($yearItems[2]))
                    {
                        $start = strtotime("{$yearItems[0]}-{$yearItems[1]}-{$yearItems[2]} 00:00");
                        $end = strtotime("{$yearItems[0]}-{$yearItems[1]}-{$yearItems[2]} 23:59");
                        $query->andFilterWhere(['between', RedirectUrl::tableName().'.published_at', $start, $end]);
                    }

                }
                else
                {
                    $query->andFilterWhere([($this->published_at_operand) ? $this->published_at_operand : '=', 'published_at', ($this->published_at) ? strtotime($this->published_at) : null]);
                }

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


        $query->andWhere(['or', ['like', 'title', $this->title] ]);

        return $dataProvider;
    }
}
