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
use app\models\User;
use app\components\Helper;


class LogoutAction extends Action
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
        $bearer = Helper::getBearer();
        if (!$bearer)
            throw new \yii\web\UnauthorizedHttpException();
        $user = User::findIdentityByAccessToken($bearer);
        /**
         *  Should never take place, otherwise, bearer authenticaion is not working
         */
        if ($user === null){
            throw new \yii\web\UnauthorizedHttpException();
        }

        /**
         *  Already logged out
         */
        if (!isset($user->auth_key) || $user->auth_key == ''){
            return;
        }

        $user->auth_key = '';
        $user->save();
        Yii::$app->response->statusCode = 204;
    }
}