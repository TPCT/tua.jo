<?php

namespace common\models\search;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `yeesoft\models\User`.
 */
class UserSearch extends User
{
    public $number_of_dependent, $marital_status, $gender, $nationality, $fullName, $date_of_birth, $city, $place_of_residence, $mobile, $home_phone, $work_phone, $advance_notice;



    public $level_id, $institution_name, $program_name;
    public $certification_name;
    public $employer_name, $job_function;

    public function rules()
    {
        return [
            [['date_of_birth'], 'safe'],
            [['number_of_dependent', 'employer_name', 'job_function', 'nationality', 'place_of_residence', 'advance_notice', 'level_id', 'institution_name', 'program_name', 'certification_name'], 'integer'],
            [['username', 'email', 'fullName', 'gender', 'city', 'mobile', 'home_phone', 'work_phone', 'marital_status'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find();

        $query->with(['roles']);

        if (!Yii::$app->user->isSuperadmin) {
            $query->where(['superadmin' => 0]);
        }

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

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if($this->nationality || $this->date_of_birth || $this->city || $this->place_of_residence ||
            $this->mobile || $this->home_phone || $this->work_phone || $this->advance_notice || $this->marital_status || $this->number_of_dependent >= 0){
            $query->joinWith('personalInformation');
        }

        if($this->level_id || $this->institution_name || $this->program_name ){
            $query->joinWith('educations');
        }
        if($this->certification_name ){
            $query->joinWith('certificates');
        }
        if($this->job_function || $this->employer_name ){
            $query->joinWith('employeeHistories');
        }

//        if ($this->gridRoleSearch) {
//            $query->joinWith(['roles']);
//        }
//
        $query->andFilterWhere([
            'status' => $this->status,
            'nationality_id' => $this->nationality,
            'place_of_residence_id' => $this->place_of_residence,
            'advance_notice_id' => $this->advance_notice,
            'level_id' => $this->level_id,
            'institution_name' => $this->institution_name,
            'program_name' => $this->program_name,
            'certification_name' => $this->certification_name,
            'employer_name' => $this->employer_name,
            'job_function' => $this->job_function,
            'marital_status' => $this->marital_status,
            'number_of_dependent' => $this->number_of_dependent,
        ]);
//
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['OR' , ['like', 'first_name', $this->fullName], ['like', 'last_name', $this->fullName]])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'work_phone', $this->work_phone])
            ->andFilterWhere(['like', 'home_phone', $this->home_phone])
            ->andFilterWhere(['like', 'city', $this->city]);

        if($this->date_of_birth){
            $dateRang = explode(' - ', $this->date_of_birth);
            $query->andFilterWhere(['between', 'date_of_birth',  $dateRang[0] ,  $dateRang[1]]);
        }

//var_dump($query->createCommand()->rawSql);
        return $dataProvider;
    }

}