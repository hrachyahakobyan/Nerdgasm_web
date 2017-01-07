<?php

namespace app\api\modules\v1\controllers;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;


class PagecategoryController extends ActiveController
{

    public $modelClass = 'app\models\PageCategory';

    public function behaviors()
    {
        $behav = parent::behaviors();
        $behav['authenticator'] = [
            'except' => ['view', 'index'],
            'class' => HttpBearerAuth::className(),
        ];
        return $behav;
    }
}

?>