<?php

namespace app\api\modules\v1\controllers;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\web\Response;


class MeController extends ActiveController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        $behav = parent::behaviors();
        $behav['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];
        return $behav;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['options'], $actions['view'], $actions['create']);
        $actions['index'] = [
            'class' => 'app\api\actions\Me\IndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['update'] = [
            'class' => 'app\api\actions\Me\UpdateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['post'] = [
            'class' => 'app\api\actions\Me\CreatePostAction',
            'modelClass' => 'app\models\Post',
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['posts'] = [
            'class' => 'app\api\actions\Me\PostsAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['threads'] = [
            'class' => 'app\api\actions\Me\ThreadsAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['thread'] = [
            'class' => 'app\api\actions\Me\CreateThreadAction',
            'modelClass' => 'app\models\Thread',
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['avatar'] = [
            'class' => 'app\api\actions\Me\AvatarAction',
            'modelClass' => 'app\models\User',
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['deleteBoard'] = [
            'class' => 'app\api\actions\Me\DeleteBoardAction',
            'modelClass' => 'app\models\Board',
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['createBoard'] = [
            'class' => 'app\api\actions\Me\CreateBoardAction',
            'modelClass' => 'app\models\Board',
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['updateBoard'] = [
            'class' => 'app\api\actions\Me\UpdateBoardAction',
            'modelClass' => 'app\models\Board',
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['boardImage'] = [
            'class' => 'app\api\actions\Me\BoardImageAction',
            'modelClass' => 'app\models\Board',
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['boards'] = [
            'class' => 'app\api\actions\Me\IndexBoardAction',
            'modelClass' => 'app\models\Board',
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['viewBoards'] = [
            'class' => 'app\api\actions\Me\ViewBoardAction',
            'modelClass' => 'app\models\Board',
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['boardContent'] = [
            'class' => 'app\api\actions\Me\BoardContentAction',
            'modelClass' => 'app\models\Board',
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }

    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['update'] = ['POST'];
        $verbs['posts'] = ['GET'];
        $verbs['threads'] = ['GET'];
        $verbs['post'] = ['POST'];
        $verbs['thread'] = ['POST'];
        $verbs['avatar'] = ['POST', 'DELETE'];
        $verbs['deleteBoard'] = ['DELETE'];
        $verbs['createBoard'] = ['POST'];
        $verbs['updateBoard'] = ['PUT'];
        $verbs['boardImage'] = ['DELETE', 'POST'];
        $verbs['boards'] = ['GET'];
        $verbs['viewBoards'] = ['GET'];
        $verbs['boardContent'] = ['POST', 'DELETE', 'GET'];
        return $verbs;
    }
}

?>