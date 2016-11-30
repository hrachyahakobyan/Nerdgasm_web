<?php

namespace app\api\modules\v1\controllers;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\filters\VerbFilter;


class ArticleController extends ActiveController
{

    public $modelClass = 'app\models\Article';

    public function behaviors()
    {
        $behav = parent::behaviors();
        $behav['authenticator'] = [
            'except' => ['view', 'index', 'comments'],
            'class' => HttpBearerAuth::className(),
        ];
        return $behav;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['create'] = [
            'class' => 'app\api\actions\Articles\CreateArticleAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['view'] = [
            'class' => 'app\api\actions\Articles\ViewAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['index'] = [
            'class' => 'app\api\actions\Articles\IndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['comments'] = [
            'class' => 'app\api\actions\Articles\CommentsAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }

    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['comments'] = ['GET'];
        return $verbs;
    }
}

?>