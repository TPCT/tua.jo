<?php

namespace yeesoft\post\models\search;

use yeesoft\post\models\Post;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PostSearch represents the model behind the search form about `common\models\Post`.
 */
class PostSearch extends Post
{

    public $published_at_operand;
    public $year;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status', 'comment_status', 'revision', 'category_id', 'year'], 'integer'],
            [['published_at_operand', 'slug', 'title', 'content', 'published_at', 'created_at', 'updated_at'], 'safe'],
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
        $query = Post::find()->joinWith('translations')->groupBy(['id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => [
                    'published_at' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
            'comment_status' => $this->comment_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'revision' => $this->revision,
        ]);

        if($this->published_at)
        {
            if($this->published_at_operand == "=")
            {
                $yearItems = explode("-",$this->published_at);
                if(isset($yearItems[0]) && isset($yearItems[1]) && isset($yearItems[2]))
                {
                    $start = strtotime("{$yearItems[0]}-{$yearItems[1]}-{$yearItems[2]} 00:00");
                    $end = strtotime("{$yearItems[0]}-{$yearItems[1]}-{$yearItems[2]} 23:59");
                    $query->andFilterWhere(['between', Post::tableName().'.published_at', $start, $end]);
                }

            }
            else
            {
                $query->andFilterWhere([($this->published_at_operand) ? $this->published_at_operand : '=', 'published_at', ($this->published_at) ? strtotime($this->published_at) : null]);
            }

        }

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);

        if ($year = @$params['PostSearch']['year']){
            $start = strtotime("{$year}-01-01");
            $end = strtotime("{$year}-12-31");
            $query->andFilterWhere(['between', 'published_at', $start, $end]);

        }
//var_dump($query->createCommand()->rawSql);
        return $dataProvider;
    }

}
