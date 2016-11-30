<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\api\actions\Me;

use Yii;
use app\models\User;
use yii\rest\Action;
use yii\base\Model;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\web\ServerErrorHttpException;
use app\components\Helper;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ThreadsAction extends Action
{
    public function run()
    {
        if ($this->checkAccess)
        {
            call_user_func($this->checkAccess, $this->id);
        }
        $query = Yii::$app->user->identity->getThreads()->with('posts');
        return new ActiveDataProvider([
            'query' => $query
        ]);
    }
}
