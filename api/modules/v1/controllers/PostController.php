<?php

namespace app\api\modules\v1\controllers;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;


class PostController extends ActiveController
{

    public $modelClass = 'app\models\Post';

    public function behaviors()
    {
        $behav = parent::behaviors();
        $behav['authenticator'] = [
            'except' => ['view', 'index'],
            'class' => HttpBearerAuth::className(),
        ];
        return $behav;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index'] = [
            'class' => 'app\api\actions\Posts\IndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }
}

?>