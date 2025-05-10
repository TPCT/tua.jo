<?php

namespace backend\modules\dropdown_list\models\search;

use backend\modules\dropdown_list\models\DropdownList;
use common\helpers\Utility;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsSearch represents the model behind the search form about `common\models\News`.
 */
class DropdownListSearch extends DropdownList
{
    public $published_at_operand;
    public $word;
    public $donationTitle;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['title','word','category','donationTitle'], 'string'],
            [['published_at', 'published_at_operand'], 'safe'],
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
        $query = DropdownList::find()->joinWith('translations');

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

        $query->andFilterWhere([($this->published_at_operand) ? $this->published_at_operand : '=', 'published_at', ($this->published_at) ? strtotime($this->published_at) : null]);


        $query->andFilterWhere([
            'dropdown_list.id' => $this->id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'category' => $this->category,
            DropdownList::tableName().'.status' => $this->status,
        ]);


        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'slug', $this->donationTitle]);

        $query->groupBy('id');

        
        //echo ($query->createCommand()->rawSql); die;

        return $dataProvider;
    }
    

    public function basicSearch($params)
    {
        $query = DropdownList::find()->joinWith('translations');

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
            DropdownList::tableName().'.status' => Utility::STATUS_PUBLISHED,
            'category' => $this->category,
        ]);


        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'slug', $this->donationTitle]);

        if($this->published_at)
        {
            if($this->published_at_operand == "=")
            {
                $yearItems = explode("-",$this->published_at);
                if(isset($yearItems[0]) && isset($yearItems[1]) && isset($yearItems[2]))
                {
                    $start = strtotime("{$yearItems[0]}-{$yearItems[1]}-{$yearItems[2]} 00:00");
                    $end = strtotime("{$yearItems[0]}-{$yearItems[1]}-{$yearItems[2]} 23:59");
                    $query->andFilterWhere(['between', DropdownList::tableName().'.published_at', $start, $end]);
                }

            }
            else
            {
                $query->andFilterWhere([($this->published_at_operand) ? $this->published_at_operand : '=', 'published_at', ($this->published_at) ? strtotime($this->published_at) : null]);
            }

        }

        $query->groupBy('id');

        return $dataProvider;
    }

}
