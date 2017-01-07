<?php

namespace app\api\modules\v1\controllers;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\filters\VerbFilter;


class PageController extends ActiveController
{

    public $modelClass = 'app\models\Page';

    public function behaviors()
    {
        $behav = parent::behaviors();
        $behav['authenticator'] = [
            'except' => ['view', 'index', 'articles', 'threads', 'viewCategory'],
            'class' => HttpBearerAuth::className(),
        ];
        return $behav;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['articles'] = [
            'class' => 'app\api\actions\Page\ArticlesAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['image'] = [
            'class' => 'app\api\actions\Page\ImageAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['threads'] = [
            'class' => 'app\api\actions\Page\ThreadsAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['viewCategory'] = [
            'class' => 'app\api\actions\Page\ViewCategoryAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['createCategory'] = [
            'class' => 'app\api\actions\Page\CreateCategoryAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['deleteCategory'] = [
            'class' => 'app\api\actions\Page\DeleteCategoryAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }

    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['articles'] = ['GET'];
        $verbs['threads'] = ['GET'];
        $verbs['image'] = ['POST', 'DELETE'];
        $verbs['createCategory'] = ['POST'];
        $verbs['viewCategory'] = ['GET'];
        $verbs['deleteCategory'] = ['DELETE'];
        return $verbs;
    }
}

?>