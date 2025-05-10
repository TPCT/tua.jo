<?php

namespace yeesoft\user\models\search;

use yeesoft\models\Route;
use Yii;
use yii\data\ActiveDataProvider;

class RouteSearch extends AbstractItemSearch
{
    const ITEM_TYPE = self::TYPE_ROUTE;

    public function rules()
    {
        return [
            [['name', 'module', 'action'], 'string'],
        ];
    }
    public function search($params)
    {
        $query = Route::find();

        $query->joinWith(['group']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', Yii::$app->yee->auth_item_table . '.name', $this->name])
        ->andFilterWhere(['like', Yii::$app->yee->auth_item_table . '.module', $this->module])
        ->andFilterWhere(['like', Yii::$app->yee->auth_item_table . '.action', $this->action]);

        return $dataProvider;
    }

}