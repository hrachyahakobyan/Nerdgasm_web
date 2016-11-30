<?php

namespace app\api\modules\v1\controllers;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\filters\VerbFilter;


class CategoryController extends ActiveController
{

    public $modelClass = 'app\models\Category';

    public function behaviors()
    {
        $behav = parent::behaviors();
        $behav['authenticator'] = [
            'except' => ['view', 'index', 'pages'],
            'class' => HttpBearerAuth::className(),
        ];
        return $behav;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['pages'] = [
            'class' => 'app\api\actions\Category\PagesAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['image'] = [
            'class' => 'app\api\actions\Category\ImageAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }

    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['pages'] = ['GET'];
        $verbs['image'] = ['POST', 'DELETE'];
        return $verbs;
    }
}

?>