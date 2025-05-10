<?php

namespace common\models;

use yeesoft\page\models\Page;
use yeesoft\page\models\search\PageSearch;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PageSearch represents the model behind the search form about `yeesoft\page\models\Page`.
 */
class CustomPageSearch extends PageSearch
{


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function basicSearch($params)
    {
        $lng = Yii::$app->language;
        $query = Page::find()->joinWith('translations');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'published_at' => SORT_DESC,
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
            'page_lang.status' => 1,
            'language' => $lng
        ]);

        $query->andWhere(['or', ['like', 'title', $this->title], ['like', 'content', $this->content]]);


        return $dataProvider;
    }

}
