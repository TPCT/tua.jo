<?php

namespace backend\modules\beneficiaries_countries\models\search;

use backend\modules\beneficiaries_countries\models\BeneficiariesCountries;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BeneficiariesCountriesSearch represents the model behind the search form about `common\models\AnnualReport`.
 */
class BeneficiariesCountriesSearch extends BeneficiariesCountries
{

    public $published_at_operand;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['title', 'brief'], 'string'],
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
        $query = BeneficiariesCountries::find()->joinWith('translations');

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
           //var_dump($this->getErrors());die();
           // uncomment the following line if you do not want to return any records when validation fails
           // $query->where('0=1');
           return $dataProvider;
       }

//        $query->andFilterWhere(
//            ['not',
//                ['and',
//                    [
//                        'and',
//                        [BeneficiariesCountries::tableName().'.changed'=> 1],
//                        ['!=', BeneficiariesCountries::tableName().'.revision', -1],
//                    ],
//                    [
//                        'and',
//                        [BeneficiariesCountries::tableName().'.changed'=> 1],
//                        ['!=', BeneficiariesCountries::tableName().'.revision', 0],
//                    ]
//                ]
//            ]
//        );

        $query->andFilterWhere([
            BeneficiariesCountries::tableName().'.id' => $this->id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            BeneficiariesCountries::tableName().'.status' => $this->status,
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
                    $query->andFilterWhere(['between', BeneficiariesCountries::tableName().'.published_at', $start, $end]);
                }

            }
            else
            {
                $query->andFilterWhere([($this->published_at_operand) ? $this->published_at_operand : '=', 'published_at', ($this->published_at) ? strtotime($this->published_at) : null]);
            }

        }

        $query->andFilterWhere(['like', 'title', $this->title]);

        $query->distinct(true);
        $query->groupBy(BeneficiariesCountries::tableName().'.id');

        //var_dump($query->createCommand()->rawSql); exit;

        return $dataProvider;
    }


    public function basicSearch($params)
    {
        $query = self::find()->joinWith('translations');

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
            BeneficiariesCountries::tableName().'.status' => 1
        ]);


        $query->andWhere(['or', ['like', 'title', $this->title], ['like', 'brief', $this->brief]]);

        return $dataProvider;
    }
}
