<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/1/2016
 * Time: 2:54 PM
 */

namespace app\api\actions;

use Yii;
use yii\rest\Action;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use app\models\User;

class UsernameAction extends Action
{
    public $scenario = Model::SCENARIO_DEFAULT;

    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $post = Yii::$app->request->post();
        if (!isset($post['username']))
        {
            throw new \yii\web\UnprocessableEntityHttpException();
        }

        $model = User::findOne(["username" => $post["username"]]);
        $data = array();
        $data['username_exists'] = !empty($model);
        return $data;
    }
}