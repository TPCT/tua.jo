<?php

namespace yeesoft\models;

use Exception;
use yeesoft\helpers\AuthHelper;
use Yii;
use yii\rbac\DbManager;

class Permission extends AbstractItem
{

    const ITEM_TYPE = self::TYPE_PERMISSION;

    /**
     * @param int $userId
     *
     * @return array|\yii\rbac\Permission[]
     */
    public static function getUserPermissions($userId)
    {
        return (new DbManager())->getPermissionsByUser($userId);
    }

    /**
     * Assign route to permission and create them if they don't exists
     * Helper mainly for migrations
     *
     * @param string $permissionName
     * @param array|string $routes
     * @param null|string $permissionDescription
     * @param null|string $groupCode
     *
     * @throws \InvalidArgumentException
     * @return true|static|string
     */
    public static function assignRoutes($permissionName, $routes, $permissionDescription = null, $groupCode = null)
    {
        $permission = static::findOne(['name' => $permissionName]);
        $routes = (array) $routes;

        if (!$permission) {
            $permission = static::create($permissionName, $permissionDescription, $groupCode);

            if ($permission->hasErrors()) {
                return $permission;
            }
        }

        foreach ($routes as $route) {
            $route = '/' . ltrim($route, '/');
            try {
                Yii::$app->db->createCommand()
                        ->insert(Yii::$app->yee->auth_item_child_table, [
                            'parent' => $permission->name,
                            'child' => $route,
                        ])->execute();
            } 
            catch (Exception $e) 
            {
                // Don't throw Exception because this permission may already have this route,
                // so just go to the next route
                error_log($e->getMessage());
            }
        }

        AuthHelper::invalidatePermissions();

        return true;
    }


    public function getController()
    {
        $parts = explode("/",$this->name);
        if(count($parts) == 4)
        {
            return $parts[2];    
        }
    }

    public function getControllers()
    {
        return
            self::find()->where(["module"=>$this->module])
            ->andWhere(['like', 'name', '/' . $this->module . '/%/*', false])
            ->all();
            
    }

    public function getActions()
    {
        return
            self::find()->where(["module"=>$this->module])
            ->andWhere(['like', 'name', '/' . $this->module . '/'.$this->controller.'/%', false])
            ->andWhere(['not like', 'name', '/' . $this->module . '/'.$this->controller.'/*', false])
            ->all();
            
    }


    public function getMainControllerName()
    {
        $parts = explode("/",$this->name);
        if(count($parts) == 3)
        {
            return $parts[1];    
        }
    }


    public function getMainControllers()
    {
        return
            self::find()->where(["module"=> "MainControllers"])
            ->andWhere(['like', 'name', '/%/*', false])
            ->all();
            
    }

    public function getMainControllerActions()
    {
        return
            self::find()->where(["module"=>"MainControllers"])
            ->andWhere(['like', 'name', '/'.$this->mainControllerName.'/%', false])
            ->andWhere(['not like', 'name', '/'.$this->mainControllerName.'/*', false])
            ->all();
            
    }


}
