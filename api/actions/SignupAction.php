<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\api\actions;

use Yii;
use yii\rest\Action;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use app\models\UserSignupForm;


class SignupAction extends Action
{
    /**
     * @var string the scenario to be assigned to the new model before it is validated and saved.
     */
    public $scenario = Model::SCENARIO_DEFAULT;

    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $model = new UserSignupForm();
        if ($model->load(Yii::$app->request->post(), ''))
        {
            if ($user = $model->signup())
            {
                Yii::$app->response->statusCode = 422;
            }
            else
            {
                Yii::$app->response->statusCode = 423;
                return ['data' =>
                    ['errors' => $model->getErrors()]
                ];
            }
        }
        else
        {
            $model->validate();
            Yii::$app->response->statusCode = 422;
            return ['data' =>
                ['errors' => $model->getErrors()]
            ];
        }
    }
}
