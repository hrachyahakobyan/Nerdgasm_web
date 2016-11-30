<?php

namespace app\api\modules\v1\controllers;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;


class UserController extends ActiveController
{

    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        $behav = parent::behaviors();
        $behav['authenticator'] = [
            'except' => ['login', 'create', 'username', 'index', 'view', 'search'],
            'class' => HttpBearerAuth::className(),
        ];
        return $behav;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['options']);
        $actions['login'] = [
            'class' => 'app\api\actions\LoginAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['search'] = [
            'class' => 'app\api\actions\SearchAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['logout'] = [
            'class' => 'app\api\actions\LogoutAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['username'] = [
            'class' => 'app\api\actions\UsernameAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }

    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['login'] = ['POST'];
        $verbs['logout'] = ['POST'];
        $verbs['username'] = ['POST'];
        $verbs['search'] = ['GET'];
        return $verbs;
    }
}

?>