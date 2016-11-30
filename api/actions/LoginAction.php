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
use app\models\User;


class LoginAction extends Action
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

        $post = Yii::$app->request->post();
        if (!isset($post['username']) || !isset($post['password']))
        {
            throw new \yii\web\UnprocessableEntityHttpException();
            return;
        }

        $model = User::findOne(["username" => $post["username"]]);
        if (empty($model)) {
            throw new \yii\web\NotFoundHttpException('Invalid username/password combination');
        }
        if ($model->validatePassword($post["password"])) {
            $model->last_login = Yii::$app->formatter->asTimestamp(date_create());
            $model->generateAuthKey();
            $model->save(false);
            return ['access_token' => $model->auth_key,
                    'user' => $model];
        } else {
            throw new \yii\web\NotFoundHttpException('Invalid username/password combination');
        }
    }
}