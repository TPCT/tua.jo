<?php
namespace common\components;

use backend\modules\revisions\models\Revision;
use Yii;
use DateTime;
use yeesoft\helpers\Html;
use yii\helpers\Url;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\db\ActiveQuery;
use yii\widgets\DetailView;

trait RevisionTrait
{
    //query model
    public function getChanged()
    {
        $user = Yii::$app->user->identity;
        
        if (\yeesoft\models\User::hasPermission('checker', false) || $user->superadmin )
        {
            return $this->getChangedChecker();
        }
        else if(\yeesoft\models\User::hasPermission('maker', false) )
        {
            return $this->getChangedMaker();
        }
        return $this->andWhere(["id"=>0]); // return nothing
    }

    private function getChangedMaker()// rejected
    {
        $this->andWhere(['changed' => [0,1]])//0 for new rejected elemnts 1 for updated rejected elements
                ->andWhere(["!=","revision",0])
                ->andWhere(["or",["!=","reject_note",""], ["reject_note"=>!NULL]]);
        return $this;
    }

    private function getChangedChecker() 
    {
        $this->andWhere(['changed' => 1])
             ->andWhere(["or",["revision"=>0], ["revision"=>-1] ]);
        //var_dump($this->createCommand()->rawSql);exit;
        return $this;
    }



    //model
        /**
     * @return mixed
     */
    public function getDiffHtml()
    {

        $values = $this->attributes;
        $arr=[];
        foreach($this->langualAttributes as $atr)
        {
            $arr[$atr."_en"]=$this[$atr."_en"]; 
        }
        foreach($this->langualAttributes as $atr)
        {
            $arr[$atr."_ar"]=$this[$atr."_ar"]; 
        }
        //relational 
        foreach($this->additionalAttributes as $atr)
        {
            $arr[$atr]=$this[$atr]; 
        }
        $values = array_merge($values,$arr);

        $parent_id = Yii::$app->getRequest()->getQueryParam('parent_id');
        
        if($parent_id == -1) //new creation from maker
        {
            $keys=[];
            foreach ($values as $key => $attr) 
            {
                if(in_array($key,$this->ignoreAttributes))
                {
                    continue;
                }
                $keys[] = $key;
            }
            $diffAll = DetailView::widget([
                'model' => $this,
                'attributes' => $keys,
            ]);
            

            return $diffAll;
        }
        $table_name = self::tableName();
        $parent = self::find()->joinWith('translations')->where([$table_name.".id" => $parent_id])->one();
        
        $diffAll = '';
        foreach ($values as $key => $attr) 
        {
            if(in_array($key,$this->ignoreAttributes))
            {
                continue;
            }
            $old = explode("\n", $parent->$key);
            $new = explode("\n", $this->$key);
            foreach ($old as $i => $line) {
                $old[$i] = rtrim($line, "\r\n");
            }
            foreach ($new as $i => $line) {
                $new[$i] = rtrim($line, "\r\n");
            }
            $diff = new \Diff($old, $new);

            $label = $this->attributeLabels()[$key] ?: $key;
            
            if($diff->render(new \Diff_Renderer_Html_SideBySide))
            {
                $diffAll .= "<h3 class='text-capitalize'>{$label}</h3>" . $diff->render(new \Diff_Renderer_Html_SideBySide) . '<hr>';
            }
                
            
        }
        return $diffAll;
    }
    

    public function getLabelChanged()
    {
        $changed = "";
        // if ($this->IsAcceeptChange()) 
        // {
        //     $changed = " - Changed";
        // }
        // elseif ($this->IsCreateNewFromMaker() ) 
        if ($this->IsCreatedFromMaker() ) 
        {
            $changed = " - New Not Reviewed";
        }
        elseif ($this->IsUpdatedFromMaker() ) 
        {
            $changed = " - Changed Not Reviewed";
        }
        elseif ($this->IsNewItemRejected() ) 
        {
            $changed = " - New Item Rejected from Checker";
        }
        elseif ($this->IsChangedItemRejected() ) 
        {
            $changed = " - Changed Item Rejected from Checker";
        }
        elseif ($this->IsOldChangedFromMaker()) 
        {
            $changed = " - Old Item New one:".$this->revision;
        } 
        /*elseif (!$this->revision && $this->status && !$this->changed) {
            $changed = " - New";
        }*/
        return $changed;
    }

    public function IsAcceeptChange()
    {
        if($this->changed && $this->revision==0 && $this->status)
        {
            return true;
        }
        return false;
    }

    public function IsCreatedFromMaker()
    {
        if($this->changed && $this->revision==-1 && !$this->status && !$this->IsRejected() )
        {
            return true;
        }
        return false;
    }

    public function IsRejected()
    {
        if($this->reject_note != "" || $this->reject_note != null)
        {
            return true;
        }
        return false;
    }

    public function IsUpdatedFromMaker()
    {
        if(!$this->changed && $this->revision!=0 && !$this->status && !$this->IsRejected() )
        {
            return true;
        }
        return false;
    }

    public function IsNewItemRejected()
    {
        if($this->changed && $this->revision==-1 && !$this->status && $this->IsRejected() )
        {
            return true;
        }
        return false;
    }
    public function IsChangedItemRejected()
    {
        if(!$this->changed && $this->revision!=0 && !$this->status && $this->IsRejected() )
        {
            return true;
        }
        return false;
    }

    public function IsOldChangedFromMaker()
    {
        if($this->changed && $this->revision && !$this->status)
        {
            return true;
        }
        return false;
    }




    public function canMakerSeeStatus()
    {
        $allow = true;
        if(\yeesoft\models\User::hasPermission('maker', false)) //maker
        {
            $revisions = Revision::find()->all();
            $revisions = ArrayHelper::map($revisions,"id","model");
            if(in_array($this::className(),$revisions))
            {
                $allow = false;
            }
        }

        return $allow;
    }


    public function revisionButton()
    {
        return Html::a(
                        Yii::t('site', 'Revisions'),
                        Url::to(["/" . Yii::$app->controller->module->id . "/". Yii::$app->controller->id ."/view", 'id' => $this->id, 'parent_id' => $this->revision, 'type' => Yii::$app->controller->module->id]), 
                        [
                            'title' => Yii::t('site', 'Revisions'),
                            'data-pjax' => '0'
                        ]
                    );
    }


    public function historyButton()
    {
        return Html::a(
                        Yii::t('site', 'History'),
                        Url::to(["/" . Yii::$app->controller->module->id . "/". Yii::$app->controller->id ."/history", 'id' => $this->id]), 
                        [
                            'title' => Yii::t('site', 'History'),
                            'data-pjax' => '0'
                        ]
                    );
    }


}