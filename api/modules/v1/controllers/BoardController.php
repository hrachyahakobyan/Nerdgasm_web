<?php

namespace app\api\modules\v1\controllers;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;


class BoardController extends ActiveController
{

    public $modelClass = 'app\models\Board';

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
        $actions['addContent'] = [
            'class' => 'app\api\actions\Board\AddContentAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['deleteContent'] = [
            'class' => 'app\api\actions\Board\DeleteContentAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }

    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['addContent'] = ['POST'];
        $verbs['deleteContent'] = ['DELETE'];
        return $verbs;
    }
}


?>