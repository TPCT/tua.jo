<?php

namespace backend\modules\revisions\models\search;

use Yii;
use backend\modules\revisions\models\Revision;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RevisionOldSearch represents the model behind the search form about `common\models\News`.
 */
class RevisionOldSearch extends Revision
{
    public $published_at_operand;
    public $year;
    public $order_by;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status', 'revision','region_id'], 'integer'],
            [['slug', 'title', 'content', 'content_2', 'published_at', 'created_at', 'updated_at'], 'safe'],
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

        
        $type = Yii::$app->getRequest()->getQueryParam('type');
        switch ($type) {
            case 'news':
                $modelClass = 'backend\modules\news\models\News';
                $langClassName = 'backend\modules\news\models\search\NewsSearchLang';
                break;
        }
        $parent_id = Yii::$app->getRequest()->getQueryParam('parent_id');
        
        $query = $modelClass::find()->joinWith('translations');

        
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
        
        
        // $this->load($params);

        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     // $query->where('0=1');
        //     return $dataProvider;
        // }

        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'created_by' => $this->created_by,
        //     'updated_by' => $this->updated_by,
        //     'status' => $this->status,
        //     // 'comment_status' => $this->comment_status,
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        //     'revision' => $this->revision,
        // ]);

        // $query->andFilterWhere([($this->published_at_operand) ? $this->published_at_operand : '=', 'published_at', ($this->published_at) ? strtotime($this->published_at) : null]);

        // $query->andFilterWhere(['like', 'slug', $this->slug])
        //     ->andFilterWhere(['like', 'title', $this->title])
        //     ->andFilterWhere(['like', 'content', $this->content])
        //     ->andFilterWhere(['like', 'content_2', $this->content_2]);

        
        
            echo "<pre>";
            \yii\helpers\VarDumper::dump('$variable' ,  $dept = 10,  $highlight = true);
            die();
        
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
        $query = Revision::find()->joinWith('translations');

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


        $query->andWhere(['or', ['like', 'title', $this->title], ['like', 'content', $this->title], ['like', 'content_2', $this->title], ['like', 'brief', $this->title]]);

        return $dataProvider;
    }

}
