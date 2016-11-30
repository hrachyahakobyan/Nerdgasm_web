<?php

namespace app\api\modules\v1\controllers;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;


class ThreadController extends ActiveController
{

    public $modelClass = 'app\models\Thread';

    public function behaviors()
    {
        $behav = parent::behaviors();
        $behav['authenticator'] = [
            'except' => ['view', 'index', 'posts', 'addview'],
            'class' => HttpBearerAuth::className(),
        ];
        return $behav;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['posts'] = [
            'class' => 'app\api\actions\Threads\PostsAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['index'] = [
            'class' => 'app\api\actions\Threads\IndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['addview'] = [
            'class' => 'app\api\actions\Threads\AddViewAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }

    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['posts'] = ['GET'];
        $verbs['addview'] = ['POST'];
        return $verbs;
    }
}

?>